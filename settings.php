<?php
require_once "models/mysql.model.php"; 

// Global Vars
$global_conditions =  array(0=>'Good',1=>'As new',2=>'Bad',3=>'New in a Box');

$admin = 0;

//  Checking post data for action of insert or delete
if ( isset($_POST['action']) && ($_POST['action']=='insert') ){
	if ((int)$_POST['product-id']>0){
		check_main_car_part_edit();
	} else {
		check_main_car_part_insertion();
	}	
}

check_post_purchase();



function get_page(){

	$valid_pages = array('best-sales','sales','cars','admin');

	if (!isset($_GET['page'])) {
		return 'index';
	}

	if (in_array($_GET['page'],$valid_pages)){
		return $_GET['page'];;
	}
}


