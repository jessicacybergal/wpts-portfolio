<?php
/*
  Plugin Name: WPTS Portfolio
  Plugin URI: http://webpagesthatsell.com/
  Description: Add portfolio custom post type.
  Version: 1.0.0
  Author: Jessica Antipuesto
  Author URI: http://webpagesthatsell.com/
  Text Domain: wpts-portfolio
  Domain Path: /languages

*/

if ( ! defined( 'ABSPATH' ) ) {
	die( "Sorry, you are not allowed to access this page directly." );
}

// define constant
define( 'WPTS_PORTFOLIO_LIB', dirname( __FILE__ ) . '/lib/');
define( 'WPTS_PORTFOLIO_URL', plugin_dir_url( __FILE__) );

// include post type resgistrator
include_once( WPTS_PORTFOLIO_LIB . 'wpts-portfolio-posttype-taxonomy.php');

// activation and deactivation hook
register_activation_hook( __FILE__, 'wpts_portfolio_activation' );
register_deactivation_hook( __FILE__, 'wpts_portfolio_deactivation' );


function wpts_portfolio_activation() {

	// register portfolio post type
	wpts_portfolio_register_posttype();

	// clear the permalinks after the post type has been registered
	flush_rewrite_rules();

}

function wpts_portfolio_deactivation() {

	// clear the permalinks to remove our post type's rules
	flush_rewrite_rules();

}

// portfolio template loader
add_action( 'genesis_init', 'wpts_portfolio_init' );
function wpts_portfolio_init() {
	require_once( WPTS_PORTFOLIO_LIB . 'template-loader.php' );

	add_action( 'after_setup_theme', 'wpts_portfolio_after_setup_theme' );
}

// portfolio after setup
function wpts_portfolio_after_setup_theme() {

	global $_wp_additional_image_sizes;

	if ( ! isset( $_wp_additional_image_sizes['portfolio'] ) ) {
		add_image_size( 'portfolio', 365, 280, TRUE );
	}

	if ( ! isset( $_wp_additional_image_sizes['portfolio-slide'] ) ) {
		add_image_size( 'portfolio-slide', 365, 300, TRUE );
	}
	
	if ( ! isset( $_wp_additional_image_sizes['portfolio-slide-thumb'] ) ) {
		add_image_size( 'portfolio-slide-thumb', 380, 292, TRUE );
	}
}

// portfolio setup
function wpts_portfolio_setup_loop(){

	$hooks = array(
		'genesis_before_entry',
		'genesis_entry_header',
		'genesis_before_entry_content',
		'genesis_entry_content',
		'genesis_after_entry_content',
		'genesis_entry_footer',
		'genesis_after_entry',
	);

	foreach ( $hooks as $hook ) {
		remove_all_actions( $hook );
	}

	add_action( 'genesis_entry_content'      , 'wpts_portfolio_grid'                );
	add_action( 'genesis_after_entry_content', 'genesis_entry_header_markup_open' , 5  );
	add_action( 'genesis_after_entry_content', 'genesis_entry_header_markup_close', 15 );
	add_action( 'genesis_after_entry_content', 'genesis_do_post_title'                 );

	$args = array(
		'post_type' => 'wpts_portfolio',
		'nopaging' => true
		);

	genesis_custom_loop( $args );

}

// portfolio image
function wpts_portfolio_grid() {

	$image = genesis_get_image( array(
			'format'  => 'html',
			'size'    => 'portfolio',
			'context' => 'archive',
			'attr'    => array ( 'alt' => the_title_attribute( 'echo=0' ), 'class' => 'portfolio-image' ),
		) );

	if ( $image ) {
		printf( '<div class="portfolio-featured-image"><a href="%s" rel="bookmark">%s</a></div>', get_permalink(), $image );
	}

}


// body and post class
function wpts_portfolio_single_add_body_class( $classes ) {

	$classes[] = 'wpts-portfolio-single';
	return $classes;

}

function wpts_portfolio_archive_add_body_class( $classes ) {

	$classes[] = 'wpts-portfolio-archive';
	return $classes;

}

function wpts_portfolio_custom_post_class( $classes ) {

	if ( is_main_query() ) {
		$classes[] = 'wpts-portfolio';
	}

	return $classes;
}

// front end style
function wpts_portfolio_load_default_styles() {

	wp_deregister_style( 'slick-slider');
	wp_register_style( 'slick-slider', WPTS_PORTFOLIO_URL . 'css/slick.css', array(), '1.6.0' );
	wp_enqueue_style( 'slick-slider');

	wp_register_style( 'wpts_portfolio', WPTS_PORTFOLIO_URL . 'css/wpts-style.css', array('slick-slider'), '1.0.0' );
	wp_enqueue_style( 'wpts_portfolio' );

	wp_deregister_script( 'slick-slider');
	wp_register_script( 'slick-slider', WPTS_PORTFOLIO_URL . 'js/slick.min.js', array('jquery'), '1.6.0', true );
	wp_enqueue_script( 'slick-slider');

	wp_add_inline_script( 'slick-slider', 'jQuery(document).ready(function(o){o(".front-portfolio .portfolio-wrapper").slick({infinite:!0,slidesToShow:2,slidesToScroll:1,dots:!1,speed:1e3,arrows:!1,autoplay:!0,autoplaySpeed:4e3,cssEase:"linear",responsive:[{breakpoint:1200,settings:{slidesToShow:1,slidesToScroll:1}}]})});' );

}
add_action( 'wp_enqueue_scripts', 'wpts_portfolio_load_default_styles' );