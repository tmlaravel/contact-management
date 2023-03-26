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