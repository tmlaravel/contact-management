<?php
/**
 * Template Name: Success
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header();
$results =null;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once(get_template_directory() . '/mail/src/Exception.php');
require_once(get_template_directory() . '/mail/src/PHPMailer.php');
require_once(get_template_directory() . '/mail/src/SMTP.php');
if(isset($_GET['session_id']) && !empty($_GET['session_id'])){
    $session_id = $_GET['session_id'];
    
    global $wpdb;
	$tablename=$wpdb->prefix.'customers';
	$data=array(
		'status' =>1, 
	);
	$data2=array(
		'payment_seassion_id' =>$session_id, 
	);
	
	$wpdb->update( $tablename, $data, $data2);   
	
	$results = $wpdb->get_results( "SELECT * FROM {$tablename} WHERE payment_seassion_id = '{$session_id}'" );
	
    if(isset($_SESSION['usermeta']) && !empty($_SESSION['usermeta'])) {
        $fullInfo = $_SESSION['usermeta'];
        $mail = new PHPMailer(true);   
        $mail->isSMTP();                                     
        $mail->Host = 'smtp.office365.com';                      
        $mail->SMTPAuth = true;    
        $mail->AuthType = 'PLAIN';
        $mail->Username = 'support@uflex.ca';     
        $mail->Password = 'Welcome20@';
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );                         
        $mail->SMTPSecure = 'tls';                           
        $mail->Port = 587;                                   
        $mail->setFrom('support@uflex.ca', 'uflex');
        $mail->addAddress('uflex.ca@gmail.com');
        $mail->addAddress('support@uflex.ca');
        $mail->isHTML(true);                                  
        $mail->Subject = 'Uflex - New Order';
    
        $type = $fullInfo['type'];
         if($type == 'delivery'){
             if($fullInfo['image']){
              $message = '<h3>New Order</h3>
            <p>Name: '.$fullInfo['fname'] .' '.$fullInfo['lname'] .'</p>
            <p>Email: '.$fullInfo['email'].'</p>
            <p>From Address: '.$fullInfo['from_address'].'</p>
            <p>To Address: '.$fullInfo['to_address'].'</p>
            <p>Phone: '.$fullInfo['p_phone'].'</p>
            <p>Date: '.$fullInfo['d_date'].'</p>
            <p>Message: '.$fullInfo['m_message'].'</p>
            <p>Itemtype: '.$fullInfo['itemtypez'].'</p>
            <p>Distance: '.$fullInfo['d_distance'].'</p>
            <p>Number of stairs: '.$fullInfo['number_of_stairs'].'</p>
            <p>Heavy Items: '.$fullInfo['heavy_items'].'</p>
            <p>Car Type: '.$fullInfo['car_type'].'</p>
            <p>No. of helpers: '.$fullInfo['no_of_helpers'].'</p>
            <p>amount: CA$'.$fullInfo['amount'].'</p>
            <p>type: '.$fullInfo['type'].'</p>
            <p>Image: <br/><img src="'.$fullInfo['image'].'" /></p>';   
             }else{
                 $message = '<h3>New Order</h3>
            <p>Name: '.$fullInfo['fname'] .' '.$fullInfo['lname'] .'</p>
            <p>Email: '.$fullInfo['email'].'</p>
            <p>From Address: '.$fullInfo['from_address'].'</p>
            <p>To Address: '.$fullInfo['to_address'].'</p>
            <p>Phone: '.$fullInfo['p_phone'].'</p>
            <p>Date: '.$fullInfo['d_date'].'</p>
            <p>Message: '.$fullInfo['m_message'].'</p>
            <p>Itemtype: '.$fullInfo['itemtypez'].'</p>
            <p>Distance: '.$fullInfo['d_distance'].'</p>
            <p>Number of stairs: '.$fullInfo['number_of_stairs'].'</p>
            <p>Heavy Items: '.$fullInfo['heavy_items'].'</p>
            <p>Car Type: '.$fullInfo['car_type'].'</p>
            <p>No. of helpers: '.$fullInfo['no_of_helpers'].'</p>
            <p>amount: CA$'.$fullInfo['amount'].'</p>
            <p>type: '.$fullInfo['type'].'</p>';
             }
         }else if($type == 'moving'){
             $message = '<h3>New Order</h3>
            <p>Name: '.$fullInfo['fname'] .' '.$fullInfo['lname'] .'</p>
            <p>Email: '.$fullInfo['email'].'</p>
            <p>From Address: '.$fullInfo['from_address'].'</p>
            <p>To Address: '.$fullInfo['to_address'].'</p>
            <p>Phone: '.$fullInfo['p_phone'].'</p>
            <p>Date: '.$fullInfo['d_date'].'</p>
            <p>Message: '.$fullInfo['m_message'].'</p>
            <p>Moving Type: '.$fullInfo['moving_type'].'</p>
            <p>Distance: '.$fullInfo['d_distance'].'</p>
            <p>Number of stairs: '.$fullInfo['number_of_stairs'].'</p>
            <p>Large Item: '.$fullInfo['large_item'].'</p>
            <p>Car Type: '.$fullInfo['car_type'].'</p>
            <p>No. of helpers: '.$fullInfo['no_of_helpers'].'</p>
            <p>amount: CA$'.$fullInfo['amount'].'</p>
            <p>type: '.$fullInfo['type'].'</p>';
         }else{
             $message = '<h3>New Order</h3>
            <p>Name: '.$fullInfo['fname'] .' '.$fullInfo['lname'] .'</p>
            <p>Email: '.$fullInfo['email'].'</p>
            <p>From Address: '.$fullInfo['from_address'].'</p>
            <p>To Address: '.$fullInfo['to_address'].'</p>
            <p>Phone: '.$fullInfo['p_phone'].'</p>
            <p>Date: '.$fullInfo['d_date'].'</p>
            <p>Message: '.$fullInfo['m_message'].'</p>
            <p>Distance: '.$fullInfo['d_distance'].'</p>
            <p>amount: CA$'.$fullInfo['amount'].'</p>';
         }
        $mail->Body    = $message;
        $mail->send();
        unset($_SESSION['usermeta']);
    }

}



?>
<main id="content" class="site-main" role="main">
	<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
		<!--<header class="page-header">-->
		<!--	<h1 class="entry-title" style="color: white;text-align: center;padding: 10%;">Payment was successfully processed</h1>-->
		<!--</header>-->
	<?php endif; ?>
	<div class="page-content">
		<!-- <p><?php //esc_html_e( 'It looks like nothing was found at this location.', 'hello-elementor' ); ?></p> -->
		<?php if($results && $results[0]){ ?>
		<div style="color: white;text-align: center;padding: 3%;">
    		<h1 class="entry-title">Payment successfully processed</h1>
    		<h2>Thank you for your payment. We will be in contact with more details shortly.</h2>
		</div>
        <?php } ?>
		
	</div>

</main>
<?php get_footer(); ?>
