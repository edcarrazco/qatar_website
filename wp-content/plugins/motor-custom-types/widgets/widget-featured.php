<?php
class MotorFeaturedPosts_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'motorfeaturedposts_widget',
			esc_html__( 'Motor Featured Posts', 'motor-custom-types' ),
			array(
				'classname'   => 'motorfeaturedposts_widget',
				'description' => esc_html__( 'Featured Blog Posts', 'motor-custom-types' )
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

    	$title = apply_filters( 'widget_title', $instance['title'] );
    	$posts_count = intval($instance['posts_count']);
		$posts_ids = strip_tags($instance['posts_ids']);
		$posts_ids = str_replace(' ', '', $posts_ids);
		$posts_ids_arr = explode(',', $posts_ids);

    	echo $before_widget;

    	if ( $title ) {
    		echo $before_title . $title . $after_title;
    	}
		if (empty($posts_ids_arr) || empty($posts_ids_arr[0])) {
			$posts_ids_arr = array();
		}

    	$feautured_query = new WP_Query( array(
    		'post_type'   => 'post',
    		'post_status' => 'publish',
			'posts_per_page' => $posts_count,
			'post__in' => $posts_ids_arr,
    		) );
    	if ($feautured_query->have_posts()) :

    		while ($feautured_query->have_posts()) : $feautured_query->the_post();
				$category = get_the_category();
				?>
				<div class="blog-featured">
					<p class="blog-featured-info">
						<?php if (!empty($category)) : ?>
							<?php foreach ($category as $key=>$cat) : ?>
								<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo $cat->name; ?></a><?php echo ($key+1<count($category)) ? ', ' : ''; ?>
							<?php endforeach; ?>
						<?php endif; ?>
						<time datetime="<?php echo get_the_date('Y-m-d H:i'); ?>"><?php echo get_the_date(); ?></time>
					</p>
					<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
				</div>
	    	<?php
			endwhile;
	    endif;
	    wp_reset_postdata();

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
		$instance['posts_ids'] = strip_tags( $new_instance['posts_ids'] );

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
    		$title = esc_attr( $instance['title'] );
    	} else {
    		$title = '';
    	}
    	if (!empty($instance['posts_count'])) {
    		$posts_count = esc_attr( $instance['posts_count'] );
    	} else {
    		$posts_count = '';
    	}
		if (!empty($instance['posts_ids'])) {
			$posts_ids = esc_attr( $instance['posts_ids'] );
		} else {
			$posts_ids = '';
		}
    	?>
    	<p>
    		<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'motor-custom-types'); ?></label> 
    		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>">
    	</p>
    	<p>
    		<label for="<?php echo $this->get_field_id('posts_count'); ?>"><?php esc_html_e('Posts Count:', 'motor-custom-types'); ?></label> 
    		<input class="widefat" id="<?php echo $this->get_field_id('posts_count'); ?>" name="<?php echo $this->get_field_name('posts_count'); ?>" type="text" value="<?php echo $posts_count; ?>">
    	</p>
		<p>
			<label for="<?php echo $this->get_field_id('posts_ids'); ?>"><?php esc_html_e('Posts IDs', 'motor-custom-types'); ?></label><span class="description"><br><?php esc_html_e('Comma separated e.g.: 5, 8, 10', 'motor-custom-types'); ?> <br><?php esc_html_e('Or leave empty to show newness posts', 'motor-custom-types'); ?></span>
			<input class="widefat" id="<?php echo $this->get_field_id('posts_ids'); ?>" name="<?php echo $this->get_field_name('posts_ids'); ?>" type="text" value="<?php echo $posts_ids; ?>">
		</p>
    	<?php
    }

}

/* Register the widget */
function motor_feature_posts_widget_init () {
	register_widget( 'MotorFeaturedPosts_Widget' );
}
add_action( 'widgets_init', 'motor_feature_posts_widget_init');