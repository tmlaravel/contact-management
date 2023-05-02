<?php
//contact us ajax request

function get_data() {
    session_start();
    $uploadfile = null;
    require_once(get_template_directory() . '/stripe-php-master/init.php');
    
    // $secret_key = 'sk_test_mRtDnWuiOp2IRQSVvjwUDWIh';
    $secret_key = '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';
    \Stripe\Stripe::setApiKey($secret_key);
    
    $amount = intval($_POST['amount']*100);
    $email = $_POST['e_email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $from_address = $_POST['from_address'];
    $to_address = $_POST['to_address'];
    $p_phone = $_POST['p_phone'];
    $d_date = $_POST['d_date'];
    $m_message = $_POST['m_message'];
    $type = $_POST['type'];
    $meta = [];
    if($type == 'delivery'){
        
        if(isset($_FILES['image_up']) && $_FILES["image_up"]["name"]){
            $uploadfile = wp_upload_bits($_FILES["image_up"]["name"], null, file_get_contents($_FILES["image_up"]["tmp_name"]));
        }else{
            $uploadfile = null;
        }
        
        $itemtypez = $_POST['itemtypez'];
        $d_distance = $_POST['d_distance'];
        $number_of_stairs = $_POST['number_of_stairs'];
        $heavy_items = $_POST['heavy_items'];
        $car_type = $_POST['car_type'];
        $no_of_helpers = $_POST['no_of_helpers'];
        
		if($itemtypez == '2.6' || $itemtypez == 2.6){
			$itemtypez = 'Grocery';
		}else if($itemtypez == '2.8' || $itemtypez == 2.8){
			$itemtypez = 'Electronics';
		}else if($itemtypez == '3.6' || $itemtypez == 3.6){
			$itemtypez = 'Furniture';
		}else if($itemtypez == '4.6' || $itemtypez == 4.6){
			$itemtypez = 'Automotive';
		}else if($itemtypez == '4.8' || $itemtypez == 4.8){
			$itemtypez = 'Appliances';
		}else if($itemtypez == '7.5' || $itemtypez == 7.5){
			$itemtypez = 'Building Materials';
		}

        $meta = [
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'from_address' => $from_address,
            'to_address' => $to_address,
            'p_phone' => $p_phone,
            'd_date' => $d_date,
            'm_message' => $m_message,
            'itemtypez' => $itemtypez,
            'd_distance' => $d_distance,
            'number_of_stairs' => $number_of_stairs,
            'heavy_items' => $heavy_items,
            'car_type' => $car_type,
            'no_of_helpers' => $no_of_helpers,
            'amount'=> $_POST['amount'],
            'type' => 'delivery',
            'image' => $uploadfile== null ? null : $uploadfile['url']
        ];
        
    }else if($type == 'moving'){
        $moving_type = $_POST['moving_type'];
        $d_distance = $_POST['d_distance'];
        $number_of_stairs = $_POST['number_of_stairs'];
        $large_item = $_POST['large_item'];
        $car_type = $_POST['car_type'];
        $no_of_helpers = $_POST['no_of_helpers'];
        
		if($moving_type == 240){
			$moving_type = 'Studio';
		}else if($moving_type == 260){
			$moving_type = '1 Bedroom Apt';
		}else if($moving_type == 360){
			$moving_type = '1 Bedroom House';
		}else if($moving_type == 360){
			$moving_type = '2 Bedroom Apt';
		}else if($moving_type == 460){
			$moving_type = '2 Bedroom House';
		}else if($moving_type == 460){
			$moving_type = '3 Bedroom Apt';
		}else if($moving_type == 560){
			$moving_type = '3 Bedroom House';
		}else if($moving_type == 560){
			$moving_type = '4 Bedroom Apt';
		}else if($moving_type == 660){
			$moving_type = '4 Bedroom House';
		}

        $meta = [
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'from_address' => $from_address,
            'to_address' => $to_address,
            'p_phone' => $p_phone,
            'd_date' => $d_date,
            'm_message' => $m_message,
            'moving_type' => $moving_type,
            'd_distance' => $d_distance,
            'number_of_stairs' => $number_of_stairs,
            'large_item' => $large_item,
            'car_type' => $car_type,
            'no_of_helpers' => $no_of_helpers,
            'amount'=> $_POST['amount'],
            'type' => 'moving'
        ];
    }
    
    
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
          'price_data' => [
            'currency' => 'CAD',
            'product_data' => [
              'name' => $fname . ' '. $lname
            ],
            'unit_amount' => $amount,
          ],
          'quantity' => 1,
        ]],
        'customer_email' => $email,
        'mode' => 'payment',
        'success_url' => 'https://uflex.ca/success?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'https://uflex.ca/cancel',
      ]);

    
    $_SESSION["usermeta"] = $meta;
    $result['status'] = "success";
    $result['url'] = $session['url'];
    
    $result = json_encode($result);
    echo $result;
    
    
       //insert the payment 
	global $wpdb;
	$tablename=$wpdb->prefix.'customers';
	if($type == 'delivery'){
		$data=array(
			'name' => $fname . ' '.  $lname,
			'cemail' => $email,
			'phone' => $p_phone, 
			'price' => $_POST['amount'], 
			'lto' => $to_address,
			'lfrom' => $from_address,
			'd_date' => $d_date,
			'm_message' => $m_message,
			'item_or_moving_type' =>$itemtypez,
			'd_distance' => $d_distance,
			'number_of_stairs' =>$number_of_stairs,
			'heavy_or_large_item' =>$heavy_items,
			'car_type' =>$car_type,
			'no_of_helpers' =>$no_of_helpers,
			'image_link' => $uploadfile== null ? null : $uploadfile['url'],
			'mode_type'=> 'delivery',
			'payment_id' => $session['payment_intent'],
			'payment_seassion_id' => $session['id'],
			'status' =>'0', 
			
		);
	}else if($type == 'moving'){
		$data=array(
			'name' => $fname . ' '.  $lname,
			'cemail' => $email,
			'phone' => $p_phone, 
			'price' => $_POST['amount'], 
			'lto' => $to_address,
			'lfrom' => $from_address,
			'd_date' => $d_date,
			'm_message' => $m_message,
			'item_or_moving_type' =>$moving_type,
			'd_distance' => $d_distance,
			'number_of_stairs' =>$number_of_stairs,
			'heavy_or_large_item' =>$large_item,
			'car_type' =>$car_type,
			'no_of_helpers' =>$no_of_helpers,
			'mode_type'=> 'moving',
			'payment_id' => $session['payment_intent'],
			'payment_seassion_id' => $session['id'],
			'status' =>'0', 
			
		);
	}else{
		$data=array(
			'name' => $fname . ' '.  $lname,
			'cemail' => $email,
			'phone' => $p_phone, 
			'price' => $_POST['amount'], 
			'lto' => $to_address,
			'lfrom' => $from_address,
			'payment_id' => $session['payment_intent'],
			'payment_seassion_id' => $session['id'],
			'status' =>'0'
		);
	}
	
	if($session['payment_intent']){
	 $wpdb->insert( $tablename, $data);   
	}
	
	//insert the payment 

	wp_die();  //die();
}

add_action( 'wp_ajax_nopriv_get_data', 'get_data' );
add_action( 'wp_ajax_get_data', 'get_data' );
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '2.6.1' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_load_textdomain', [ true ], '2.0', 'hello_elementor_load_textdomain' );
		if ( apply_filters( 'hello_elementor_load_textdomain', $hook_result ) ) {
			load_theme_textdomain( 'hello-elementor', get_template_directory() . '/languages' );
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_menus', [ true ], '2.0', 'hello_elementor_register_menus' );
		if ( apply_filters( 'hello_elementor_register_menus', $hook_result ) ) {
			register_nav_menus( [ 'menu-1' => __( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => __( 'Footer', 'hello-elementor' ) ] );
		}

		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_theme_support', [ true ], '2.0', 'hello_elementor_add_theme_support' );
		if ( apply_filters( 'hello_elementor_add_theme_support', $hook_result ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style( 'classic-editor.css' );

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support( 'align-wide' );

			/*
			 * WooCommerce.
			 */
			$hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_woocommerce_support', [ true ], '2.0', 'hello_elementor_add_woocommerce_support' );
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', $hook_result ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$enqueue_basic_style = apply_filters_deprecated( 'elementor_hello_theme_enqueue_style', [ true ], '2.0', 'hello_elementor_enqueue_style' );
		$min_suffix          = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'hello_elementor_enqueue_style', $enqueue_basic_style ) ) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		$hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_elementor_locations', [ true ], '2.0', 'hello_elementor_register_elementor_locations' );
		if ( apply_filters( 'hello_elementor_register_elementor_locations', $hook_result ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

/**
 * If Elementor is installed and active, we can load the Elementor-specific Settings & Features
*/

// Allow active/inactive via the Experiments
require get_template_directory() . '/includes/elementor-functions.php';

/**
 * Include customizer registration functions
*/
function hello_register_customizer_functions() {
	if ( is_customize_preview() ) {
		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_register_customizer_functions' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check hide title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * Wrapper function to deal with backwards compatibility.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		} else {
			do_action( 'wp_body_open' );
		}
	}
}






add_filter( 'comment_form_defaults', function( $fields ) {
    $fields['must_log_in'] = sprintf( 
        __( '<p class="must-log-in">
                 You must <a class="xoo-el-reg-tgr">Register</a> or 
                 <a class="xoo-el-login-tgr">Login</a> to post a comment.</p>' 
        ),
        wp_registration_url(),
        wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )   
    );
    return $fields;
});
add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );