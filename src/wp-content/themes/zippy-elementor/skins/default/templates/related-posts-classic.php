<?php
/**
 * The template 'Style 2' to displaying related posts
 *
 * @package JIGSAW
 * @since JIGSAW 1.0
 */

$jigsaw_link        = get_permalink();
$jigsaw_post_format = get_post_format();
$jigsaw_post_format = empty( $jigsaw_post_format ) ? 'standard' : str_replace( 'post-format-', '', $jigsaw_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $jigsaw_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php
	jigsaw_show_post_featured(
		array(
			'thumb_ratio'   => '300:223',
			'thumb_size'    => apply_filters( 'jigsaw_filter_related_thumb_size', jigsaw_get_thumb_size( (int) jigsaw_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'square' ) ),
		)
	);
	?>
	<div class="post_header entry-header">
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {

			jigsaw_show_post_meta(
				array(
					'components' => 'categories',
					'class'      => 'post_meta_categories',
				)
			);

		}
		?>
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $jigsaw_link ); ?>"><?php
			if ( '' == get_the_title() ) {
				esc_html_e( '- No title -', 'jigsaw' );
			} else {
				the_title();
			}
		?></a></h6>
	</div>
</div>
