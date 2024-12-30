<?php
/**
 * The template to display single post
 *
 * @package JIGSAW
 * @since JIGSAW 1.0
 */

// Full post loading
$full_post_loading          = jigsaw_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = jigsaw_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = jigsaw_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$jigsaw_related_position   = jigsaw_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$jigsaw_posts_navigation   = jigsaw_get_theme_option( 'posts_navigation' );
$jigsaw_prev_post          = false;
$jigsaw_prev_post_same_cat = jigsaw_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( jigsaw_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	jigsaw_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'jigsaw_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $jigsaw_posts_navigation ) {
		$jigsaw_prev_post = get_previous_post( $jigsaw_prev_post_same_cat );  // Get post from same category
		if ( ! $jigsaw_prev_post && $jigsaw_prev_post_same_cat ) {
			$jigsaw_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $jigsaw_prev_post ) {
			$jigsaw_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $jigsaw_prev_post ) ) {
		jigsaw_sc_layouts_showed( 'featured', false );
		jigsaw_sc_layouts_showed( 'title', false );
		jigsaw_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $jigsaw_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/content', 'single-' . jigsaw_get_theme_option( 'single_style' ) ), 'single-' . jigsaw_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $jigsaw_related_position, 'inside' ) === 0 ) {
		$jigsaw_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'jigsaw_action_related_posts' );
		$jigsaw_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $jigsaw_related_content ) ) {
			$jigsaw_related_position_inside = max( 0, min( 9, jigsaw_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $jigsaw_related_position_inside ) {
				$jigsaw_related_position_inside = mt_rand( 1, 9 );
			}

			$jigsaw_p_number         = 0;
			$jigsaw_related_inserted = false;
			$jigsaw_in_block         = false;
			$jigsaw_content_start    = strpos( $jigsaw_content, '<div class="post_content' );
			$jigsaw_content_end      = strrpos( $jigsaw_content, '</div>' );

			for ( $i = max( 0, $jigsaw_content_start ); $i < min( strlen( $jigsaw_content ) - 3, $jigsaw_content_end ); $i++ ) {
				if ( $jigsaw_content[ $i ] != '<' ) {
					continue;
				}
				if ( $jigsaw_in_block ) {
					if ( strtolower( substr( $jigsaw_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$jigsaw_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $jigsaw_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $jigsaw_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$jigsaw_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $jigsaw_content[ $i + 1 ] && in_array( $jigsaw_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$jigsaw_p_number++;
					if ( $jigsaw_related_position_inside == $jigsaw_p_number ) {
						$jigsaw_related_inserted = true;
						$jigsaw_content = ( $i > 0 ? substr( $jigsaw_content, 0, $i ) : '' )
											. $jigsaw_related_content
											. substr( $jigsaw_content, $i );
					}
				}
			}
			if ( ! $jigsaw_related_inserted ) {
				if ( $jigsaw_content_end > 0 ) {
					$jigsaw_content = substr( $jigsaw_content, 0, $jigsaw_content_end ) . $jigsaw_related_content . substr( $jigsaw_content, $jigsaw_content_end );
				} else {
					$jigsaw_content .= $jigsaw_related_content;
				}
			}
		}

		jigsaw_show_layout( $jigsaw_content );
	}

	// Comments
	do_action( 'jigsaw_action_before_comments' );
	comments_template();
	do_action( 'jigsaw_action_after_comments' );

	// Related posts
	if ( 'below_content' == $jigsaw_related_position
		&& ( 'scroll' != $jigsaw_posts_navigation || jigsaw_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || jigsaw_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'jigsaw_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $jigsaw_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $jigsaw_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $jigsaw_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $jigsaw_prev_post ) ); ?>"
			<?php do_action( 'jigsaw_action_nav_links_single_scroll_data', $jigsaw_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
