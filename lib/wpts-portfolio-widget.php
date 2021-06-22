<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( "Sorry, you are not allowed to access this page directly." );
}

class WPTS_PORTFOLIO_WIDGET extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname'=>'wpts-portfolio-widget','description'=>__('Widget to display portfolio slider.','wpts-portfolio') );
		parent::__construct( 'wpts-portfolio-widget', __('Portfolio Slider','wpts-portfolio'), $widget_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$subtitle = apply_filters('widget_subtitle', $instance['subtitle']);
		$featured_only = $instance['featured_only'] ? 'on' : 'off';

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		if ( $subtitle ) {
			echo '<h4 class="widget-subtitle">' . $subtitle . '</h4>';
		}

		$this->getPortfolio($featured_only);

		echo $after_widget;
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$subtitle = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$featured_only = isset($instance['featured_only']) ? 'on' : 'off';


		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'wpts-portfolio' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"><?php esc_attr_e( 'Subitle:', 'wpts-portfolio' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>" />
		</p>
		<p>
		<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'featured_only' ) ); ?>" name="<?php echo $this->get_field_name( 'featured_only' ); ?>" type="checkbox" <?php checked($instance['featured_only'], 'on'); ?>/>
		<label for="<?php echo esc_attr( $this->get_field_id( 'featured_only' ) ); ?>"><strong><?php esc_attr_e( 'Display featured portfolio only', 'wpts-portfolio' ); ?></strong></label> 
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['subtitle'] = ( ! empty( $new_instance['subtitle'] ) ) ? strip_tags( $new_instance['subtitle'] ) : '';
		$instance['featured_only'] = $new_instance['featured_only'];

		return $instance;
	}

	public function wpts_portfolio_image() {
		$image = genesis_get_image( array(
			'format'  => 'html',
			'size'    => 'portfolio-slide',
			'context' => 'archive',
			'attr'    => array ( 'alt' => the_title_attribute( 'echo=0' ), 'class' => 'portfolio-slide', 'title' => the_title_attribute( 'echo=0' ), ),
		) );

		if ( $image ) {
			printf( '<div class="portfolio-image"><a href="%s" rel="bookmark">%s</a></div>', get_permalink(), $image );
		}
	}

	public function wpts_portfolio_data() {

		$wpts_author = get_post_meta( get_the_ID(), '_wpts_portfolio_owner', true );
		$wpts_author_feedback = wpautop( get_post_meta( get_the_ID(), '_wpts_portfolio_owner_feedback', true ) );

		printf('<div class="portfolio-content">%s <p class="project-owner">%s</p></div>', $wpts_author_feedback, $wpts_author );
	}

	public function getPortfolio($featured_only) {
		
		global $post;
		
		if ( $featured_only == 'on' ) {
			$args = array('post_type'=>'wpts_portfolio','showposts' => '-1', 'meta_key'   => '_wpts_portfolio_featured', 'meta_value' => '1');			
		} else {
			$args = array('post_type'=>'wpts_portfolio','showposts' => '-1');
		}

		

		$query = new WP_Query( $args );
		

		if ( $query->have_posts() ) :
			?><div class="portfolio-wrapper"><?php $counter = 1;
			while ( $query->have_posts() ) : 
				$query->the_post();
				?>
				<div class="portfolio-entry <?php
				if ( $counter == 1) {
					echo 'entry-first';
				}
				elseif ( $counter == 2 ) {
					echo 'entry-second';
				}
				else {
					echo 'entry-third';
				}
				?>">
					<div class="portfolio-inner">
						<?php $this->wpts_portfolio_image(); ?>
						<?php $this->wpts_portfolio_data(); ?>
					</div>
				</div>
				<?php

				$counter++;

				if ( $counter >= 4) {
					$counter = 1;
				}
			endwhile;
			wp_reset_postdata();
			?></div><?php
			
		endif;

		
	}

}

function wpts_portfolio_register_widget() {
    register_widget( 'WPTS_PORTFOLIO_WIDGET' );
}
add_action( 'widgets_init', 'wpts_portfolio_register_widget' );