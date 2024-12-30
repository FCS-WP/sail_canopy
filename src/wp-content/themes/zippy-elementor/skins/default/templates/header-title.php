<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package JIGSAW
 * @since JIGSAW 1.0
 */

// Page (category, tag, archive, author) title

if ( jigsaw_need_page_title() ) {
	jigsaw_sc_layouts_showed( 'title', true );
	jigsaw_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								jigsaw_show_post_meta(
									apply_filters(
										'jigsaw_filter_post_meta_args', array(
											'components' => join( ',', jigsaw_array_get_keys_by_value( jigsaw_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', jigsaw_array_get_keys_by_value( jigsaw_get_theme_option( 'counters' ) ) ),
											'seo'        => jigsaw_is_on( jigsaw_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$jigsaw_blog_title           = jigsaw_get_blog_title();
							$jigsaw_blog_title_text      = '';
							$jigsaw_blog_title_class     = '';
							$jigsaw_blog_title_link      = '';
							$jigsaw_blog_title_link_text = '';
							if ( is_array( $jigsaw_blog_title ) ) {
								$jigsaw_blog_title_text      = $jigsaw_blog_title['text'];
								$jigsaw_blog_title_class     = ! empty( $jigsaw_blog_title['class'] ) ? ' ' . $jigsaw_blog_title['class'] : '';
								$jigsaw_blog_title_link      = ! empty( $jigsaw_blog_title['link'] ) ? $jigsaw_blog_title['link'] : '';
								$jigsaw_blog_title_link_text = ! empty( $jigsaw_blog_title['link_text'] ) ? $jigsaw_blog_title['link_text'] : '';
							} else {
								$jigsaw_blog_title_text = $jigsaw_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $jigsaw_blog_title_class ); ?>">
								<?php
								$jigsaw_top_icon = jigsaw_get_term_image_small();
								if ( ! empty( $jigsaw_top_icon ) ) {
									$jigsaw_attr = jigsaw_getimagesize( $jigsaw_top_icon );
									?>
									<img src="<?php echo esc_url( $jigsaw_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'jigsaw' ); ?>"
										<?php
										if ( ! empty( $jigsaw_attr[3] ) ) {
											jigsaw_show_layout( $jigsaw_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $jigsaw_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $jigsaw_blog_title_link ) && ! empty( $jigsaw_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $jigsaw_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $jigsaw_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'jigsaw_action_breadcrumbs' );
						$jigsaw_breadcrumbs = ob_get_contents();
						ob_end_clean();
						jigsaw_show_layout( $jigsaw_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
