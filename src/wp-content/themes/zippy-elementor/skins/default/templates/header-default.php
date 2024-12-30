<?php
/**
 * The template to display default site header
 *
 * @package JIGSAW
 * @since JIGSAW 1.0
 */

$jigsaw_header_css   = '';
$jigsaw_header_image = get_header_image();
$jigsaw_header_video = jigsaw_get_header_video();
if ( ! empty( $jigsaw_header_image ) && jigsaw_trx_addons_featured_image_override( is_singular() || jigsaw_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$jigsaw_header_image = jigsaw_get_current_mode_image( $jigsaw_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $jigsaw_header_image ) || ! empty( $jigsaw_header_video ) ? ' with_bg_image' : ' without_bg_image';
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

	// Main menu
	get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( jigsaw_is_on( jigsaw_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
