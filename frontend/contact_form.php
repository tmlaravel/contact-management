<style>
* {
  box-sizing: border-box;
}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #04AA6D;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
.info{color: red;}
</style>
</head>
<body>

<h2>Contact Form</h2>
<p style="color: #008100;" id="send-status"></p>
<div class="container">
    <div class="row">
      <div class="col-25">
        <label for="fname">Email</label>
      </div>
      <div class="col-75">
        <input type="text" name="userEmail" id="userEmail" placeholder="Your email..">
        <span id="userEmail-info" class="info"></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="fname">First Name</label>
      </div>
      <div class="col-75">
        <input type="text" name="userFirstName" id="userFirstName" placeholder="Your first name..">
        <span id="userFirstName-info" class="info"></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="lname">Last Name</label>
      </div>
      <div class="col-75">
        <input type="text" name="userLastName" id="userLastName" placeholder="Your last name..">
        <span id="userLastName-info" class="info">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="lname">Phone Number</label>
      </div>
      <div class="col-75">
        <input type="text" name="userPhoneNumber" id="userPhoneNumber" placeholder="Your phone number..">
        <span id="userPhoneNumber-info" class="info">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="subject">Address</label>
      </div>
      <div class="col-75">
        <textarea name="userAddress" id="userAddress" placeholder="Your address.." style="height:100px"></textarea>
      </div>
    </div>
    <div class="row">
      <input type="submit" id="sendContact" value="Submit">
    </div>
</div>

<script type="text/javascript">
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
    if(!$("#userAddress").val()) {
        $("#userAddress-info").html("(required)");
        $("#userAddress").css('background-color','#FFFFDF');
        valid = false;
    }
    return valid;
}





})
</script>