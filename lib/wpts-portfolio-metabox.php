<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( "Sorry, you are not allowed to access this page directly." );
}

// register metabox
function wpts_portfolio_add_meta_boxes( $post ){
	add_meta_box( 'wpts_portfolio_meta_box', __( 'Project Details', 'wpts-portfolio' ), 'wpts_portfolio_build_meta_box', 'wpts_portfolio', 'normal', 'high' );
}
add_action( 'add_meta_boxes_wpts_portfolio', 'wpts_portfolio_add_meta_boxes' );

// metabox form
function wpts_portfolio_build_meta_box( $post ){

	// nonce
	wp_nonce_field( basename( __FILE__ ), 'wpts_portfolio_meta_box_nonce' );

	// check for current value
	$current_project_owner = get_post_meta( $post->ID, '_wpts_portfolio_owner', true );
	$current_project_owner_feedback = get_post_meta( $post->ID, '_wpts_portfolio_owner_feedback', true );
	$current_project_featured   = get_post_meta( $post->ID, '_wpts_portfolio_featured', true );

	if ($current_project_featured == '1') {
		$project_is_featured = '1';
	} else {
		$project_is_featured = '0';
	}

	// fields ?>

	<p>
		<label for="_wpts_portfolio_owner"><strong><?php echo __( 'Project Owner', 'wpts-portfolio' ); ?></strong></label><br />
	    <input class="widefat" type="text" name="_wpts_portfolio_owner" id="_wpts_portfolio_owner" value="<?php echo $current_project_owner; ?>" />
  	</p>
	<p>
    <label for="_wpts_projects_project_featured"><strong><?php echo __( 'Portfolio is Featured?', 'wpts-portfolio' ); ?></strong></label><br>
    <input type="radio" name="_wpts_portfolio_featured" value="1" <?php checked( $project_is_featured, '1' ); ?> /> Yes
    <input type="radio" name="_wpts_portfolio_featured" value="0" <?php checked( $project_is_featured, '0' ); ?> style="margin-left: 20px" /> No
    </p>

    <p>
    <label for="_wpts_portfolio_owner_feedback"><strong><?php echo __( 'Project Feedback', 'wpts-projects' ); ?></strong></label><br />
    <?php
    $current_project_owner_feedback_id = '_wpts_portfolio_owner_feedback';
    $args = array(
      'textarea_name'=>'_wpts_portfolio_owner_feedback',
      'editor_height' => 125,
      'textarea_rows' => 20,
    );
    wp_editor( $current_project_owner_feedback, $current_project_owner_feedback_id, $args );
    ?>
  </p>

	<?php
}

// save data
function wpts_portfolio_save_meta_boxes_data( $post_id ){
	// check the nonce
  if ( !isset( $_POST['wpts_portfolio_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['wpts_portfolio_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}
  // return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
  // Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
	// featured
	if ( isset( $_REQUEST['_wpts_portfolio_featured'] ) ) {
		update_post_meta( $post_id, '_wpts_portfolio_featured', sanitize_text_field( $_POST['_wpts_portfolio_featured'] ) );
	}
  // If fields is change/set, update
  if ( isset( $_REQUEST['_wpts_portfolio_owner'] ) ) {
		update_post_meta( $post_id, '_wpts_portfolio_owner', sanitize_text_field( $_POST['_wpts_portfolio_owner'] ) );
	}
  if ( isset( $_REQUEST['_wpts_portfolio_owner_feedback'] ) ) {
		update_post_meta( $post_id, '_wpts_portfolio_owner_feedback', esc_textarea( $_POST['_wpts_portfolio_owner_feedback'] ) );
	}
}
add_action( 'save_post_wpts_portfolio', 'wpts_portfolio_save_meta_boxes_data', 10, 2 );