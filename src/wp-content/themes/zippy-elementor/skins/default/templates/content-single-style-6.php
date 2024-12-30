<?php
/**
 * The "Style 6" template to display the content of the single post or attachment:
 * featured image, title and meta are placed inside the content area
 *
 * @package JIGSAW
 * @since JIGSAW 1.75.0
 */
?>
<article id="post-<?php the_ID(); ?>"
	<?php
	post_class( 'post_item_single'
		. ' post_type_' . esc_attr( get_post_type() ) 
		. ' post_format_' . esc_attr( str_replace( 'post-format-', '', get_post_format() ) )
	);
	jigsaw_add_seo_itemprops();
	?>
>
<?php

	do_action( 'jigsaw_action_before_post_data' );

	jigsaw_add_seo_snippets();

	// Single post thumbnail and title
	if ( apply_filters( 'jigsaw_filter_single_post_header', is_singular( 'post' ) || is_singular( 'attachment' ) ) ) {
		// Post title and meta
		ob_start();
		jigsaw_show_post_title_and_meta( array( 
			'author_avatar' => false,
			'show_labels'   => true, // If FALSE, labels will be assigned to meta set after the "share" in the options list, while those installed before the "share" won't have labels
			'share_type'    => 'list',	// block - icons with bg, list - small icons without background
			'split_meta_by' => 'share',
			'add_spaces'    => true,
		) );
		$jigsaw_post_header = ob_get_contents();
		ob_end_clean();
		// Featured image
		ob_start();
		jigsaw_show_post_featured_image( array(
			'thumb_bg' => false,
			'class'    => 'alignwide',
			'popup'    => true,
		) );
		$jigsaw_post_header .= ob_get_contents();
		ob_end_clean();
		$jigsaw_with_featured_image = jigsaw_is_with_featured_image( $jigsaw_post_header );

		if ( strpos( $jigsaw_post_header, 'post_featured' ) !== false
			|| strpos( $jigsaw_post_header, 'post_title' ) !== false
			|| strpos( $jigsaw_post_header, 'post_meta' ) !== false
		) {
			?>
			<div class="post_header_wrap post_header_wrap_in_content post_header_wrap_style_<?php
				echo esc_attr( jigsaw_get_theme_option( 'single_style' ) );
				if ( $jigsaw_with_featured_image ) {
					echo ' with_featured_image';
				}
			?>">
				<?php
				do_action( 'jigsaw_action_before_post_header' );
				jigsaw_show_layout( $jigsaw_post_header );
				do_action( 'jigsaw_action_after_post_header' );
				?>
			</div>
			<?php
		}
	}

	do_action( 'jigsaw_action_before_post_content' );

	// Post content
	$jigsaw_share_position = jigsaw_array_get_keys_by_value( jigsaw_get_theme_option( 'share_position' ) );
	?>
	<div class="post_content post_content_single entry-content<?php
		if ( in_array( 'left', $jigsaw_share_position ) ) {
			echo ' post_info_vertical_present' . ( in_array( 'top', $jigsaw_share_position ) ? ' post_info_vertical_hide_on_mobile' : '' );
		}
	?>" itemprop="mainEntityOfPage">
		<?php
		if ( in_array( 'left', $jigsaw_share_position ) ) {
			?><div class="post_info_vertical<?php
				if ( jigsaw_get_theme_option( 'share_fixed' ) > 0 ) {
					echo ' post_info_vertical_fixed';
				}
			?>"><?php
				jigsaw_show_post_meta(
					apply_filters(
						'jigsaw_filter_post_meta_args',
						array(
							'components'      => 'share',
							'class'           => 'post_share_vertical',
							'share_type'      => 'block',
							'share_direction' => 'vertical',
						),
						'single',
						1
					)
				);
			?></div><?php
		}
		the_content();
		?>
	</div><!-- .entry-content -->
	<?php
	do_action( 'jigsaw_action_after_post_content' );
	
	// Post footer: Tags, likes, share, author, prev/next links and comments
	do_action( 'jigsaw_action_before_post_footer' );
	?>
	<div class="post_footer post_footer_single entry-footer">
		<?php
		jigsaw_show_post_pagination();
		if ( is_single() && ! is_attachment() ) {
			jigsaw_show_post_footer();
		}
		?>
	</div>
	<?php
	do_action( 'jigsaw_action_after_post_footer' );
	?>
</article>
