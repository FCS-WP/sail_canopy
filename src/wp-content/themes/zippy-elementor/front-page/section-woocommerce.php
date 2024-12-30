<?php
$jigsaw_woocommerce_sc = jigsaw_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $jigsaw_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$jigsaw_scheme = jigsaw_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $jigsaw_scheme ) && ! jigsaw_is_inherit( $jigsaw_scheme ) ) {
			echo ' scheme_' . esc_attr( $jigsaw_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( jigsaw_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( jigsaw_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$jigsaw_css      = '';
			$jigsaw_bg_image = jigsaw_get_theme_option( 'front_page_woocommerce_bg_image' );
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
		$jigsaw_anchor_icon = jigsaw_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$jigsaw_anchor_text = jigsaw_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $jigsaw_anchor_icon ) || ! empty( $jigsaw_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $jigsaw_anchor_icon ) ? ' icon="' . esc_attr( $jigsaw_anchor_icon ) . '"' : '' )
											. ( ! empty( $jigsaw_anchor_text ) ? ' title="' . esc_attr( $jigsaw_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( jigsaw_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' jigsaw-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$jigsaw_css      = '';
				$jigsaw_bg_mask  = jigsaw_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$jigsaw_bg_color_type = jigsaw_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $jigsaw_bg_color_type ) {
					$jigsaw_bg_color = jigsaw_get_theme_option( 'front_page_woocommerce_bg_color' );
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
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$jigsaw_caption     = jigsaw_get_theme_option( 'front_page_woocommerce_caption' );
				$jigsaw_description = jigsaw_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $jigsaw_caption ) || ! empty( $jigsaw_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $jigsaw_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $jigsaw_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $jigsaw_caption, 'jigsaw_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $jigsaw_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $jigsaw_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $jigsaw_description ), 'jigsaw_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $jigsaw_woocommerce_sc ) {
						$jigsaw_woocommerce_sc_ids      = jigsaw_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$jigsaw_woocommerce_sc_per_page = count( explode( ',', $jigsaw_woocommerce_sc_ids ) );
					} else {
						$jigsaw_woocommerce_sc_per_page = max( 1, (int) jigsaw_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$jigsaw_woocommerce_sc_columns = max( 1, min( $jigsaw_woocommerce_sc_per_page, (int) jigsaw_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$jigsaw_woocommerce_sc}"
										. ( 'products' == $jigsaw_woocommerce_sc
												? ' ids="' . esc_attr( $jigsaw_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $jigsaw_woocommerce_sc
												? ' category="' . esc_attr( jigsaw_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $jigsaw_woocommerce_sc
												? ' orderby="' . esc_attr( jigsaw_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( jigsaw_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $jigsaw_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $jigsaw_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
