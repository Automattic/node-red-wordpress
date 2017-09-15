<?php

class Node_Red_WP_Data_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'node_red_wp_data_widget', 
			esc_html__( 'Node Red Data', 'nrwp' ), 
			array(
				'classname' => 'nrwp_data_widget',
				'description' => esc_html__( 'Display real time data from Node Red.', 'nrwp' ), 
			)
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		echo sprintf( '<span class="nrwp-data nrwp-data-%s" data-key="%s" data-value="%s">%s</span>',
			esc_attr( $instance['datakey'] ),
			esc_attr( $instance['datakey'] ),
			esc_attr( Node_Red_WP::init()->data->get( $instance['datakey'] ) ),
			esc_html( Node_Red_WP::init()->data->get( $instance['datakey'] ) )
		);

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$datakey = ! empty( $instance['datakey'] ) ? $instance['datakey'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'nrwp' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'datakey' ) ); ?>"><?php esc_attr_e( 'Data Key:', 'nrwp' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'datakey' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'datakey' ) ); ?>" type="text" value="<?php echo esc_attr( $datakey ); ?>">
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['datakey'] = ( ! empty( $new_instance['datakey'] ) ) ? sanitize_text_field( $new_instance['datakey'] ) : '';

		return $instance;
	}

}
