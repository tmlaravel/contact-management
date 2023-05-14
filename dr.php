    public function tm_product_delivery_date_assets() {

        wp_enqueue_style( 'slider', plugins_url() . '/css/slider.css', false, '1.1', 'all');
        
        wp_enqueue_script('jquery.min.js',   'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', '', true);

        wp_enqueue_script("message_script",   plugins_url() . "/contact-management/js/app.js", '','',true);

        wp_localize_script('message_script','ajax_object',array('url'=>admin_url('admin-ajax.php')));


    }

jQuery(function($){

   $('#sendContact').on('click',function(){

    var valid;  
    valid = validateContact();
    if(valid) {

        let email = $('#userEmail').val();
        let first_name = $('#userFirstName').val();
        let last_name = $('#userLastName').val();
        let phone_number = $('#userPhoneNumber').val();
        let address = $('#userAddress').val();
        jQuery.ajax({
            url: ajax_object.url,
            data: {action:'tm_send_message',email:email,first_name:first_name,last_name:last_name,phone_number:phone_number,address:address},
            type: "POST",
            success:function(data){
                $("#send-status").html(data);
                $('#userEmail').val('');
                $('#userFirstName').val('');
                $('#userLastName').val('');
                $('#userPhoneNumber').val('');
                $('#userAddress').val('');
            },
            error:function (){}
        });
    }



   })


function validateContact() {
    var valid = true;   
    $(".demoInputBox").css('background-color','');
    $(".info").html('');
    if(!$("#userEmail").val()) {
        $("#userEmail-info").html("(required)");
        $("#userEmail").css('background-color','#FFFFDF');
        valid = false;
    }
    if(!$("#userEmail").val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
        $("#userEmail-info").html("(invalid)");
        $("#userEmail").css('background-color','#FFFFDF');
        valid = false;
    }
    if(!$("#userFirstName").val()) {
        $("#userFirstName-info").html("(required)");
        $("#userFirstName").css('background-color','#FFFFDF');
        valid = false;
    }
    if(!$("#userLastName").val()) {
        $("#userLastName-info").html("(required)");
        $("#userLastName").css('background-color','#FFFFDF');
        valid = false;
    }
    if(!$("#userPhoneNumber").val()) {
        $("#userPhoneNumber-info").html("(required)");
        $("#userPhoneNumber").css('background-color','#FFFFDF');
        valid = false;
    }
    if(!$("#userPhoneNumber").val().match('^[0-9]+$')) {
        $("#userPhoneNumber-info").html("(invalid)");
        $("#userPhoneNumber").css('background-color','#FFFFDF');
        valid = false;
    }
    return valid;
}





})
