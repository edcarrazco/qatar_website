<?php
class MotorFeaturedProducts_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'motorfeaturedproducts_widget',
			esc_html__( 'Motor Featured Products', 'motor-custom-types' ),
			array(
				'classname'   => 'motorfeaturedproducts_widget',
				'description' => esc_html__( 'Featured Products', 'motor-custom-types' )
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
		$products_count    = intval($instance['products_count']);
		$products_ids    = strip_tags($instance['products_ids']);
		$products_ids = str_replace(' ', '', $products_ids);
		$products_ids_arr = explode(',', $products_ids);

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		if (empty($posts_ids_arr) || empty($posts_ids_arr[0])) {
			$products_ids_arr = array();
		}

		$feautured_query = new WP_Query( array(
			'post_type'   => 'product',
			'post_status' => 'publish',
			'posts_per_page' => $products_count,
			'post__in' => $products_ids_arr,
		) );
		if ($feautured_query->have_posts()) :
			?>
			<div class="products-featured-wrap">
				<?php
				while ($feautured_query->have_posts()) : $feautured_query->the_post();
					global $product;
					$product_categories = get_the_terms( get_the_ID(), 'product_cat' );
					?>
					<div class="blog-featured">
						<p class="blog-featured-info">
							<?php if (!empty($product_categories)) : ?>
								<?php foreach ($product_categories as $key=>$cat) : ?>
									<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo $cat->name; ?></a><?php echo ($key+1<count($product_categories)) ? ', ' : ''; ?>
								<?php endforeach; ?>
							<?php endif; ?>
							<time datetime="<?php echo get_the_date('Y-m-d H:i'); ?>"><?php echo get_the_date(); ?></time>
						</p>
						<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
						<?php if ( $price_html = $product->get_price_html() ) : ?>
							<p class="blog-featured-price"><?php echo $price_html; ?></p>
						<?php endif; ?>
					</div>
					<?php
				endwhile;
				?>
			</div>
			<?php
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
		$instance['products_count'] = strip_tags( $new_instance['products_count'] );
		$instance['products_ids'] = strip_tags( $new_instance['products_ids'] );

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
		if (!empty($instance['products_count'])) {
			$products_count      = esc_attr( $instance['products_count'] );
		} else {
			$products_count      = '';
		}
		if (!empty($instance['products_ids'])) {
			$products_ids      = esc_attr( $instance['products_ids'] );
		} else {
			$products_ids      = '';
		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'motor-custom-types'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('products_count'); ?>"><?php esc_html_e('Products Count:', 'motor-custom-types'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('products_count'); ?>" name="<?php echo $this->get_field_name('products_count'); ?>" type="text" value="<?php echo $products_count; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('products_ids'); ?>"><?php esc_html_e('Product IDs', 'motor-custom-types'); ?></label><span class="description"><br><?php esc_html_e('Comma separated e.g.: 5, 8, 10', 'motor-custom-types'); ?> <br><?php esc_html_e('Or leave empty to show newness products', 'motor-custom-types'); ?></span>
			<input class="widefat" id="<?php echo $this->get_field_id('products_ids'); ?>" name="<?php echo $this->get_field_name('products_ids'); ?>" type="text" value="<?php echo $products_ids; ?>" />
		</p>

		<?php
	}

}

/* Register the widget */
function motor_feature_products_widget_init () {
	register_widget( 'MotorFeaturedProducts_Widget' );
}
add_action( 'widgets_init', 'motor_feature_products_widget_init');