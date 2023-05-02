<?php
/**
 * The template for displaying the footer.
 *
 * Contains the body & html closing tags.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	if ( did_action( 'elementor/loaded' ) && hello_header_footer_experiment_active() ) {
		get_template_part( 'template-parts/dynamic-footer' );
	} else {
		get_template_part( 'template-parts/footer' );
	}
}
?>

<?php wp_footer(); ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC73KxP5MH62GTt_hKopQZlYPGWxoloscM&libraries=places"></script>

<script>
    var current_position = {};
    var image_up=null;
    function haversine_distance(place1_lat, place1_lng, place2_lat, place2_lng) {
      var R = 6371.0710;
      var rlat1 = place1_lat * (Math.PI/180);
      var rlat2 = place2_lat * (Math.PI/180);
      var difflat = rlat2-rlat1; // Radian difference (latitudes)
      var difflon = (place2_lng-place1_lng) * (Math.PI/180);

      var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
      return d.toFixed(2);
    }
    
    $( document ).ready(function() {
      
        $( "#next-btn" ).click(function() {
            var fname = $("#fname").find('input');
            var lname = $("#lname").find('input');
            var from_address = $("#from_address").find('input');
            var to_address = $("#to_address").find('input');
            var e_email = $("#e_email").find('input');
            var p_phone = $("#p_phone").find('input');
            var d_date = $("#d_date").find('input');
            var m_message = $("#m_message").find('textarea');
			var distance = $('#d-distance-input');
            
            var data = {
                fname : fname.val(), 
                lname : lname.val(), 
                from_address : from_address.val(), 
                to_address : to_address.val(), 
                e_email : e_email.val(), 
                p_phone : p_phone.val(), 
                d_date : d_date.val(), 
                m_message: m_message.val(),
				distance: distance.val()
            };
			localStorage.setItem("moving",  '');
            localStorage.setItem("moving",  data.distance);
            //console.log( "moving data1", data );
            
            var fname = $("#f_name").find('input');
            var lname = $("#l_name").find('input');
            var from_address = $("#from__address").find('input');
            var to_address = $("#to__address").find('input');
            var e_email = $("#e__email").find('input');
            var p_phone = $("#p__phone").find('input');
            var d_date = $("#d__date").find('input');
            var m_message = $("#m__message").find('textarea');
			var distance = $('#d-distance-input2');
            
            var data2 = {
                fname : fname.val(), 
                lname : lname.val(), 
                from_address : from_address.val(), 
                to_address : to_address.val(), 
                e_email : e_email.val(), 
                p_phone : p_phone.val(), 
                d_date : d_date.val(), 
                m_message: m_message.val(),
				distance: distance.val()
            };
			localStorage.setItem("delivery",  '');
            localStorage.setItem("delivery", data2.distance);
            //console.log( "delivery data1", data );
        });
        
        $("#quote-form-submit-btn").click(function(e) {
            var fname = $("#fname").find('input');
            var lname = $("#lname").find('input');
            var from_address = $("#from_address").find('input');
            var to_address = $("#to_address").find('input');
            var e_email = $("#e_email").find('input');
            var p_phone = $("#p_phone").find('input');
            var d_date = $("#d_date").find('input');
            var m_message = $("#m_message").find('textarea');
            var moving_type = $('#moving_type').find(":selected");
            // var d_distance = $('#d_distance').find('input');
            var d_distance = $('#d-distance-input');
            var number_of_stairs = $('#number_of_stairs').find(":selected");
            var large_item = $('#large_item').find(":selected");
            var car_type = $('#cartype .vehicalLabel input[name="radioz"]:checked').val();
            var no_of_helpers = $("#no_of_helpers").find('select').find(":selected");
            
            var data = {
                action:'get_data',
                fname : fname.val(), 
                lname : lname.val(), 
                from_address : from_address.val(), 
                to_address : to_address.val(), 
                e_email : e_email.val(), 
                p_phone : p_phone.val(), 
                d_date : d_date.val(), 
                m_message: m_message.val(),
                moving_type : moving_type.val(),
                d_distance : d_distance.val(),
                number_of_stairs: number_of_stairs.val(),
                large_item: large_item.val(),
                car_type,
                no_of_helpers: no_of_helpers.val(),
                // amount: $('#quote_form .price_box').text().replace('$',''),
                amount: $('#quote_form .final_total_price').text().replace('CA$',''),
                type: 'moving'
                
            };
            
            //console.log( "moving all data", data );
            
            if(data.amount > 0){
                // console.log($('#quote_form .price_box').text().replace('$',''));
                
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: "/wp-admin/admin-ajax.php", //this is wordpress ajax file which is already avaiable in wordpress
                    data: data,
                    success: function(success){
                        if(success.status == 'success' && success.url){
                            window.location.href = success.url;
                        }
                        
                    },
                    error: function(err){
                        console.log("err", err);
                    }
                });
            }
            e.preventDefault();
        });
        
        $("#image_file_up").on('change',function(e) {
            var property = e.target.files[0];
            var image_name = property.name;
            var image_extension = image_name.split('.').pop().toLowerCase();
            if($.inArray(image_extension,['jpg','jpeg','png']) == -1){
                image_up = null;
                alert("Uploaded file is not a valid image. Only JPG, PNG and JPEG files are allowed.");
            }else{
                image_up = property;
            }
        });
        
        $("#delivery-form-submit-btn").click(function(e) {
            var fname = $("#f_name").find('input');
            var lname = $("#l_name").find('input');
            var from_address = $("#from__address").find('input');
            var to_address = $("#to__address").find('input');
            var e_email = $("#e__email").find('input');
            var p_phone = $("#p__phone").find('input');
            var d_date = $("#d__date").find('input');
            var m_message = $("#m__message").find('textarea');
            var itemtypez = $('#itemtypez').find(":selected");
            // var d_distance = $('#d__distance').find('input');
            var d_distance = $('#d-distance-input2');
            var number_of_stairs = $('#number__of__stairs').find(":selected");
            var heavy_items = $('#heavy_items').find(":selected");
            var car_type = $('#cartype_delivery .vehicalLabel input[name="radioz"]:checked').val();
            var no_of_helpers = $("#no__of__helpers").find('select').find(":selected");
            
            var data1 = {
                action:'get_data',
                fname : fname.val(), 
                lname : lname.val(), 
                from_address : from_address.val(), 
                to_address : to_address.val(), 
                e_email : e_email.val(), 
                p_phone : p_phone.val(), 
                d_date : d_date.val(), 
                m_message: m_message.val(),
                itemtypez : itemtypez.val(),
                d_distance : d_distance.val(),
                number_of_stairs: number_of_stairs.val(),
                heavy_items: heavy_items.val(),
                car_type,
                image_up: image_up,
                no_of_helpers: no_of_helpers.val(),
                // amount: $('#totaldelivery').val(),
                amount: $('#wrap-1 .final_total_price').text().replace('CA$',''),
                type: 'delivery'
            };
            
            var data = new FormData();
            data.append("action",'get_data');
            data.append("fname",fname.val());
            data.append("lname",lname.val());
            data.append("from_address",from_address.val());
            data.append("to_address",to_address.val());
            data.append("e_email",e_email.val());
            data.append("p_phone",p_phone.val());
            data.append("d_date",d_date.val());
            data.append("m_message",m_message.val());
            data.append("itemtypez",itemtypez.val());
            data.append("d_distance",d_distance.val());
            data.append("number_of_stairs",number_of_stairs.val());
            data.append("heavy_items",heavy_items.val());
            data.append("car_type",car_type);
            data.append("image_up",image_up);
            data.append("no_of_helpers",no_of_helpers.val());
            data.append("amount",$('#wrap-1 .final_total_price').text().replace('CA$',''));
            data.append("type",'delivery');
            
            
            //console.log( "delivery all data", data );
            
            if(data1.amount > 0){
                
                $.ajax({
                    type: "post",
                    // dataType: "json",
                    contentType: false,
                    processData: false,
                    url: "/wp-admin/admin-ajax.php", //this is wordpress ajax file which is already avaiable in wordpress
                    data: data,
                    success: function(success){
                        success = JSON.parse(success);
                        if(success.status == 'success' && success.url){
                            window.location.href = success.url;
                        }
                        
                    },
                    error: function(err){
                        console.log("err", err);
                    }
                });
            }
            e.preventDefault();
        });
        
        
        var input = document.getElementById('from-input');
        var autocomplete_a = new google.maps.places.Autocomplete(input,{types: ['geocode']});
        var to_input = document.getElementById('to-input');
        var autocomplete_b = new google.maps.places.Autocomplete(to_input,{types: ['geocode']});
        var input2 = document.getElementById('from-input2');
        var autocomplete_c = new google.maps.places.Autocomplete(input2,{types: ['geocode']});
        var to_input2 = document.getElementById('to-input2');
        var autocomplete_d = new google.maps.places.Autocomplete(to_input2,{types: ['geocode']});


        google.maps.event.addListener(autocomplete_a, 'place_changed', function(){
            var place_a = autocomplete_a.getPlace();
            var place_b = autocomplete_b.getPlace();
            if(place_a && place_b && place_a.geometry.location.lat() && place_b.geometry.location.lat()){
                var dis = haversine_distance(place_a.geometry.location.lat(), place_a.geometry.location.lng(), place_b.geometry.location.lat(), place_b.geometry.location.lng());
                $('#d-distance-input').val(dis);
                $("#d-distance-input").prop('disabled', true);
            }
        });
        
        google.maps.event.addListener(autocomplete_b, 'place_changed', function(){
            var place_a = autocomplete_a.getPlace();
            var place_b = autocomplete_b.getPlace();
            if(place_a && place_b && place_a.geometry.location.lat() && place_b.geometry.location.lat()){
                var dis = haversine_distance(place_a.geometry.location.lat(), place_a.geometry.location.lng(), place_b.geometry.location.lat(), place_b.geometry.location.lng());
                $('#d-distance-input').val(dis);
                $("#d-distance-input").prop('disabled', true);
            }else if(place_b && place_b.geometry.location.lat() && current_position.lat && current_position.lng){
                var dis = haversine_distance(current_position.lat, current_position.lng, place_b.geometry.location.lat(), place_b.geometry.location.lng());
                $('#d-distance-input').val(dis);
                $("#d-distance-input").prop('disabled', true);
            }
        });
        
        google.maps.event.addListener(autocomplete_c, 'place_changed', function(){
            var place_c = autocomplete_c.getPlace();
            var place_d = autocomplete_d.getPlace();
            if(place_c && place_d && place_c.geometry.location.lat() && place_d.geometry.location.lat()){
                var dis = haversine_distance(place_c.geometry.location.lat(), place_c.geometry.location.lng(), place_d.geometry.location.lat(), place_d.geometry.location.lng());
                $('#d-distance-input2').val(dis);
                $("#d-distance-input2").prop('disabled', true);
            }
        });
        
        google.maps.event.addListener(autocomplete_d, 'place_changed', function(){
            var place_c = autocomplete_c.getPlace();
            var place_d = autocomplete_d.getPlace();
            if(place_c && place_d && place_c.geometry.location.lat() && place_d.geometry.location.lat()){
                var dis = haversine_distance(place_c.geometry.location.lat(), place_c.geometry.location.lng(), place_d.geometry.location.lat(), place_d.geometry.location.lng());
                $('#d-distance-input2').val(dis);
                $("#d-distance-input2").prop('disabled', true);
            }else if(place_d && place_d.geometry.location.lat() && current_position.lat && current_position.lng){
                var dis = haversine_distance(current_position.lat, current_position.lng, place_d.geometry.location.lat(), place_d.geometry.location.lng());
                $('#d-distance-input2').val(dis);
                $("#d-distance-input2").prop('disabled', true);
            }
        });
        

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
            (position) => {
            //   console.log(position);
              current_position = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
              };
              
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var google_map_pos = new google.maps.LatLng( lat, lng );
 
                /* Use Geocoder to get address */
                var google_maps_geocoder = new google.maps.Geocoder();
                google_maps_geocoder.geocode(
                    { 'latLng': google_map_pos },
                    function( results, status ) {
                        if ( status == google.maps.GeocoderStatus.OK && results[0] ) {
                            // console.log(results[0]);
                            // console.log( results[0].formatted_address );
                            document.getElementById('from-input').value = results[0].formatted_address;
                            document.getElementById('from-input2').value = results[0].formatted_address;
                        }
                    }
                );
        
            },
            (err) => {
              console.log(err);
            }
          );
        } else {
          // Browser doesn't support Geolocation
          console.log("Browser doesn't support Geolocation");
        }

    });
</script>

</body>
</html>
