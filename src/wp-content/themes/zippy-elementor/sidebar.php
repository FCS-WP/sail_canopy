<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package JIGSAW
 * @since JIGSAW 1.0
 */

if ( jigsaw_sidebar_present() ) {
	
	$jigsaw_sidebar_type = jigsaw_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $jigsaw_sidebar_type && ! jigsaw_is_layouts_available() ) {
		$jigsaw_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $jigsaw_sidebar_type ) {
		// Default sidebar with widgets
		$jigsaw_sidebar_name = jigsaw_get_theme_option( 'sidebar_widgets' );
		jigsaw_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $jigsaw_sidebar_name ) ) {
			dynamic_sidebar( $jigsaw_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$jigsaw_sidebar_id = jigsaw_get_custom_sidebar_id();
		do_action( 'jigsaw_action_show_layout', $jigsaw_sidebar_id );
	}
	$jigsaw_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $jigsaw_out ) ) {
		$jigsaw_sidebar_position    = jigsaw_get_theme_option( 'sidebar_position' );
		$jigsaw_sidebar_position_ss = jigsaw_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $jigsaw_sidebar_position );
			echo ' sidebar_' . esc_attr( $jigsaw_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $jigsaw_sidebar_type );

			$jigsaw_sidebar_scheme = apply_filters( 'jigsaw_filter_sidebar_scheme', jigsaw_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $jigsaw_sidebar_scheme ) && ! jigsaw_is_inherit( $jigsaw_sidebar_scheme ) && 'custom' != $jigsaw_sidebar_type ) {
				echo ' scheme_' . esc_attr( $jigsaw_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="jigsaw_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'jigsaw_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $jigsaw_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$jigsaw_title = apply_filters( 'jigsaw_filter_sidebar_control_title', 'float' == $jigsaw_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'jigsaw' ) : '' );
				$jigsaw_text  = apply_filters( 'jigsaw_filter_sidebar_control_text', 'above' == $jigsaw_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'jigsaw' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $jigsaw_title ); ?>"><?php echo esc_html( $jigsaw_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'jigsaw_action_before_sidebar', 'sidebar' );
				jigsaw_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $jigsaw_out ) );
				do_action( 'jigsaw_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'jigsaw_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
