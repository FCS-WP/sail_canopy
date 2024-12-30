<?php
/**
 * The template to display the site logo in the footer
 *
 * @package JIGSAW
 * @since JIGSAW 1.0.10
 */

// Logo
if ( jigsaw_is_on( jigsaw_get_theme_option( 'logo_in_footer' ) ) ) {
	$jigsaw_logo_image = jigsaw_get_logo_image( 'footer' );
	$jigsaw_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $jigsaw_logo_image['logo'] ) || ! empty( $jigsaw_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $jigsaw_logo_image['logo'] ) ) {
					$jigsaw_attr = jigsaw_getimagesize( $jigsaw_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $jigsaw_logo_image['logo'] ) . '"'
								. ( ! empty( $jigsaw_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $jigsaw_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'jigsaw' ) . '"'
								. ( ! empty( $jigsaw_attr[3] ) ? ' ' . wp_kses_data( $jigsaw_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $jigsaw_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $jigsaw_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
