<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'jigsaw_revslider_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'jigsaw_revslider_theme_setup9', 9 );
	function jigsaw_revslider_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'jigsaw_filter_tgmpa_required_plugins', 'jigsaw_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'jigsaw_revslider_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('jigsaw_filter_tgmpa_required_plugins',	'jigsaw_revslider_tgmpa_required_plugins');
	function jigsaw_revslider_tgmpa_required_plugins( $list = array() ) {
		if ( jigsaw_storage_isset( 'required_plugins', 'revslider' ) && jigsaw_storage_get_array( 'required_plugins', 'revslider', 'install' ) !== false && jigsaw_is_theme_activated() ) {
			$path = jigsaw_get_plugin_source_path( 'plugins/revslider/revslider.zip' );
			if ( ! empty( $path ) || jigsaw_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => jigsaw_storage_get_array( 'required_plugins', 'revslider', 'title' ),
					'slug'     => 'revslider',
					'source'   => ! empty( $path ) ? $path : 'upload://revslider.zip',
					'version'  => '6.4.11',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( ! function_exists( 'jigsaw_exists_revslider' ) ) {
	function jigsaw_exists_revslider() {
		return function_exists( 'rev_slider_shortcode' ) || class_exists( 'RevSliderData' );
	}
}


// Allow loading RevSlider scripts and styles
// if it present in the content of the current page
if (!function_exists('jigsaw_revslider_check_revslider_in_content')) {
	add_filter( 'revslider_include_libraries', 'jigsaw_revslider_check_revslider_in_content' );
	function jigsaw_revslider_check_revslider_in_content( $load ) {
		if ( ! $load && function_exists( 'trx_addons_check_revslider_in_content' ) && jigsaw_is_layouts_available() ) {
			// Check slider in the page header
			if ( apply_filters( 'jigsaw_filter_check_revslider_in_header', true ) ) {
				$header_type = jigsaw_get_theme_option( 'header_type' );
				if ( 'custom' == $header_type ) {
					$header_id = jigsaw_get_custom_header_id();
					if ( $header_id > 0 ) {
						$load = trx_addons_check_revslider_in_content( false, $header_id );
					}
				}
			}
			// Check slider in the page footer
			if ( apply_filters( 'jigsaw_filter_check_revslider_in_footer', false ) ) {
				$footer_type = jigsaw_get_theme_option( 'footer_type' );
				if ( 'custom' == $footer_type ) {
					$footer_id = jigsaw_get_custom_footer_id();
					if ( $footer_id > 0 ) {
						$load = trx_addons_check_revslider_in_content( false, $footer_id );
					}
				}
			}
		}
		return $load;
	}
}
