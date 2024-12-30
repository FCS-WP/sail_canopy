<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package JIGSAW
 * @since JIGSAW 1.0
 */

$jigsaw_template_args = get_query_var( 'jigsaw_template_args' );

if ( is_array( $jigsaw_template_args ) ) {
	$jigsaw_columns    = empty( $jigsaw_template_args['columns'] ) ? 2 : max( 1, $jigsaw_template_args['columns'] );
	$jigsaw_blog_style = array( $jigsaw_template_args['type'], $jigsaw_columns );
    $jigsaw_columns_class = jigsaw_get_column_class( 1, $jigsaw_columns, ! empty( $jigsaw_template_args['columns_tablet']) ? $jigsaw_template_args['columns_tablet'] : '', ! empty($jigsaw_template_args['columns_mobile']) ? $jigsaw_template_args['columns_mobile'] : '' );
} else {
	$jigsaw_template_args = array();
	$jigsaw_blog_style = explode( '_', jigsaw_get_theme_option( 'blog_style' ) );
	$jigsaw_columns    = empty( $jigsaw_blog_style[1] ) ? 2 : max( 1, $jigsaw_blog_style[1] );
    $jigsaw_columns_class = jigsaw_get_column_class( 1, $jigsaw_columns );
}
$jigsaw_expanded   = ! jigsaw_sidebar_present() && jigsaw_get_theme_option( 'expand_content' ) == 'expand';

$jigsaw_post_format = get_post_format();
$jigsaw_post_format = empty( $jigsaw_post_format ) ? 'standard' : str_replace( 'post-format-', '', $jigsaw_post_format );

?><div class="<?php
	if ( ! empty( $jigsaw_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( jigsaw_is_blog_style_use_masonry( $jigsaw_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $jigsaw_columns ) : esc_attr( $jigsaw_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $jigsaw_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $jigsaw_columns )
				. ' post_layout_' . esc_attr( $jigsaw_blog_style[0] )
				. ' post_layout_' . esc_attr( $jigsaw_blog_style[0] ) . '_' . esc_attr( $jigsaw_columns )
	);
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
								: explode( ',', $jigsaw_template_args['meta_parts'] )
								)
							: jigsaw_array_get_keys_by_value( jigsaw_get_theme_option( 'meta_parts' ) );

	jigsaw_show_post_featured( apply_filters( 'jigsaw_filter_args_featured',
		array(
			'thumb_size' => ! empty( $jigsaw_template_args['thumb_size'] )
				? $jigsaw_template_args['thumb_size']
				: jigsaw_get_thumb_size(
				'classic' == $jigsaw_blog_style[0]
						? ( strpos( jigsaw_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $jigsaw_columns > 2 ? 'big' : 'huge' )
								: ( $jigsaw_columns > 2
									? ( $jigsaw_expanded ? 'square' : 'square' )
									: ($jigsaw_columns > 1 ? 'square' : ( $jigsaw_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( jigsaw_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $jigsaw_columns > 2 ? 'masonry-big' : 'full' )
								: ($jigsaw_columns === 1 ? ( $jigsaw_expanded ? 'huge' : 'big' ) : ( $jigsaw_columns <= 2 && $jigsaw_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $jigsaw_hover,
			'meta_parts' => $jigsaw_components,
			'no_links'   => ! empty( $jigsaw_template_args['no_links'] ),
        ),
        'content-classic',
        $jigsaw_template_args
    ) );

	// Title and post meta
	$jigsaw_show_title = get_the_title() != '';
	$jigsaw_show_meta  = count( $jigsaw_components ) > 0 && ! in_array( $jigsaw_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $jigsaw_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'jigsaw_filter_show_blog_meta', $jigsaw_show_meta, $jigsaw_components, 'classic' ) ) {
				if ( count( $jigsaw_components ) > 0 ) {
					do_action( 'jigsaw_action_before_post_meta' );
					jigsaw_show_post_meta(
						apply_filters(
							'jigsaw_filter_post_meta_args', array(
							'components' => join( ',', $jigsaw_components ),
							'seo'        => false,
							'echo'       => true,
						), $jigsaw_blog_style[0], $jigsaw_columns
						)
					);
					do_action( 'jigsaw_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'jigsaw_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'jigsaw_action_before_post_title' );
				if ( empty( $jigsaw_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'jigsaw_action_after_post_title' );
			}

			if( !in_array( $jigsaw_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'jigsaw_filter_show_blog_readmore', ! $jigsaw_show_title || ! empty( $jigsaw_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $jigsaw_template_args['no_links'] ) ) {
						do_action( 'jigsaw_action_before_post_readmore' );
						jigsaw_show_post_more_link( $jigsaw_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'jigsaw_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $jigsaw_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('jigsaw_filter_show_blog_excerpt', empty($jigsaw_template_args['hide_excerpt']) && jigsaw_get_theme_option('excerpt_length') > 0, 'classic')) {
			jigsaw_show_post_content($jigsaw_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $jigsaw_template_args['more_button'] )) {
			if ( empty( $jigsaw_template_args['no_links'] ) ) {
				do_action( 'jigsaw_action_before_post_readmore' );
				jigsaw_show_post_more_link( $jigsaw_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'jigsaw_action_after_post_readmore' );
			}
		}
		$jigsaw_content = ob_get_contents();
		ob_end_clean();
		jigsaw_show_layout($jigsaw_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
