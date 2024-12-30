<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package JIGSAW
 * @since JIGSAW 1.0.10
 */

// Footer sidebar
$jigsaw_footer_name    = jigsaw_get_theme_option( 'footer_widgets' );
$jigsaw_footer_present = ! jigsaw_is_off( $jigsaw_footer_name ) && is_active_sidebar( $jigsaw_footer_name );
if ( $jigsaw_footer_present ) {
	jigsaw_storage_set( 'current_sidebar', 'footer' );
	$jigsaw_footer_wide = jigsaw_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $jigsaw_footer_name ) ) {
		dynamic_sidebar( $jigsaw_footer_name );
	}
	$jigsaw_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $jigsaw_out ) ) {
		$jigsaw_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $jigsaw_out );
		$jigsaw_need_columns = true;   //or check: strpos($jigsaw_out, 'columns_wrap')===false;
		if ( $jigsaw_need_columns ) {
			$jigsaw_columns = max( 0, (int) jigsaw_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $jigsaw_columns ) {
				$jigsaw_columns = min( 4, max( 1, jigsaw_tags_count( $jigsaw_out, 'aside' ) ) );
			}
			if ( $jigsaw_columns > 1 ) {
				$jigsaw_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $jigsaw_columns ) . ' widget', $jigsaw_out );
			} else {
				$jigsaw_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $jigsaw_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'jigsaw_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $jigsaw_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $jigsaw_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'jigsaw_action_before_sidebar', 'footer' );
				jigsaw_show_layout( $jigsaw_out );
				do_action( 'jigsaw_action_after_sidebar', 'footer' );
				if ( $jigsaw_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $jigsaw_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'jigsaw_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
