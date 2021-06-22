<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( "Sorry, you are not allowed to access this page directly." );
}


define( 'WPTS_PORTFOLIO_TEMPLATE_DIR', WPTS_PORTFOLIO_LIB . 'templates/' );

function wpts_portfolio_get_template_hierarchy( $template ) {

	// Get the template slug
	$template_slug = rtrim( $template, '.php' );
	$template = $template_slug . '.php';

	// Check if a custom template exists in the theme folder, if not, load the plugin template file
	if ( $theme_file = locate_template( array( $template ) ) ) {
		$file = $theme_file;
	}
	else {
		$file = WPTS_PORTFOLIO_TEMPLATE_DIR . $template;
	}

	return apply_filters( 'wpts_portfolio_repl_template_' . $template, $file );
}



add_filter( 'template_include', 'wpts_portfolio_template_chooser' );
function wpts_portfolio_template_chooser( $template ) {

	if ( is_front_page() ) {
		return $template;
	}

	// Post ID
	$post_id = get_the_ID();

	if ( ! is_search() && get_post_type( $post_id ) == 'wpts_portfolio' || is_post_type_archive( 'wpts_portfolio' ) || is_tax( 'portfolio-type' ) ) {
		require_once( WPTS_PORTFOLIO_LIB . 'wpts-portfolio-posttype-taxonomy.php' );
	}
	if ( is_single() && get_post_type( $post_id ) == 'wpts_portfolio' ) {
		return wpts_portfolio_get_template_hierarchy( 'single-portfolio' );
	}
	elseif ( is_post_type_archive( 'wpts_portfolio' ) ) {
		return wpts_portfolio_get_template_hierarchy( 'archive-portfolio' );
	}
	elseif ( is_tax( 'portfolio-type' ) ) {
		return wpts_portfolio_get_template_hierarchy( 'taxonomy-portfolio-type' );
	}

	return $template;

}
