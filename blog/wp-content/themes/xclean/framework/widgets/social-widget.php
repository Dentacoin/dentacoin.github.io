<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
/**
 * 
 * A widget that displays social icons.
 *
 */

class Xclean_Social_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 
			'social-widget',
			esc_html__( 'Xclean: Social Widget', 'xclean' ),
			array(
				'classname'   => 'social-widget',
				'description' => esc_html__( 'A custom widget displays social icons.', 'xclean' )
			) 
		);
	}

	public function form($instance) {
			
		if ( empty( $instance['title'] ) ) {
			$instance['title'] = '';
		}

		if ( empty( $instance['facebook'] ) ) {
			$instance['facebook'] = '';
		}

		if ( empty( $instance['twitter'] ) ) {
			$instance['twitter'] = '';
		}

		if ( empty( $instance['google'] ) ) {
			$instance['google'] = '';
		}

		if ( empty( $instance['tumblr'] ) ) {
			$instance['tumblr'] = '';
		}

		if ( empty( $instance['dribbble'] ) ) {
			$instance['dribbble'] = '';
		}

		foreach ( $instance as $key => $value ) : ?>

			<p>
				<label for="<?php echo $this->get_field_id( 'defaults' ); ?>"><?php echo $key; ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>">
			</p>
		
		<?php 
		endforeach;
	}

	public function update( $new_instance, $old_instance ) {

			$instance['title']    = esc_html( $new_instance['title'] );
			$instance['facebook'] = esc_url_raw( $new_instance['facebook'] );
			$instance['twitter']  = esc_url_raw( $new_instance['twitter'] );
			$instance['google']   = esc_url_raw( $new_instance['google'] );
			$instance['tumblr']   = esc_url_raw( $new_instance['tumblr'] );
			$instance['dribbble'] = esc_url_raw( $new_instance['dribbble'] );

			return $instance;
	}
	 
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];

			if ( ! empty( $title ) ) { 
				echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
			} 
			
			echo '<ul>';

				if ( ! empty( $instance['facebook'] ) ) {
					echo '<li><a href="' . esc_url( $instance['facebook'] ) . '"><i class="fa fa-facebook"></i></a></li> '; 
				}

				if ( ! empty( $instance['twitter'] ) ) {
					echo '<li><a href="' . esc_url( $instance['twitter'] ) . '"><i class="fa fa-twitter"></i></a></li>'; 
				}

				if ( ! empty( $instance['google'] ) ) {
					echo '<li><a href="' . esc_url( $instance['google'] ) . '"><i class="fa fa-google-plus"></i></a></li>'; 
				}

				if ( ! empty( $instance['tumblr'] ) ) {
					echo '<li><a href="' . esc_url( $instance['tumblr'] ) . '"><i class="fa fa-tumblr"></i></a></li>'; 
				}

				if ( ! empty( $instance['dribbble'] ) ) {
					echo '<li><a href="' .  esc_url( $instance['dribbble'] ) . '" target="_self"><i class="fa fa-dribbble"></i></a></li>'; 
				}
			
			echo '</ul>';
			
		echo $args['after_widget']; 
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget( "Xclean_Social_Widget" );' ) );
?>