<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package JIGSAW
 * @since JIGSAW 1.0
 */

$jigsaw_template = apply_filters( 'jigsaw_filter_get_template_part', jigsaw_blog_archive_get_template() );

if ( ! empty( $jigsaw_template ) && 'index' != $jigsaw_template ) {

	get_template_part( $jigsaw_template );

} else {

	jigsaw_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$jigsaw_stickies   = is_home()
								|| ( in_array( jigsaw_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) jigsaw_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$jigsaw_post_type  = jigsaw_get_theme_option( 'post_type' );
		$jigsaw_args       = array(
								'blog_style'     => jigsaw_get_theme_option( 'blog_style' ),
								'post_type'      => $jigsaw_post_type,
								'taxonomy'       => jigsaw_get_post_type_taxonomy( $jigsaw_post_type ),
								'parent_cat'     => jigsaw_get_theme_option( 'parent_cat' ),
								'posts_per_page' => jigsaw_get_theme_option( 'posts_per_page' ),
								'sticky'         => jigsaw_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $jigsaw_stickies )
															&& count( $jigsaw_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		jigsaw_blog_archive_start();

		do_action( 'jigsaw_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'jigsaw_action_before_page_author' );
			get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'jigsaw_action_after_page_author' );
		}

		if ( jigsaw_get_theme_option( 'show_filters' ) ) {
			do_action( 'jigsaw_action_before_page_filters' );
			jigsaw_show_filters( $jigsaw_args );
			do_action( 'jigsaw_action_after_page_filters' );
		} else {
			do_action( 'jigsaw_action_before_page_posts' );
			jigsaw_show_posts( array_merge( $jigsaw_args, array( 'cat' => $jigsaw_args['parent_cat'] ) ) );
			do_action( 'jigsaw_action_after_page_posts' );
		}

		do_action( 'jigsaw_action_blog_archive_end' );

		jigsaw_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'jigsaw_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
