<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( "Sorry, you are not allowed to access this page directly." );
}

// layout
add_filter( 'genesis_site_layout', 'wpts_portfolio_archive_template_layout' );
function wpts_portfolio_archive_template_layout( $layout ) {

	$archive_opts = get_option( 'genesis-cpt-archive-settings-wpts_portfolio' );
	$layout       = empty( $archive_opts['layout'] ) ? __genesis_return_full_width_content() : $archive_opts['layout'];

	return $layout;

}

// remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// portfolio loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'wpts_portfolio_setup_loop', 9 );

// add portfolio body class to the head
add_filter( 'body_class', 'wpts_portfolio_archive_add_body_class'   );
add_filter('post_class' , 'wpts_portfolio_custom_post_class');

remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

genesis();
