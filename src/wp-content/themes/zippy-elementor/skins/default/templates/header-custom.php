<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package JIGSAW
 * @since JIGSAW 1.0.06
 */

$jigsaw_header_css   = '';
$jigsaw_header_image = get_header_image();
$jigsaw_header_video = jigsaw_get_header_video();
if ( ! empty( $jigsaw_header_image ) && jigsaw_trx_addons_featured_image_override( is_singular() || jigsaw_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$jigsaw_header_image = jigsaw_get_current_mode_image( $jigsaw_header_image );
}

$jigsaw_header_id = jigsaw_get_custom_header_id();
$jigsaw_header_meta = get_post_meta( $jigsaw_header_id, 'trx_addons_options', true );
if ( ! empty( $jigsaw_header_meta['margin'] ) ) {
	jigsaw_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( jigsaw_prepare_css_value( $jigsaw_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $jigsaw_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $jigsaw_header_id ) ) ); ?>
				<?php
				echo ! empty( $jigsaw_header_image ) || ! empty( $jigsaw_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
				if ( '' != $jigsaw_header_video ) {
					echo ' with_bg_video';
				}
				if ( '' != $jigsaw_header_image ) {
					echo ' ' . esc_attr( jigsaw_add_inline_css_class( 'background-image: url(' . esc_url( $jigsaw_header_image ) . ');' ) );
				}
				if ( is_single() && has_post_thumbnail() ) {
					echo ' with_featured_image';
				}
				if ( jigsaw_is_on( jigsaw_get_theme_option( 'header_fullheight' ) ) ) {
					echo ' header_fullheight jigsaw-full-height';
				}
				$jigsaw_header_scheme = jigsaw_get_theme_option( 'header_scheme' );
				if ( ! empty( $jigsaw_header_scheme ) && ! jigsaw_is_inherit( $jigsaw_header_scheme  ) ) {
					echo ' scheme_' . esc_attr( $jigsaw_header_scheme );
				}
				?>
">
	<?php

	// Background video
	if ( ! empty( $jigsaw_header_video ) ) {
		get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/header-video' ) );
	}

	// Custom header's layout
	do_action( 'jigsaw_action_show_layout', $jigsaw_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
