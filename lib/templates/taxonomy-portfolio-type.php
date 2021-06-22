<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( "Sorry, you are not allowed to access this page directly." );
}


// layout
add_filter( 'genesis_site_layout', 'wpts_portfolio_taxonomy_template_layout' );
function wpts_portfolio_taxonomy_template_layout( $layout ) {

	global $wp_query;

	$term   = $wp_query->get_queried_object();
	$layout = $term && isset( $term->meta['layout'] ) && $term->meta['layout'] ? $term->meta['layout'] : __genesis_return_full_width_content();

	return $layout;

}

// remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// loop
add_action( 'genesis_loop', 'wpts_portfolio_setup_loop', 9 );

genesis();
