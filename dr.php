    public function tm_product_delivery_date_assets() {

        wp_enqueue_style( 'slider', plugins_url() . '/css/slider.css', false, '1.1', 'all');
        
        wp_enqueue_script('jquery.min.js',   'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', '', true);

        wp_enqueue_script("message_script",   plugins_url() . "/contact-management/js/app.js", '','',true);

        wp_localize_script('message_script','ajax_object',array('url'=>admin_url('admin-ajax.php')));


    }
