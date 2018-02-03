<?php
/*
Plugin Name: Motor Custom Types
Description: A plugin that will create custom post types.
Version: 1.0
Author: Stockware
Author URI: http://themeforest.net/user/stockware
License: GNU General Public License
*/


load_plugin_textdomain('motor-custom-types');


function motor_widget_scripts_styles() {
	wp_enqueue_style('zabuto_calendar', plugin_dir_url(__FILE__).'/css/zabuto_calendar.css', array(), null, 'all');
	wp_enqueue_script( 'zabuto_calendar', plugin_dir_url(__FILE__).'/js/zabuto_calendar.min.js', array( 'jquery' ), null, true);
}
add_action( 'wp_enqueue_scripts', 'motor_widget_scripts_styles' );


function motor_admin_scripts_styles() {
	wp_enqueue_script('motor-admin-js', plugin_dir_url(__FILE__).'/js/admin-js.js', array( 'jquery' ), null, true);
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'motor_admin_scripts_styles' );


function register_events_post_type() {
	$labels = array(
		'name'                => esc_html__( 'Events', 'motor-custom-types' ),
		'singular_name'       => esc_html__( 'Events', 'motor-custom-types' ),
		'menu_name'           => esc_html__( 'Events', 'motor-custom-types' ),
	);
	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'description'         => 'description',
		'taxonomies'          => array(),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-calendar',
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => true,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports'            => array(
			'title', 'editor'
			)
	);
	register_post_type( 'events', $args );
}
add_action( 'init', 'register_events_post_type' );




function register_motor_gallery_post_type() {
	$labels = array(
		'name'                => esc_html__( 'Gallery', 'motor-custom-types' ),
		'singular_name'       => esc_html__( 'Gallery', 'motor-custom-types' ),
		'menu_name'           => esc_html__( 'Gallery', 'motor-custom-types' ),
	);
	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'description'         => 'description',
		'taxonomies'          => array(),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-clipboard',
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports'            => array('title', 'editor', 'thumbnail')
	);
	register_post_type( 'motor_gallery', $args );
}
add_action( 'init', 'register_motor_gallery_post_type' );



add_action('init', 'motor_gallery_taxonomy');
function motor_gallery_taxonomy(){
	$labels = array(
		'name'              => esc_html__( 'Categories', 'motor-custom-types' ),
		'singular_name'     => esc_html__( 'Category', 'motor-custom-types' ),
	);
	$args = array(
		'public'                => true,
		'publicly_queryable'    => null,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_tagcloud'         => true,
		'hierarchical'          => true,
		'update_count_callback' => '',
		'rewrite'               => true,
		//'query_var'             => $taxonomy,
		'capabilities'          => array(),
		'meta_box_cb'           => null,
		'show_admin_column'     => false,
		'_builtin'              => false,
		'show_in_quick_edit'    => null,
	);
	register_taxonomy('gallery_category', array('motor_gallery'), $args );
}



function motor_product_brands_taxonomy()
{

	$labels = array(
		'name' => esc_html__('Brands', 'motor-custom-types'),
		'singular_name' => esc_html__('Brand', 'motor-custom-types'),
		'menu_name' => esc_html__('Brands', 'motor-custom-types'),
		'add_new' => esc_html__('Add New Brand', 'motor-custom-types'),
		'add_new_item' => esc_html__('Add New Brand', 'motor-custom-types'),
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => null,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'hierarchical' => true,
		'update_count_callback' => '',
		'rewrite' => true,
		'query_var' => true,
		'capabilities' => array(),
		'meta_box_cb' => null,
		'show_admin_column' => false,
		'_builtin' => false,
		'show_in_quick_edit' => null,
	);
	register_taxonomy('product_brands', array('product'), $args);
}

add_action('init', 'motor_product_brands_taxonomy');

// New Image Field to Brands Taxonomy
function motor_brands_fields($tag)
{
	//check for existing taxonomy meta for term ID
	if (!empty($tag->term_id)) {
	    $t_id = $tag->term_id;
	    $term_brands_meta = get_option( "taxonomy_brands_$t_id");
    }
	?>
	<tr class="form-field">
	<th scope="row" valign="top"><label for="term_brands_meta[img]"><?php esc_html_e('Brand Image'); ?></label></th>
		<td class="brands-field">
			<input name="term_brands_meta[img]" type="hidden" class="brands-upload-img" value="<?php if (!empty($term_brands_meta['img'])) echo $term_brands_meta['img']; ?>">
			<div class="brands-field-img">
				<?php if (!empty($term_brands_meta['img'])) : ?>
				<img src="<?php echo $term_brands_meta['img']; ?>" width="48" alt="">
				<?php endif; ?>
			</div>
			<input class="button brands-field-upload-btn" type="button" value="<?php esc_html_e('Choose Image', 'motor-custom-types'); ?>">
			<br><a href="#" class="brands-field-remove-btn"<?php if (empty($term_brands_meta['img'])) : ?> style="display: none;"<?php endif; ?>><?php esc_html_e('Remove Image', 'motor-custom-types'); ?></a><br>
		</td>
	</tr>
	<?php
}
add_action( 'product_brands_add_form_fields', 'motor_brands_fields', 10, 2);
add_action( 'product_brands_edit_form_fields', 'motor_brands_fields', 10, 2);


function save_motor_brands_fields($term_id)
{
    if ( isset( $_POST['term_brands_meta'] ) ) {
        $t_id = $term_id;
        $term_brands_meta = get_option( "taxonomy_brands_$t_id");
        $cat_keys = array_keys($_POST['term_brands_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_brands_meta'][$key])){
                $term_brands_meta[$key] = $_POST['term_brands_meta'][$key];
            }
        }
        //save the option array
        update_option( "taxonomy_brands_$t_id", $term_brands_meta );
    }
}
add_action( 'edited_product_brands', 'save_motor_brands_fields', 10, 2);
add_action('created_product_brands','save_motor_brands_fields', 10, 2);




function motor_product_badges_taxonomy()
{

	$labels = array(
		'name' => esc_html__('Badges', 'motor-custom-types'),
		'singular_name' => esc_html__('Badge', 'motor-custom-types'),
		'menu_name' => esc_html__('Badges', 'motor-custom-types'),
		'add_new' => esc_html__('Add New Badge', 'motor-custom-types'),
		'add_new_item' => esc_html__('Add New Badge', 'motor-custom-types'),
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => null,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'hierarchical' => true,
		'update_count_callback' => '',
		'rewrite' => true,
		'query_var' => true,
		'capabilities' => array(),
		'meta_box_cb' => null,
		'show_admin_column' => false,
		'_builtin' => false,
		'show_in_quick_edit' => null,
	);
	register_taxonomy('product_badges', array('product'), $args);
}

add_action('init', 'motor_product_badges_taxonomy');

// New Text Field to Badges Taxonomy
function motor_badges_fields($tag)
{
	if (!empty($tag->term_id)) {
    	$t_id = $tag->term_id;
    	$term_badges_meta = get_option( "taxonomy_badges_$t_id");
	}
	?>
	<tr class="form-field">
	<th scope="row" valign="top"><label for="term_badges_meta[color]"><?php esc_html_e('Badge Color'); ?></label></th>
		<td class="badges-field">
			<input name="term_badges_meta[color]" type="text" value="<?php if (!empty($term_badges_meta['color'])) echo $term_badges_meta['color']; ?>">
			<br><p class="description">Hex Color Codes, e.g. #ff3100</p><br>
		</td>
	</tr>
	<?php
}
add_action( 'product_badges_add_form_fields', 'motor_badges_fields', 10, 2);
add_action( 'product_badges_edit_form_fields', 'motor_badges_fields', 10, 2);


function save_motor_badges_fields($term_id)
{
    if ( isset( $_POST['term_badges_meta'] ) ) {
        $t_id = $term_id;
        $term_badges_meta = get_option( "taxonomy_badges_$t_id");
        $cat_keys = array_keys($_POST['term_badges_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_badges_meta'][$key])){
                $term_badges_meta[$key] = $_POST['term_badges_meta'][$key];
            }
        }
        //save the option array
        update_option( "taxonomy_badges_$t_id", $term_badges_meta );
    }
}
add_action( 'edited_product_badges', 'save_motor_badges_fields', 10, 2);
add_action('created_product_badges','save_motor_badges_fields', 10, 2);




function motor_product_parts_taxonomy()
{
	$labels = array(
		'name' => esc_html__('Parts Filter', 'motor-custom-types'),
		'singular_name' => esc_html__('Parts Filter ', 'motor-custom-types'),
		'menu_name' => esc_html__('Parts Filter', 'motor-custom-types'),
		'add_new' => esc_html__('Add New Parts Filter', 'motor-custom-types'),
		'add_new_item' => esc_html__('Add New Parts Filter', 'motor-custom-types'),
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => null,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'hierarchical' => true,
		'update_count_callback' => '',
		'rewrite' => true,
		'query_var' => true,
		'capabilities' => array(),
		'meta_box_cb' => null,
		'show_admin_column' => false,
		'_builtin' => false,
		'show_in_quick_edit' => null,
	);
	register_taxonomy('product_parts', array('product'), $args);
}
add_action('init', 'motor_product_parts_taxonomy');



include('widgets/widget-calendar.php');
include('widgets/widget-featured.php');
include('widgets/widget-featured-products.php');
include('widgets/widget-brands.php');
include('widgets/widget-badges.php');
include('plugins/woocommerce-products-per-page/woocommerce-products-per-page.php');
