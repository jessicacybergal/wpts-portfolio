<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( "Sorry, you are not allowed to access this page directly." );
}


// layout
add_filter( 'genesis_site_layout', 'wpts_portfolio_single_template_layout' );
function wpts_portfolio_single_template_layout( $layout ) {

	$custom_field = genesis_get_custom_field( '_genesis_layout' );
	$layout       = $custom_field ? $custom_field : genesis_get_option( 'site_layout' );

	return $layout;

}

// remove the breadcrumb navigation
remove_action( 'genesis_entry_header', 'genesis_post_info'           , 5 );
remove_action( 'genesis_after_entry' , 'genesis_do_author_box_single', 8 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta'               );

// add portfolio body class to the head
add_filter( 'body_class', 'wpts_portfolio_single_add_body_class'   );
add_filter('post_class' , 'wpts_portfolio_custom_post_class');

// add feedback at the bottom
add_action('genesis_entry_content','wpts_portfolio_feedback_block');
function wpts_portfolio_feedback_block() {
	$feedback_field_owner = genesis_get_custom_field( '_wpts_portfolio_owner' );
	$feedback_field = wpautop(genesis_get_custom_field( '_wpts_portfolio_owner_feedback' ));
	
	if ( empty($feedback_field_owner) && empty($feedback_field) ) return;
	
	printf('<figure class="portfolio-feedback"><blockquote>%s</blockquote><footer>&mdash; <cite class="author">%s</cite></footer></figure>', $feedback_field, $feedback_field_owner);
}

genesis();
