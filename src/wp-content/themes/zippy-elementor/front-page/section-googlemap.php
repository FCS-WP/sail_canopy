<div class="front_page_section front_page_section_googlemap<?php
	$jigsaw_scheme = jigsaw_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $jigsaw_scheme ) && ! jigsaw_is_inherit( $jigsaw_scheme ) ) {
		echo ' scheme_' . esc_attr( $jigsaw_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( jigsaw_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( jigsaw_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$jigsaw_css      = '';
		$jigsaw_bg_image = jigsaw_get_theme_option( 'front_page_googlemap_bg_image' );
		if ( ! empty( $jigsaw_bg_image ) ) {
			$jigsaw_css .= 'background-image: url(' . esc_url( jigsaw_get_attachment_url( $jigsaw_bg_image ) ) . ');';
		}
		if ( ! empty( $jigsaw_css ) ) {
			echo ' style="' . esc_attr( $jigsaw_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$jigsaw_anchor_icon = jigsaw_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$jigsaw_anchor_text = jigsaw_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $jigsaw_anchor_icon ) || ! empty( $jigsaw_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $jigsaw_anchor_icon ) ? ' icon="' . esc_attr( $jigsaw_anchor_icon ) . '"' : '' )
									. ( ! empty( $jigsaw_anchor_text ) ? ' title="' . esc_attr( $jigsaw_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$jigsaw_layout = jigsaw_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $jigsaw_layout );
		if ( jigsaw_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' jigsaw-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$jigsaw_css      = '';
			$jigsaw_bg_mask  = jigsaw_get_theme_option( 'front_page_googlemap_bg_mask' );
			$jigsaw_bg_color_type = jigsaw_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $jigsaw_bg_color_type ) {
				$jigsaw_bg_color = jigsaw_get_theme_option( 'front_page_googlemap_bg_color' );
			} elseif ( 'scheme_bg_color' == $jigsaw_bg_color_type ) {
				$jigsaw_bg_color = jigsaw_get_scheme_color( 'bg_color', $jigsaw_scheme );
			} else {
				$jigsaw_bg_color = '';
			}
			if ( ! empty( $jigsaw_bg_color ) && $jigsaw_bg_mask > 0 ) {
				$jigsaw_css .= 'background-color: ' . esc_attr(
					1 == $jigsaw_bg_mask ? $jigsaw_bg_color : jigsaw_hex2rgba( $jigsaw_bg_color, $jigsaw_bg_mask )
				) . ';';
			}
			if ( ! empty( $jigsaw_css ) ) {
				echo ' style="' . esc_attr( $jigsaw_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $jigsaw_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$jigsaw_caption     = jigsaw_get_theme_option( 'front_page_googlemap_caption' );
			$jigsaw_description = jigsaw_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $jigsaw_caption ) || ! empty( $jigsaw_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $jigsaw_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $jigsaw_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $jigsaw_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $jigsaw_caption, 'jigsaw_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $jigsaw_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $jigsaw_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $jigsaw_description ), 'jigsaw_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $jigsaw_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$jigsaw_content = jigsaw_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $jigsaw_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $jigsaw_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $jigsaw_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $jigsaw_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $jigsaw_content, 'jigsaw_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $jigsaw_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $jigsaw_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
				<?php
				if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! jigsaw_exists_trx_addons() ) {
						jigsaw_customizer_need_trx_addons_message();
					} else {
						jigsaw_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
					}
				}
				?>
			</div>
			<?php

			if ( 'columns' == $jigsaw_layout && ( ! empty( $jigsaw_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
