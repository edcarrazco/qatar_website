<?php
class MotorBrands_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'motorbrands_widget',
			esc_html__( 'Motor Brands', 'motor-custom-types' ),
			array(
				'classname'   => 'motorbrands_widget',
				'description' => esc_html__( 'Brands List', 'motor-custom-types' )
				)
			);
	}

    /**  
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {

    	extract( $args );

    	$title      = apply_filters( 'widget_title', $instance['title'] );
    	$posts_count    = intval($instance['posts_count']);
    	if (empty($posts_count)) {
    		$posts_count = '';
    	}

    	echo $before_widget;

    	if ( $title ) {
    		echo $before_title . $title . $after_title;
    	}

    	$terms_list = get_terms(array(
			'taxonomy'      => 'product_brands', // название таксономии с WP 4.5
			'orderby'       => 'name', 
			'order'         => 'ASC',
			'hide_empty'    => true, 
			'number'        => $posts_count, 
			'hierarchical'  => false, 
    	));
    	if (!empty($terms_list)) :
    	?>
    	<ul class="brands-list-sb">
    		<?php foreach ($terms_list as $term) : ?>
    		<li>
    			<a href="<?php echo get_term_link($term->term_id, 'product_brands'); ?>"><?php echo $term->name; ?> <?php if (!empty($term->count)) echo '<span class="count">'.$term->count.'</span>'; ?></a>
    		</li>
    		<?php endforeach; ?>
    	</ul>
    	<?php

    	endif;

		echo $after_widget;

	}


    /**
      * Sanitize widget form values as they are saved.
      *
      * @see WP_Widget::update()
      *
      * @param array $new_instance Values just sent to be saved.
      * @param array $old_instance Previously saved values from database.
      *
      * @return array Updated safe values to be saved.
      */
    public function update( $new_instance, $old_instance ) {        

    	$instance = $old_instance;

    	$instance['title'] = strip_tags( $new_instance['title'] );
    	$instance['posts_count'] = strip_tags( $new_instance['posts_count'] );

    	return $instance;

    }

    /**
      * Back-end widget form.
      *
      * @see WP_Widget::form()
      *
      * @param array $instance Previously saved values from database.
      */
    public function form( $instance ) {    

    	if (!empty($instance['title'])) {
    		$title      = esc_attr( $instance['title'] );
    	} else {
    		$title      = '';
    	}
    	if (!empty($instance['posts_count'])) {
    		$posts_count      = esc_attr( $instance['posts_count'] );
    	} else {
    		$posts_count      = '';
    	}
    	?>

    	<p>
    		<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'motor-custom-types'); ?></label> 
    		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    	</p>
    	<p>
    		<label for="<?php echo $this->get_field_id('posts_count'); ?>"><?php esc_html_e('Posts Count:', 'motor-custom-types'); ?></label> 
    		<input class="widefat" id="<?php echo $this->get_field_id('posts_count'); ?>" name="<?php echo $this->get_field_name('posts_count'); ?>" type="text" value="<?php echo $posts_count; ?>" />
    	</p>

    	<?php 
    }

}

/* Register the widget */
function motor_brands_widget_init () {
	register_widget( 'MotorBrands_Widget' );
}
add_action( 'widgets_init', 'motor_brands_widget_init');