<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'jigsaw_booked_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'jigsaw_booked_theme_setup9', 9 );
	function jigsaw_booked_theme_setup9() {
		if ( jigsaw_exists_booked() ) {
			add_action( 'wp_enqueue_scripts', 'jigsaw_booked_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_booked', 'jigsaw_booked_frontend_scripts', 10, 1 );
			add_action( 'wp_enqueue_scripts', 'jigsaw_booked_frontend_scripts_responsive', 2000 );
			add_action( 'trx_addons_action_load_scripts_front_booked', 'jigsaw_booked_frontend_scripts_responsive', 10, 1 );
			add_filter( 'jigsaw_filter_merge_styles', 'jigsaw_booked_merge_styles' );
			add_filter( 'jigsaw_filter_merge_styles_responsive', 'jigsaw_booked_merge_styles_responsive' );
		}
		if ( is_admin() ) {
			add_filter( 'jigsaw_filter_tgmpa_required_plugins', 'jigsaw_booked_tgmpa_required_plugins' );
			add_filter( 'jigsaw_filter_theme_plugins', 'jigsaw_booked_theme_plugins' );
		}
	}
}


// Filter to add in the required plugins list
if ( ! function_exists( 'jigsaw_booked_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('jigsaw_filter_tgmpa_required_plugins',	'jigsaw_booked_tgmpa_required_plugins');
	function jigsaw_booked_tgmpa_required_plugins( $list = array() ) {
		if ( jigsaw_storage_isset( 'required_plugins', 'booked' ) && jigsaw_storage_get_array( 'required_plugins', 'booked', 'install' ) !== false && jigsaw_is_theme_activated() ) {
			$path = jigsaw_get_plugin_source_path( 'plugins/booked/booked.zip' );
			if ( ! empty( $path ) || jigsaw_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => jigsaw_storage_get_array( 'required_plugins', 'booked', 'title' ),
					'slug'     => 'booked',
					'source'   => ! empty( $path ) ? $path : 'upload://booked.zip',
					'version'  => '2.4.3.1',
					'required' => false,
				);
			}
		}
		return $list;
	}
}


// Filter theme-supported plugins list
if ( ! function_exists( 'jigsaw_booked_theme_plugins' ) ) {
	//Handler of the add_filter( 'jigsaw_filter_theme_plugins', 'jigsaw_booked_theme_plugins' );
	function jigsaw_booked_theme_plugins( $list = array() ) {
		return jigsaw_add_group_and_logo_to_slave( $list, 'booked', 'booked-' );
	}
}


// Check if plugin installed and activated
if ( ! function_exists( 'jigsaw_exists_booked' ) ) {
	function jigsaw_exists_booked() {
		return class_exists( 'booked_plugin' );
	}
}


// Return a relative path to the plugin styles depend the version
if ( ! function_exists( 'jigsaw_booked_get_styles_dir' ) ) {
	function jigsaw_booked_get_styles_dir( $file ) {
		$base_dir = 'plugins/booked/';
		return $base_dir
				. ( defined( 'BOOKED_VERSION' ) && version_compare( BOOKED_VERSION, '2.4', '<' ) && jigsaw_get_folder_dir( $base_dir . 'old' )
					? 'old/'
					: ''
					)
				. $file;
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'jigsaw_booked_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'jigsaw_booked_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_booked', 'jigsaw_booked_frontend_scripts', 10, 1 );
	function jigsaw_booked_frontend_scripts( $force = false ) {
		jigsaw_enqueue_optimized( 'booked', $force, array(
			'css' => array(
				'jigsaw-booked' => array( 'src' => jigsaw_booked_get_styles_dir( 'booked.css' ) ),
			)
		) );
	}
}


// Enqueue responsive styles for frontend
if ( ! function_exists( 'jigsaw_booked_frontend_scripts_responsive' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'jigsaw_booked_frontend_scripts_responsive', 2000 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_booked', 'jigsaw_booked_frontend_scripts_responsive', 10, 1 );
	function jigsaw_booked_frontend_scripts_responsive( $force = false ) {
		jigsaw_enqueue_optimized_responsive( 'booked', $force, array(
			'css' => array(
				'jigsaw-booked-responsive' => array( 'src' => jigsaw_booked_get_styles_dir( 'booked-responsive.css' ), 'media' => 'all' ),
			)
		) );
	}
}


// Merge custom styles
if ( ! function_exists( 'jigsaw_booked_merge_styles' ) ) {
	//Handler of the add_filter('jigsaw_filter_merge_styles', 'jigsaw_booked_merge_styles');
	function jigsaw_booked_merge_styles( $list ) {
		$list[ jigsaw_booked_get_styles_dir( 'booked.css' ) ] = false;
		return $list;
	}
}


// Merge responsive styles
if ( ! function_exists( 'jigsaw_booked_merge_styles_responsive' ) ) {
	//Handler of the add_filter('jigsaw_filter_merge_styles_responsive', 'jigsaw_booked_merge_styles_responsive');
	function jigsaw_booked_merge_styles_responsive( $list ) {
		$list[ jigsaw_booked_get_styles_dir( 'booked-responsive.css' ) ] = false;
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( jigsaw_exists_booked() ) {
	$jigsaw_fdir = jigsaw_get_file_dir( jigsaw_booked_get_styles_dir( 'booked-style.php' ) );
	if ( ! empty( $jigsaw_fdir ) ) {
		require_once $jigsaw_fdir;
	}
}
