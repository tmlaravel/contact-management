<?php

/*
 * Plugin Name:       Tm Contact Management
 * Plugin URI:        https://example.com/plugins/contact-management/
 * Description:       Handle the basics Contact Management with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Tanmoy Mistry
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       contact-management-plugin
 * Domain Path:       /languages
 */

session_start();
class TmContact{
    
    private static $_instance = null;

    public static function instance(){
       if(!isset(self::$_instance)){
          self::$_instance = new self;
       }
       return self::$_instance;
    } 

    private function __construct(){
        session_start();
        add_action( 'wp_enqueue_scripts', array($this,'tm_product_delivery_date_assets') );
        add_action('wp_ajax_tm_send_message',array($this,'do_ajax_action'));
        add_action('wp_ajax_nopriv_tm_send_message',array($this,'do_ajax_action'));
        add_action( 'admin_menu', array( $this, 'tm_admin_menu' ) );
        add_action( 'init', array( $this,'TmContact::process_my_form' ));
    }

    public  function do_ajax_action(){
        global $wpdb;
        $email               = $_POST['email'];
        $first_name          = $_POST['first_name'];
        $last_name           = $_POST['last_name'];
        $phone_number        = $_POST['phone_number'];
        $address             = $_POST['address'];

        $sql = "INSERT INTO ".$wpdb->prefix."tm_contacts (email,first_name,last_name,phone_number,address) VALUES('$email','$first_name','$last_name','$phone_number','$address')";

        if($wpdb->query($sql)){
          echo 'Sending Message Successfully';
          die();
        }else{
          echo 'Sending Message Failed';
        }

    }

    public static function tm_installer(){
       require_once('installer.php');
    }

    public static function tm_uninstaller(){
       require_once('uninstaller.php');
    }

    public static function tm_frontend_display(){
        ob_start();
        require_once("frontend/contact_form.php");
        return ob_get_clean();
    }

    public function tm_product_delivery_date_assets() {

        wp_enqueue_script('jquery.min.js',   'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', '', true);

        wp_enqueue_script("message_script",   plugins_url() . "/contact-management/js/app.js", '');

        wp_localize_script('message_script','ajax_object',array('url'=>admin_url('admin-ajax.php')));


    }


    public  function tm_admin_menu(){
        add_menu_page(
            'Contact Management',
            'Contact Management',
            'administrator',
            'contact-management',
            array($this,'tm_contact_management_home')
            
        );
    }


    public function tm_contact_management_home(){
        global $wpdb;
        
        $start = 0;  $per_page = 10;
        $page_counter = 0;
        $next = $page_counter + 1;
        $previous = $page_counter - 1;

        if(isset($_GET['start'])){
        $start = $_GET['start'];
        $page_counter =  $_GET['start'];
        $start = $start *  $per_page;
        $next = $page_counter + 1;
        $previous = $page_counter - 1;
        }else{
        $page_counter =  0;    
        }

        $sql = "SELECT * FROM ".$wpdb->prefix."tm_contacts LIMIT $start, $per_page ";
        $result = $wpdb->get_results($sql);
        $rows = $wpdb->get_results("SELECT COUNT(*) as num_rows FROM ".$wpdb->prefix."tm_contacts"); 
        $count = $rows[0]->num_rows;
        require_once("admin_menu/home.php");
    }

    
    public function process_my_form() {
          global $wpdb;
     if(isset($_POST['mysubmitbtn'])){
          $contact_message_id = $_POST['contact_message_id'];
          $sql = "DELETE FROM ".$wpdb->prefix."tm_contacts WHERE id='$contact_message_id ' ";
          if($wpdb->query($sql)){
            $_SESSION['msg'] = 'Contact Data Delete Succesfully';
          }else{
            $_SESSION['msg'] = 'Contact Data Delete Failed';
          }
     }
    }

 

}


add_action("plugins_loaded", "TmContact::instance");
register_activation_hook(__FILE__,'TmContact::tm_installer');
register_uninstall_hook(__FILE__,'TmContact::tm_uninstaller');
add_shortcode('tm_con_man','TmContact::tm_frontend_display');
?>