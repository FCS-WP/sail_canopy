<?php
/**
 * The template to display the widgets area in the header
 *
 * @package JIGSAW
 * @since JIGSAW 1.0
 */

// Header sidebar
$jigsaw_header_name    = jigsaw_get_theme_option( 'header_widgets' );
$jigsaw_header_present = ! jigsaw_is_off( $jigsaw_header_name ) && is_active_sidebar( $jigsaw_header_name );
if ( $jigsaw_header_present ) {
	jigsaw_storage_set( 'current_sidebar', 'header' );
	$jigsaw_header_wide = jigsaw_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $jigsaw_header_name ) ) {
		dynamic_sidebar( $jigsaw_header_name );
	}
	$jigsaw_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $jigsaw_widgets_output ) ) {
		$jigsaw_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $jigsaw_widgets_output );
		$jigsaw_need_columns   = strpos( $jigsaw_widgets_output, 'columns_wrap' ) === false;
		if ( $jigsaw_need_columns ) {
			$jigsaw_columns = max( 0, (int) jigsaw_get_theme_option( 'header_columns' ) );
			if ( 0 == $jigsaw_columns ) {
				$jigsaw_columns = min( 6, max( 1, jigsaw_tags_count( $jigsaw_widgets_output, 'aside' ) ) );
			}
			if ( $jigsaw_columns > 1 ) {
				$jigsaw_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $jigsaw_columns ) . ' widget', $jigsaw_widgets_output );
			} else {
				$jigsaw_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $jigsaw_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'jigsaw_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $jigsaw_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $jigsaw_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'jigsaw_action_before_sidebar', 'header' );
				jigsaw_show_layout( $jigsaw_widgets_output );
				do_action( 'jigsaw_action_after_sidebar', 'header' );
				if ( $jigsaw_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $jigsaw_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'jigsaw_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
