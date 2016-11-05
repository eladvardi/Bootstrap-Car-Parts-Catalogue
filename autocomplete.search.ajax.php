<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once "models/mysql.model.php";
$parts = get_car_part_types($_GET['q']); 

foreach ($parts as $f){	
	$tok 	 = $f;
	$tok 	 = str_replace('/',' ',$tok);
	$tok_arr = array_filter(explode(' ',$tok));

	$res[] = array('year'=>'','value'=>$f,'tokens'=>$tok_array);
}

echo json_encode($res);


