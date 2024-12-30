<?php
/**
 * The template to display default site footer
 *
 * @package JIGSAW
 * @since JIGSAW 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$jigsaw_footer_scheme = jigsaw_get_theme_option( 'footer_scheme' );
if ( ! empty( $jigsaw_footer_scheme ) && ! jigsaw_is_inherit( $jigsaw_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $jigsaw_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
