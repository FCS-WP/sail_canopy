<?php
/**
 * The template to display Admin notices
 *
 * @package JIGSAW
 * @since JIGSAW 1.0.1
 */

$jigsaw_theme_slug = get_option( 'template' );
$jigsaw_theme_obj  = wp_get_theme( $jigsaw_theme_slug );
?>
<div class="jigsaw_admin_notice jigsaw_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$jigsaw_theme_img = jigsaw_get_file_url( 'screenshot.jpg' );
	if ( '' != $jigsaw_theme_img ) {
		?>
		<div class="jigsaw_notice_image"><img src="<?php echo esc_url( $jigsaw_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'jigsaw' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="jigsaw_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'jigsaw' ),
				$jigsaw_theme_obj->get( 'Name' ) . ( JIGSAW_THEME_FREE ? ' ' . __( 'Free', 'jigsaw' ) : '' ),
				$jigsaw_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="jigsaw_notice_text">
		<p class="jigsaw_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $jigsaw_theme_obj->description ) );
			?>
		</p>
		<p class="jigsaw_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'jigsaw' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="jigsaw_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=jigsaw_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'jigsaw' );
			?>
		</a>
	</div>
</div>
