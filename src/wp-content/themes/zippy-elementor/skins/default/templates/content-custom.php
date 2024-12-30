<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package JIGSAW
 * @since JIGSAW 1.0.50
 */

$jigsaw_template_args = get_query_var( 'jigsaw_template_args' );
if ( is_array( $jigsaw_template_args ) ) {
	$jigsaw_columns    = empty( $jigsaw_template_args['columns'] ) ? 2 : max( 1, $jigsaw_template_args['columns'] );
	$jigsaw_blog_style = array( $jigsaw_template_args['type'], $jigsaw_columns );
} else {
	$jigsaw_template_args = array();
	$jigsaw_blog_style = explode( '_', jigsaw_get_theme_option( 'blog_style' ) );
	$jigsaw_columns    = empty( $jigsaw_blog_style[1] ) ? 2 : max( 1, $jigsaw_blog_style[1] );
}
$jigsaw_blog_id       = jigsaw_get_custom_blog_id( join( '_', $jigsaw_blog_style ) );
$jigsaw_blog_style[0] = str_replace( 'blog-custom-', '', $jigsaw_blog_style[0] );
$jigsaw_expanded      = ! jigsaw_sidebar_present() && jigsaw_get_theme_option( 'expand_content' ) == 'expand';
$jigsaw_components    = ! empty( $jigsaw_template_args['meta_parts'] )
							? ( is_array( $jigsaw_template_args['meta_parts'] )
								? join( ',', $jigsaw_template_args['meta_parts'] )
								: $jigsaw_template_args['meta_parts']
								)
							: jigsaw_array_get_keys_by_value( jigsaw_get_theme_option( 'meta_parts' ) );
$jigsaw_post_format   = get_post_format();
$jigsaw_post_format   = empty( $jigsaw_post_format ) ? 'standard' : str_replace( 'post-format-', '', $jigsaw_post_format );

$jigsaw_blog_meta     = jigsaw_get_custom_layout_meta( $jigsaw_blog_id );
$jigsaw_custom_style  = ! empty( $jigsaw_blog_meta['scripts_required'] ) ? $jigsaw_blog_meta['scripts_required'] : 'none';

if ( ! empty( $jigsaw_template_args['slider'] ) || $jigsaw_columns > 1 || ! jigsaw_is_off( $jigsaw_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $jigsaw_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( jigsaw_is_off( $jigsaw_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $jigsaw_custom_style ) ) . "-1_{$jigsaw_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $jigsaw_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $jigsaw_columns )
					. ' post_layout_' . esc_attr( $jigsaw_blog_style[0] )
					. ' post_layout_' . esc_attr( $jigsaw_blog_style[0] ) . '_' . esc_attr( $jigsaw_columns )
					. ( ! jigsaw_is_off( $jigsaw_custom_style )
						? ' post_layout_' . esc_attr( $jigsaw_custom_style )
							. ' post_layout_' . esc_attr( $jigsaw_custom_style ) . '_' . esc_attr( $jigsaw_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'jigsaw_action_show_layout', $jigsaw_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $jigsaw_template_args['slider'] ) || $jigsaw_columns > 1 || ! jigsaw_is_off( $jigsaw_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
