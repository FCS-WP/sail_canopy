<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package JIGSAW
 * @since JIGSAW 1.0
 */

							do_action( 'jigsaw_action_page_content_end_text' );
							
							// Widgets area below the content
							jigsaw_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'jigsaw_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'jigsaw_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'jigsaw_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'jigsaw_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$jigsaw_body_style = jigsaw_get_theme_option( 'body_style' );
					$jigsaw_widgets_name = jigsaw_get_theme_option( 'widgets_below_page' );
					$jigsaw_show_widgets = ! jigsaw_is_off( $jigsaw_widgets_name ) && is_active_sidebar( $jigsaw_widgets_name );
					$jigsaw_show_related = jigsaw_is_single() && jigsaw_get_theme_option( 'related_position' ) == 'below_page';
					if ( $jigsaw_show_widgets || $jigsaw_show_related ) {
						if ( 'fullscreen' != $jigsaw_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $jigsaw_show_related ) {
							do_action( 'jigsaw_action_related_posts' );
						}

						// Widgets area below page content
						if ( $jigsaw_show_widgets ) {
							jigsaw_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $jigsaw_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'jigsaw_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'jigsaw_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! jigsaw_is_singular( 'post' ) && ! jigsaw_is_singular( 'attachment' ) ) || ! in_array ( jigsaw_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="jigsaw_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'jigsaw_action_before_footer' );

				// Footer
				$jigsaw_footer_type = jigsaw_get_theme_option( 'footer_type' );
				if ( 'custom' == $jigsaw_footer_type && ! jigsaw_is_layouts_available() ) {
					$jigsaw_footer_type = 'default';
				}
				get_template_part( apply_filters( 'jigsaw_filter_get_template_part', "templates/footer-" . sanitize_file_name( $jigsaw_footer_type ) ) );

				do_action( 'jigsaw_action_after_footer' );

			}
			?>

			<?php do_action( 'jigsaw_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'jigsaw_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'jigsaw_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>