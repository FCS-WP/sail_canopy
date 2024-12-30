<?php
/**
 * The template to display the background video in the header
 *
 * @package JIGSAW
 * @since JIGSAW 1.0.14
 */
$jigsaw_header_video = jigsaw_get_header_video();
$jigsaw_embed_video  = '';
if ( ! empty( $jigsaw_header_video ) && ! jigsaw_is_from_uploads( $jigsaw_header_video ) ) {
	if ( jigsaw_is_youtube_url( $jigsaw_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $jigsaw_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php jigsaw_show_layout( jigsaw_get_embed_video( $jigsaw_header_video ) ); ?></div>
		<?php
	}
}
