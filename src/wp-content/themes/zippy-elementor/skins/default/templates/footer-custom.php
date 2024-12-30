<?php
/**
 * The template to display default site footer
 *
 * @package JIGSAW
 * @since JIGSAW 1.0.10
 */

$jigsaw_footer_id = jigsaw_get_custom_footer_id();
$jigsaw_footer_meta = get_post_meta( $jigsaw_footer_id, 'trx_addons_options', true );
if ( ! empty( $jigsaw_footer_meta['margin'] ) ) {
	jigsaw_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( jigsaw_prepare_css_value( $jigsaw_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $jigsaw_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $jigsaw_footer_id ) ) ); ?>
						<?php
						$jigsaw_footer_scheme = jigsaw_get_theme_option( 'footer_scheme' );
						if ( ! empty( $jigsaw_footer_scheme ) && ! jigsaw_is_inherit( $jigsaw_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $jigsaw_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'jigsaw_action_show_layout', $jigsaw_footer_id );
	?>
</footer><!-- /.footer_wrap -->
