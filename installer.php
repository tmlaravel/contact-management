<?php
global $wpdb;
$sql = "CREATE TABLE `".$wpdb->prefix."tm_contacts` (
	`id` INT(16) NOT NULL AUTO_INCREMENT , 
	`email` VARCHAR(255) NOT NULL , 
	`first_name` VARCHAR(255) NOT NULL , 
	`last_name` VARCHAR(255) NOT NULL , 
	`phone_number` VARCHAR(255) NOT NULL , 
	`address` VARCHAR(500) NULL , 
	PRIMARY KEY (`id`)
) ENGINE = InnoDB";
$sql=$wpdb->query($sql);


?>