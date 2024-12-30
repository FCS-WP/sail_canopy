<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package JIGSAW
 * @since JIGSAW 1.0
 */

$jigsaw_args = get_query_var( 'jigsaw_logo_args' );

// Site logo
$jigsaw_logo_type   = isset( $jigsaw_args['type'] ) ? $jigsaw_args['type'] : '';
$jigsaw_logo_image  = jigsaw_get_logo_image( $jigsaw_logo_type );
$jigsaw_logo_text   = jigsaw_is_on( jigsaw_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$jigsaw_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $jigsaw_logo_image['logo'] ) || ! empty( $jigsaw_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $jigsaw_logo_image['logo'] ) ) {
			if ( empty( $jigsaw_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($jigsaw_logo_image['logo']) && (int) $jigsaw_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$jigsaw_attr = jigsaw_getimagesize( $jigsaw_logo_image['logo'] );
				echo '<img src="' . esc_url( $jigsaw_logo_image['logo'] ) . '"'
						. ( ! empty( $jigsaw_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $jigsaw_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $jigsaw_logo_text ) . '"'
						. ( ! empty( $jigsaw_attr[3] ) ? ' ' . wp_kses_data( $jigsaw_attr[3] ) : '' )
						. '>';
			}
		} else {
			jigsaw_show_layout( jigsaw_prepare_macros( $jigsaw_logo_text ), '<span class="logo_text">', '</span>' );
			jigsaw_show_layout( jigsaw_prepare_macros( $jigsaw_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
