<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package JIGSAW
 * @since JIGSAW 1.0
 */

$jigsaw_template_args = get_query_var( 'jigsaw_template_args' );
$jigsaw_columns = 1;
if ( is_array( $jigsaw_template_args ) ) {
	$jigsaw_columns    = empty( $jigsaw_template_args['columns'] ) ? 1 : max( 1, $jigsaw_template_args['columns'] );
	$jigsaw_blog_style = array( $jigsaw_template_args['type'], $jigsaw_columns );
	if ( ! empty( $jigsaw_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $jigsaw_columns > 1 ) {
	    $jigsaw_columns_class = jigsaw_get_column_class( 1, $jigsaw_columns, ! empty( $jigsaw_template_args['columns_tablet']) ? $jigsaw_template_args['columns_tablet'] : '', ! empty($jigsaw_template_args['columns_mobile']) ? $jigsaw_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $jigsaw_columns_class ); ?>">
		<?php
	}
} else {
	$jigsaw_template_args = array();
}
$jigsaw_expanded    = ! jigsaw_sidebar_present() && jigsaw_get_theme_option( 'expand_content' ) == 'expand';
$jigsaw_post_format = get_post_format();
$jigsaw_post_format = empty( $jigsaw_post_format ) ? 'standard' : str_replace( 'post-format-', '', $jigsaw_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $jigsaw_post_format ) );
	jigsaw_add_blog_animation( $jigsaw_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$jigsaw_hover      = ! empty( $jigsaw_template_args['hover'] ) && ! jigsaw_is_inherit( $jigsaw_template_args['hover'] )
							? $jigsaw_template_args['hover']
							: jigsaw_get_theme_option( 'image_hover' );
	$jigsaw_components = ! empty( $jigsaw_template_args['meta_parts'] )
							? ( is_array( $jigsaw_template_args['meta_parts'] )
								? $jigsaw_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $jigsaw_template_args['meta_parts'] ) )
								)
							: jigsaw_array_get_keys_by_value( jigsaw_get_theme_option( 'meta_parts' ) );
	jigsaw_show_post_featured( apply_filters( 'jigsaw_filter_args_featured',
		array(
			'no_links'   => ! empty( $jigsaw_template_args['no_links'] ),
			'hover'      => $jigsaw_hover,
			'meta_parts' => $jigsaw_components,
			'thumb_size' => ! empty( $jigsaw_template_args['thumb_size'] )
							? $jigsaw_template_args['thumb_size']
							: jigsaw_get_thumb_size( strpos( jigsaw_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $jigsaw_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$jigsaw_template_args
	) );

	// Title and post meta
	$jigsaw_show_title = get_the_title() != '';
	$jigsaw_show_meta  = count( $jigsaw_components ) > 0 && ! in_array( $jigsaw_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $jigsaw_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'jigsaw_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'jigsaw_action_before_post_title' );
				if ( empty( $jigsaw_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'jigsaw_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'jigsaw_filter_show_blog_excerpt', empty( $jigsaw_template_args['hide_excerpt'] ) && jigsaw_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'jigsaw_filter_show_blog_meta', $jigsaw_show_meta, $jigsaw_components, 'excerpt' ) ) {
				if ( count( $jigsaw_components ) > 0 ) {
					do_action( 'jigsaw_action_before_post_meta' );
					jigsaw_show_post_meta(
						apply_filters(
							'jigsaw_filter_post_meta_args', array(
								'components' => join( ',', $jigsaw_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'jigsaw_action_after_post_meta' );
				}
			}

			if ( jigsaw_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'jigsaw_action_before_full_post_content' );
					the_content( '' );
					do_action( 'jigsaw_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'jigsaw' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'jigsaw' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				jigsaw_show_post_content( $jigsaw_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'jigsaw_filter_show_blog_readmore',  ! isset( $jigsaw_template_args['more_button'] ) || ! empty( $jigsaw_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $jigsaw_template_args['no_links'] ) ) {
					do_action( 'jigsaw_action_before_post_readmore' );
					if ( jigsaw_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						jigsaw_show_post_more_link( $jigsaw_template_args, '<p>', '</p>' );
					} else {
						jigsaw_show_post_comments_link( $jigsaw_template_args, '<p>', '</p>' );
					}
					do_action( 'jigsaw_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $jigsaw_template_args ) ) {
	if ( ! empty( $jigsaw_template_args['slider'] ) || $jigsaw_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
