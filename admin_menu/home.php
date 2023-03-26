<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>
</head>
<body>

<div>short code : [tm_con_man]</div>
<div>Use this short code for contact management form (front-end)</div>

<h1 style="text-align:center;text-decoration: underline;">Contact management</h1>

<h2 style="color:428d1c;">Contact List</h2>

<p style="color:green"><?php if(isset($_SESSION['msg'])){echo $_SESSION['msg'];} unset($_SESSION['msg']);?></p>

<?php 
if($count>0){
?>
<div style="overflow-x:auto;">
  <table>
    <tr>
      <th>#</th>
      <th>Email</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Phone Number</th>
      <th>Address</th>
      <th></th>
    </tr>

<?php
$a=0; 
foreach($result AS $val){ 
$a++;	
?>
    <tr>
      <td><?php echo $a; ?></td>
      <td><?php echo $val->email; ?></td>
      <td><?php echo $val->first_name; ?></td>
      <td><?php echo $val->last_name; ?></td>
      <td><?php echo $val->phone_number; ?></td>
      <td><?php echo $val->address; ?></td>
      <td>
        <form method="post" action="" onsubmit="return confirm('Do you really want to delete?');">
          <input type="hidden" name="contact_message_id" value="<?php echo $val->id; ?>">
        <input 
        style="background-color: red;
        color: #fff;
        border-color: #ff0202;" 
        type="submit" name="mysubmitbtn" value="Delete" 
        />
        </form>
      </td>
    </tr>
<?php 
}
?>
  </table>

<?php
$paginations = ceil($count / $per_page); 
$different = $paginations - $_GET['start'];
?>

<center>
            <ul class="pagination">
            <?php
               if($paginations==1){

               }else if($page_counter == 0){
                  echo "<li><a href=?page=contact-management&start=$next>Next</a></li>"; 
                }else{
                    echo "<li><a href=?page=contact-management&start=$previous>Previous</a></li>"; 
                  if($j != $page_counter+1 && $different!=1)
                    echo "<li><a href=?page=contact-management&start=$next>Next</a></li>"; 
                } 
            ?>
            </ul>
            </center> 

	
</div>
<?php
}
else{echo "No Contact Found.......";}
?>