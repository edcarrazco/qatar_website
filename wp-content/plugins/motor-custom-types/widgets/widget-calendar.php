<?php
class MotorCalendar_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'motorcalendar_widget',
			esc_html__( 'Motor Events Calendar', 'motor-custom-types' ),
			array(
				'classname'   => 'motorcalendar_widget',
				'description' => esc_html__( 'Calendar with Events', 'motor-custom-types' )
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

    	echo $before_widget;

    	if ( $title ) {
    		echo $before_title . $title . $after_title;
    	}

		$events_query = new WP_Query( array(
			'post_type'   => 'events',
			'post_status' => 'publish',
			'order'               => 'DESC',
			'orderby'             => 'date',
			'posts_per_page'         => 50,
		) );
		if ($events_query->have_posts()) :
		?>
			<div class="blog-calendar" id="blog-calendar"></div>
			<script>
			function myDateFunction(id) {
				var date = jQuery("#" + id).data("date");
				var hasEvent = jQuery("#" + id).data("hasEvent");
				if (!hasEvent) {
					return false;
				}
				jQuery('#blog-calendar-cont').html(jQuery("#" + id).attr("title")).slideDown();
				return true;
			}
			var eventData = [
			<?php
			while ($events_query->have_posts()) : $events_query->the_post();
				$events_date = get_post_meta(get_the_ID(), 'motor_events_date', true);
        		$events_cont = get_the_content();
        		$events_cont = str_replace( array( "\n", "\r" ), array( "\\n", "\\r" ), $events_cont );
			?>
			{"date":"<?php echo $events_date?>","badge":false,"title":"<h4><?php the_title(); ?></h4> <?php echo $events_cont; ?>"},
			<?php endwhile; ?>
			];
			</script>
			<div class="blog-calendar-cont" id="blog-calendar-cont"></div>
		<?php endif;

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
    	?>

    	<p> 
    		<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'motor-custom-types'); ?></label> 
    		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    	</p>
    	<?php 
    }

}

/* Register the widget */
function motor_calendar_widget_init () {
	register_widget( 'MotorCalendar_Widget' );
}
add_action( 'widgets_init', 'motor_calendar_widget_init');