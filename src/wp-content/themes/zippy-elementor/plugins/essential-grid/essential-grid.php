<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'jigsaw_essential_grid_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'jigsaw_essential_grid_theme_setup9', 9 );
	function jigsaw_essential_grid_theme_setup9() {
		if ( jigsaw_exists_essential_grid() ) {
			add_action( 'wp_enqueue_scripts', 'jigsaw_essential_grid_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_essential_grid', 'jigsaw_essential_grid_frontend_scripts', 10, 1 );
			add_filter( 'jigsaw_filter_merge_styles', 'jigsaw_essential_grid_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'jigsaw_filter_tgmpa_required_plugins', 'jigsaw_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'jigsaw_essential_grid_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('jigsaw_filter_tgmpa_required_plugins',	'jigsaw_essential_grid_tgmpa_required_plugins');
	function jigsaw_essential_grid_tgmpa_required_plugins( $list = array() ) {
		if ( jigsaw_storage_isset( 'required_plugins', 'essential-grid' ) && jigsaw_storage_get_array( 'required_plugins', 'essential-grid', 'install' ) !== false && jigsaw_is_theme_activated() ) {
			$path = jigsaw_get_plugin_source_path( 'plugins/essential-grid/essential-grid.zip' );
			if ( ! empty( $path ) || jigsaw_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => jigsaw_storage_get_array( 'required_plugins', 'essential-grid', 'title' ),
					'slug'     => 'essential-grid',
					'source'   => ! empty( $path ) ? $path : 'upload://essential-grid.zip',
					'version'  => '2.2.4.2',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'jigsaw_exists_essential_grid' ) ) {
	function jigsaw_exists_essential_grid() {
		return defined( 'EG_PLUGIN_PATH' ) || defined( 'ESG_PLUGIN_PATH' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'jigsaw_essential_grid_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'jigsaw_essential_grid_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_essential_grid', 'jigsaw_essential_grid_frontend_scripts', 10, 1 );
	function jigsaw_essential_grid_frontend_scripts( $force = false ) {
		jigsaw_enqueue_optimized( 'essential_grid', $force, array(
			'css' => array(
				'jigsaw-essential-grid' => array( 'src' => 'plugins/essential-grid/essential-grid.css' ),
			)
		) );
	}
}

// Merge custom styles
if ( ! function_exists( 'jigsaw_essential_grid_merge_styles' ) ) {
	//Handler of the add_filter('jigsaw_filter_merge_styles', 'jigsaw_essential_grid_merge_styles');
	function jigsaw_essential_grid_merge_styles( $list ) {
		$list[ 'plugins/essential-grid/essential-grid.css' ] = false;
		return $list;
	}
}
