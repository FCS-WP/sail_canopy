<?php
/**
 * The Header: Logo and main menu
 *
 * @package JIGSAW
 * @since JIGSAW 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( jigsaw_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'jigsaw_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'jigsaw_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('jigsaw_action_body_wrap_attributes'); ?>>

		<?php do_action( 'jigsaw_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'jigsaw_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('jigsaw_action_page_wrap_attributes'); ?>>

			<?php do_action( 'jigsaw_action_page_wrap_start' ); ?>

			<?php
			$jigsaw_full_post_loading = ( jigsaw_is_singular( 'post' ) || jigsaw_is_singular( 'attachment' ) ) && jigsaw_get_value_gp( 'action' ) == 'full_post_loading';
			$jigsaw_prev_post_loading = ( jigsaw_is_singular( 'post' ) || jigsaw_is_singular( 'attachment' ) ) && jigsaw_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $jigsaw_full_post_loading && ! $jigsaw_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="jigsaw_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'jigsaw_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'jigsaw' ); ?></a>
				<?php if ( jigsaw_sidebar_present() ) { ?>
				<a class="jigsaw_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'jigsaw_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'jigsaw' ); ?></a>
				<?php } ?>
				<a class="jigsaw_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'jigsaw_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'jigsaw' ); ?></a>

				<?php
				do_action( 'jigsaw_action_before_header' );

				// Header
				$jigsaw_header_type = jigsaw_get_theme_option( 'header_type' );
				if ( 'custom' == $jigsaw_header_type && ! jigsaw_is_layouts_available() ) {
					$jigsaw_header_type = 'default';
				}
				get_template_part( apply_filters( 'jigsaw_filter_get_template_part', "templates/header-" . sanitize_file_name( $jigsaw_header_type ) ) );

				// Side menu
				if ( in_array( jigsaw_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'jigsaw_action_after_header' );

			}
			?>

			<?php do_action( 'jigsaw_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( jigsaw_is_off( jigsaw_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $jigsaw_header_type ) ) {
						$jigsaw_header_type = jigsaw_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $jigsaw_header_type && jigsaw_is_layouts_available() ) {
						$jigsaw_header_id = jigsaw_get_custom_header_id();
						if ( $jigsaw_header_id > 0 ) {
							$jigsaw_header_meta = jigsaw_get_custom_layout_meta( $jigsaw_header_id );
							if ( ! empty( $jigsaw_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$jigsaw_footer_type = jigsaw_get_theme_option( 'footer_type' );
					if ( 'custom' == $jigsaw_footer_type && jigsaw_is_layouts_available() ) {
						$jigsaw_footer_id = jigsaw_get_custom_footer_id();
						if ( $jigsaw_footer_id ) {
							$jigsaw_footer_meta = jigsaw_get_custom_layout_meta( $jigsaw_footer_id );
							if ( ! empty( $jigsaw_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'jigsaw_action_page_content_wrap_class', $jigsaw_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'jigsaw_filter_is_prev_post_loading', $jigsaw_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( jigsaw_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'jigsaw_action_page_content_wrap_data', $jigsaw_prev_post_loading );
			?>>
				<?php
				do_action( 'jigsaw_action_page_content_wrap', $jigsaw_full_post_loading || $jigsaw_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'jigsaw_filter_single_post_header', jigsaw_is_singular( 'post' ) || jigsaw_is_singular( 'attachment' ) ) ) {
					if ( $jigsaw_prev_post_loading ) {
						if ( jigsaw_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'jigsaw_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$jigsaw_path = apply_filters( 'jigsaw_filter_get_template_part', 'templates/single-styles/' . jigsaw_get_theme_option( 'single_style' ) );
					if ( jigsaw_get_file_dir( $jigsaw_path . '.php' ) != '' ) {
						get_template_part( $jigsaw_path );
					}
				}

				// Widgets area above page
				$jigsaw_body_style   = jigsaw_get_theme_option( 'body_style' );
				$jigsaw_widgets_name = jigsaw_get_theme_option( 'widgets_above_page' );
				$jigsaw_show_widgets = ! jigsaw_is_off( $jigsaw_widgets_name ) && is_active_sidebar( $jigsaw_widgets_name );
				if ( $jigsaw_show_widgets ) {
					if ( 'fullscreen' != $jigsaw_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					jigsaw_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $jigsaw_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'jigsaw_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $jigsaw_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'jigsaw_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'jigsaw_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="jigsaw_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( jigsaw_is_singular( 'post' ) || jigsaw_is_singular( 'attachment' ) )
							&& $jigsaw_prev_post_loading 
							&& jigsaw_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'jigsaw_action_between_posts' );
						}

						// Widgets area above content
						jigsaw_create_widgets_area( 'widgets_above_content' );

						do_action( 'jigsaw_action_page_content_start_text' );
