<?php
/**
 * The template to display the socials in the footer
 *
 * @package JIGSAW
 * @since JIGSAW 1.0.10
 */


// Socials
if ( jigsaw_is_on( jigsaw_get_theme_option( 'socials_in_footer' ) ) ) {
	$jigsaw_output = jigsaw_get_socials_links();
	if ( '' != $jigsaw_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php jigsaw_show_layout( $jigsaw_output ); ?>
			</div>
		</div>
		<?php
	}
}
