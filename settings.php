<?php
require_once "models/mysql.model.php"; 

// Global Vars
$global_conditions =  array(0=>'Good',1=>'As new',2=>'Bad',3=>'New in a Box');

$admin = 0;
if (isset($_GET['admin']) && ($_GET['admin']=='1') ){
	$admin = 1;
}

//  Checking post data for action of insert or delete
if ( isset($_POST['action']) && ($_POST['action']=='insert') ){
	if ((int)$_POST['product-id']>0){
		check_main_car_part_edit();
	} else {
		check_main_car_part_insertion();
	}	
}

check_post_purchase();	

