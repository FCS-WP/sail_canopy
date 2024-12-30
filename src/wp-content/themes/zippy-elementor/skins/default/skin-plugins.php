<?php
/**
 * Required plugins
 *
 * @package JIGSAW
 * @since JIGSAW 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$jigsaw_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'jigsaw' ),
	'page_builders' => esc_html__( 'Page Builders', 'jigsaw' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'jigsaw' ),
	'socials'       => esc_html__( 'Socials and Communities', 'jigsaw' ),
	'events'        => esc_html__( 'Events and Appointments', 'jigsaw' ),
	'content'       => esc_html__( 'Content', 'jigsaw' ),
	'other'         => esc_html__( 'Other', 'jigsaw' ),
);
$jigsaw_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'jigsaw' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'jigsaw' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $jigsaw_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'jigsaw' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'jigsaw' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $jigsaw_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'jigsaw' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'jigsaw' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $jigsaw_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'jigsaw' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'jigsaw' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $jigsaw_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'jigsaw' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'jigsaw' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'woocommerce.png',
		'group'       => $jigsaw_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'jigsaw' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'jigsaw' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'elegro-payment.png',
		'group'       => $jigsaw_theme_required_plugins_groups['ecommerce'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'jigsaw' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'jigsaw' ),
		'required'    => false,
		'logo'        => 'instagram-feed.png',
		'group'       => $jigsaw_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'jigsaw' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'jigsaw' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $jigsaw_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'jigsaw' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'booked.png',
		'group'       => $jigsaw_theme_required_plugins_groups['events'],
	),
	'quickcal'                     => array(
		'title'       => esc_html__( 'QuickCal', 'jigsaw' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'quickcal.png',
		'group'       => $jigsaw_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'jigsaw' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'the-events-calendar.png',
		'group'       => $jigsaw_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'jigsaw' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'jigsaw' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $jigsaw_theme_required_plugins_groups['content'],
	),

	'latepoint'                  => array(
		'title'       => esc_html__( 'LatePoint', 'jigsaw' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => jigsaw_get_file_url( 'plugins/latepoint/latepoint.png' ),
		'group'       => $jigsaw_theme_required_plugins_groups['events'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'jigsaw' ),
		'description' => '',
		'required'    => false,
		'logo'        => jigsaw_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $jigsaw_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'jigsaw' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => jigsaw_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $jigsaw_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'                  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'jigsaw' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => jigsaw_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $jigsaw_theme_required_plugins_groups['ecommerce'],
	),
	'woo-smart-quick-view'                  => array(
		'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'jigsaw' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => jigsaw_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
		'group'       => $jigsaw_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'jigsaw' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => jigsaw_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $jigsaw_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'jigsaw' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'essential-grid.png',
		'group'       => $jigsaw_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'jigsaw' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $jigsaw_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'jigsaw' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'jigsaw' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $jigsaw_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'jigsaw' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'jigsaw' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $jigsaw_theme_required_plugins_groups['other'],
	),
	'gdpr-framework'         => array(
		'title'       => esc_html__( 'The GDPR Framework', 'jigsaw' ),
		'description' => esc_html__( "Tools to help make your website GDPR-compliant. Fully documented, extendable and developer-friendly.", 'jigsaw' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'gdpr-framework.png',
		'group'       => $jigsaw_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'jigsaw' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'jigsaw' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $jigsaw_theme_required_plugins_groups['other'],
	),
);

if ( JIGSAW_THEME_FREE ) {
	unset( $jigsaw_theme_required_plugins['js_composer'] );
	unset( $jigsaw_theme_required_plugins['booked'] );
	unset( $jigsaw_theme_required_plugins['quickcal'] );
	unset( $jigsaw_theme_required_plugins['the-events-calendar'] );
	unset( $jigsaw_theme_required_plugins['calculated-fields-form'] );
	unset( $jigsaw_theme_required_plugins['essential-grid'] );
	unset( $jigsaw_theme_required_plugins['revslider'] );
	unset( $jigsaw_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $jigsaw_theme_required_plugins['trx_updater'] );
	unset( $jigsaw_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
jigsaw_storage_set( 'required_plugins', $jigsaw_theme_required_plugins );
