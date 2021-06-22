<?php



if ( ! defined( 'ABSPATH' ) ) {

	die( "Sorry, you are not allowed to access this page directly." );

}





// Register Custom Post Type

function wpts_portfolio_register_posttype() {



	$labels = array(

		'name'                  => _x( 'Portfolio', 'Post Type General Name', 'wpts-portfolio' ),

		'singular_name'         => _x( 'Portfolio', 'Post Type Singular Name', 'wpts-portfolio' ),

		'menu_name'             => __( 'Portfolio', 'wpts-portfolio' ),

		'name_admin_bar'        => __( 'Portfolio', 'wpts-portfolio' ),

		'archives'              => __( 'Item Archives', 'wpts-portfolio' ),

		'attributes'            => __( 'Item Attributes', 'wpts-portfolio' ),

		'parent_item_colon'     => __( 'Parent Item:', 'wpts-portfolio' ),

		'all_items'             => __( 'All Portfolio', 'wpts-portfolio' ),

		'add_new_item'          => __( 'Add new Portfolio', 'wpts-portfolio' ),

		'add_new'               => __( 'Add Portfolio', 'wpts-portfolio' ),

		'new_item'              => __( 'New Item', 'wpts-portfolio' ),

		'edit_item'             => __( 'Edit Item', 'wpts-portfolio' ),

		'update_item'           => __( 'Update Item', 'wpts-portfolio' ),

		'view_item'             => __( 'View Item', 'wpts-portfolio' ),

		'view_items'            => __( 'View Items', 'wpts-portfolio' ),

		'search_items'          => __( 'Search Item', 'wpts-portfolio' ),

		'not_found'             => __( 'Not found', 'wpts-portfolio' ),

		'not_found_in_trash'    => __( 'Not found in Trash', 'wpts-portfolio' ),

		'featured_image'        => __( 'Featured Image', 'wpts-portfolio' ),

		'set_featured_image'    => __( 'Set featured image', 'wpts-portfolio' ),

		'remove_featured_image' => __( 'Remove featured image', 'wpts-portfolio' ),

		'use_featured_image'    => __( 'Use as featured image', 'wpts-portfolio' ),

		'insert_into_item'      => __( 'Insert into item', 'wpts-portfolio' ),

		'uploaded_to_this_item' => __( 'Uploaded to this item', 'wpts-portfolio' ),

		'items_list'            => __( 'Items list', 'wpts-portfolio' ),

		'items_list_navigation' => __( 'Items list navigation', 'wpts-portfolio' ),

		'filter_items_list'     => __( 'Filter items list', 'wpts-portfolio' ),

	);

	$rewrite = array(

		'slug'                  => 'portfolio',

		'with_front'            => true,

		'pages'                 => true,

		'feeds'                 => true,

	);

	$args = array(

		'label'                 => __( 'Portfolio', 'wpts-portfolio' ),

		'description'           => __( 'Portfolio for WPTS Themes', 'wpts-portfolio' ),

		'labels'                => $labels,

		'supports'              => array( 'title', 'editor', 'thumbnail', 'genesis-cpt-archives-settings'),

		'taxonomies'            => array( 'portfolio-type' ),

		'hierarchical'          => true,

		'public'                => true,

		'show_ui'               => true,

		'show_in_menu'          => true,

		'menu_position'         => 5,

		'menu_icon'             => 'dashicons-portfolio',

		'show_in_admin_bar'     => true,

		'show_in_nav_menus'     => true,

		'can_export'            => true,

		'has_archive'           => true,

		'exclude_from_search'   => false,

		'publicly_queryable'    => true,

		'rewrite'               => $rewrite,

		'capability_type'       => 'page',

	);

	register_post_type( 'wpts_portfolio', $args );



}

add_action( 'init', 'wpts_portfolio_register_posttype', 0 );



// Register Custom Taxonomy

function wpts_portfolio_register_taxonomy() {



	$labels = array(

		'name'                       => _x( 'Types', 'Taxonomy General Name', 'wpts-portfolio' ),

		'singular_name'              => _x( 'Portfolio type', 'Taxonomy Singular Name', 'wpts-portfolio' ),

		'menu_name'                  => __( 'Portfolio type', 'wpts-portfolio' ),

		'all_items'                  => __( 'All Items', 'wpts-portfolio' ),

		'parent_item'                => __( 'Parent Item', 'wpts-portfolio' ),

		'parent_item_colon'          => __( 'Parent Item:', 'wpts-portfolio' ),

		'new_item_name'              => __( 'New Item Name', 'wpts-portfolio' ),

		'add_new_item'               => __( 'Add New Item', 'wpts-portfolio' ),

		'edit_item'                  => __( 'Edit Item', 'wpts-portfolio' ),

		'update_item'                => __( 'Update Item', 'wpts-portfolio' ),

		'view_item'                  => __( 'View Item', 'wpts-portfolio' ),

		'separate_items_with_commas' => __( 'Separate items with commas', 'wpts-portfolio' ),

		'add_or_remove_items'        => __( 'Add or remove items', 'wpts-portfolio' ),

		'choose_from_most_used'      => __( 'Choose from the most used', 'wpts-portfolio' ),

		'popular_items'              => __( 'Popular Items', 'wpts-portfolio' ),

		'search_items'               => __( 'Search Items', 'wpts-portfolio' ),

		'not_found'                  => __( 'Not Found', 'wpts-portfolio' ),

		'no_terms'                   => __( 'No items', 'wpts-portfolio' ),

		'items_list'                 => __( 'Items list', 'wpts-portfolio' ),

		'items_list_navigation'      => __( 'Items list navigation', 'wpts-portfolio' ),

	);

	$rewrite = array(

		'slug'                       => 'portfolio-type',

		'with_front'                 => true,

		'hierarchical'               => true,

	);

	$args = array(

		'labels'                     => $labels,

		'hierarchical'               => true,

		'public'                     => true,

		'show_ui'                    => true,

		'show_admin_column'          => true,

		'show_in_nav_menus'          => true,

		'show_tagcloud'              => true,

		'show_in_rest' 				 => true,

		'rewrite'                    => $rewrite,

	);

	register_taxonomy( 'portfolio-type', array( 'wpts_portfolio' ), $args );



}

add_action( 'init', 'wpts_portfolio_register_taxonomy', 0 );



// create shortcode to list all clothes which come in blue
add_shortcode( 'wpts-portfolio', 'rmcc_post_listing_shortcode1' );

function rmcc_post_listing_shortcode1( $atts ) {
    ob_start();

     extract( shortcode_atts( array (
        'type' => 'wpts_portfolio',
        'posts' => -1,
        'portfolio_type' => '',
        'thumb' => 'off'
    ), $atts ) );


     $options = array(
        'post_type' => $type,
        'posts_per_page' => $posts,
        'portfolio-type' => $portfolio_type,
    );

   $query = new WP_Query( $options );

    if ( $query->have_posts() ) { ?>
        <div class="wpts-list">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<div class="inner">
					<a href="<?php the_permalink(); ?>">
						<div class="thumb">
							<?php if ( $thumb == 'off' ) { the_post_thumbnail(); } else { the_post_thumbnail('portfolio-slide-thumb'); } ?>
						</div>
						<div class="title"><h4><?php the_title(); ?></h4></div>
					</a>
				</div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}





include_once( WPTS_PORTFOLIO_LIB . 'wpts-portfolio-metabox.php');

include_once( WPTS_PORTFOLIO_LIB . 'wpts-portfolio-widget.php');