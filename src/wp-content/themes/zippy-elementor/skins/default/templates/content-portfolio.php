<?php
/**
 * The Portfolio template to display the content
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

$jigsaw_post_format = get_post_format();
$jigsaw_post_format = empty( $jigsaw_post_format ) ? 'standard' : str_replace( 'post-format-', '', $jigsaw_post_format );

?><div class="
<?php
if ( ! empty( $jigsaw_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( jigsaw_is_blog_style_use_masonry( $jigsaw_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $jigsaw_columns ) : esc_attr( $jigsaw_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $jigsaw_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $jigsaw_columns )
		. ( 'portfolio' != $jigsaw_blog_style[0] ? ' ' . esc_attr( $jigsaw_blog_style[0] )  . '_' . esc_attr( $jigsaw_columns ) : '' )
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

	$jigsaw_hover   = ! empty( $jigsaw_template_args['hover'] ) && ! jigsaw_is_inherit( $jigsaw_template_args['hover'] )
								? $jigsaw_template_args['hover']
								: jigsaw_get_theme_option( 'image_hover' );

	if ( 'dots' == $jigsaw_hover ) {
		$jigsaw_post_link = empty( $jigsaw_template_args['no_links'] )
								? ( ! empty( $jigsaw_template_args['link'] )
									? $jigsaw_template_args['link']
									: get_permalink()
									)
								: '';
		$jigsaw_target    = ! empty( $jigsaw_post_link ) && false === strpos( $jigsaw_post_link, home_url() )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$jigsaw_components = ! empty( $jigsaw_template_args['meta_parts'] )
							? ( is_array( $jigsaw_template_args['meta_parts'] )
								? $jigsaw_template_args['meta_parts']
								: explode( ',', $jigsaw_template_args['meta_parts'] )
								)
							: jigsaw_array_get_keys_by_value( jigsaw_get_theme_option( 'meta_parts' ) );

	// Featured image
	jigsaw_show_post_featured( apply_filters( 'jigsaw_filter_args_featured',
		array(
			'hover'         => $jigsaw_hover,
			'no_links'      => ! empty( $jigsaw_template_args['no_links'] ),
			'thumb_size'    => ! empty( $jigsaw_template_args['thumb_size'] )
								? $jigsaw_template_args['thumb_size']
								: jigsaw_get_thumb_size(
									jigsaw_is_blog_style_use_masonry( $jigsaw_blog_style[0] )
										? (	strpos( jigsaw_get_theme_option( 'body_style' ), 'full' ) !== false || $jigsaw_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( jigsaw_get_theme_option( 'body_style' ), 'full' ) !== false || $jigsaw_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => jigsaw_is_blog_style_use_masonry( $jigsaw_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $jigsaw_components,
			'class'         => 'dots' == $jigsaw_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $jigsaw_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $jigsaw_post_link )
												? '<a href="' . esc_url( $jigsaw_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $jigsaw_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $jigsaw_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $jigsaw_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!