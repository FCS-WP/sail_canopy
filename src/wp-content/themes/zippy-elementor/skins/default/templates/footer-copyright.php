<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package JIGSAW
 * @since JIGSAW 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$jigsaw_copyright_scheme = jigsaw_get_theme_option( 'copyright_scheme' );
if ( ! empty( $jigsaw_copyright_scheme ) && ! jigsaw_is_inherit( $jigsaw_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $jigsaw_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$jigsaw_copyright = jigsaw_get_theme_option( 'copyright' );
			if ( ! empty( $jigsaw_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$jigsaw_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $jigsaw_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$jigsaw_copyright = jigsaw_prepare_macros( $jigsaw_copyright );
				// Display copyright
				echo wp_kses( nl2br( $jigsaw_copyright ), 'jigsaw_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
