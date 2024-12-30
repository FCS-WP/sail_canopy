<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package JIGSAW
 * @since JIGSAW 1.71.0
 */

$jigsaw_template_args = get_query_var( 'jigsaw_template_args' );
if ( ! is_array( $jigsaw_template_args ) ) {
	$jigsaw_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$jigsaw_columns       = 1;

$jigsaw_expanded      = ! jigsaw_sidebar_present() && jigsaw_get_theme_option( 'expand_content' ) == 'expand';

$jigsaw_post_format   = get_post_format();
$jigsaw_post_format   = empty( $jigsaw_post_format ) ? 'standard' : str_replace( 'post-format-', '', $jigsaw_post_format );

if ( is_array( $jigsaw_template_args ) ) {
	$jigsaw_columns    = empty( $jigsaw_template_args['columns'] ) ? 1 : max( 1, $jigsaw_template_args['columns'] );
	$jigsaw_blog_style = array( $jigsaw_template_args['type'], $jigsaw_columns );
	if ( ! empty( $jigsaw_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $jigsaw_columns > 1 ) {
	    $jigsaw_columns_class = jigsaw_get_column_class( 1, $jigsaw_columns, ! empty( $jigsaw_template_args['columns_tablet']) ? $jigsaw_template_args['columns_tablet'] : '', ! empty($jigsaw_template_args['columns_mobile']) ? $jigsaw_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $jigsaw_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $jigsaw_post_format ) );
	jigsaw_add_blog_animation( $jigsaw_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$jigsaw_hover      = ! empty( $jigsaw_template_args['hover'] ) && ! jigsaw_is_inherit( $jigsaw_template_args['hover'] )
							? $jigsaw_template_args['hover']
							: jigsaw_get_theme_option( 'image_hover' );
	$jigsaw_components = ! empty( $jigsaw_template_args['meta_parts'] )
							? ( is_array( $jigsaw_template_args['meta_parts'] )
								? $jigsaw_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $jigsaw_template_args['meta_parts'] ) )
								)
							: jigsaw_array_get_keys_by_value( jigsaw_get_theme_option( 'meta_parts' ) );
	jigsaw_show_post_featured( apply_filters( 'jigsaw_filter_args_featured',
		array(
			'no_links'   => ! empty( $jigsaw_template_args['no_links'] ),
			'hover'      => $jigsaw_hover,
			'meta_parts' => $jigsaw_components,
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $jigsaw_template_args['thumb_size'] )
								? $jigsaw_template_args['thumb_size']
								: jigsaw_get_thumb_size( 
								in_array( $jigsaw_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( jigsaw_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $jigsaw_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$jigsaw_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$jigsaw_show_title = get_the_title() != '';
		$jigsaw_show_meta  = count( $jigsaw_components ) > 0 && ! in_array( $jigsaw_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $jigsaw_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'jigsaw_filter_show_blog_categories', $jigsaw_show_meta && in_array( 'categories', $jigsaw_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'jigsaw_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						jigsaw_show_post_meta( apply_filters(
															'jigsaw_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $jigsaw_hover, 1
															)
											);
						?>
					</div>
					<?php
					$jigsaw_components = jigsaw_array_delete_by_value( $jigsaw_components, 'categories' );
					do_action( 'jigsaw_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'jigsaw_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'jigsaw_action_before_post_title' );
					if ( empty( $jigsaw_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'jigsaw_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $jigsaw_template_args['excerpt_length'] ) && ! in_array( $jigsaw_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$jigsaw_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'jigsaw_filter_show_blog_excerpt', empty( $jigsaw_template_args['hide_excerpt'] ) && jigsaw_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				jigsaw_show_post_content( $jigsaw_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'jigsaw_filter_show_blog_meta', $jigsaw_show_meta, $jigsaw_components, 'band' ) ) {
			if ( count( $jigsaw_components ) > 0 ) {
				do_action( 'jigsaw_action_before_post_meta' );
				jigsaw_show_post_meta(
					apply_filters(
						'jigsaw_filter_post_meta_args', array(
							'components' => join( ',', $jigsaw_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'jigsaw_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'jigsaw_filter_show_blog_readmore', ! $jigsaw_show_title || ! empty( $jigsaw_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $jigsaw_template_args['no_links'] ) ) {
				do_action( 'jigsaw_action_before_post_readmore' );
				jigsaw_show_post_more_link( $jigsaw_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'jigsaw_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $jigsaw_template_args ) ) {
	if ( ! empty( $jigsaw_template_args['slider'] ) || $jigsaw_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
