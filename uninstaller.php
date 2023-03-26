<?php
global $wpdb;
$sql = "DROP TABLE `".$wpdb->prefix."tm_contacts`";
$sql=$wpdb->query($sql);


?>