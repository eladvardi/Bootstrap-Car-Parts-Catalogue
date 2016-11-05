<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include "models/DB_Connection.php";

$id 	= (int)$_GET['id'];
$query 	= mysqli_query($conn,"SELECT * FROM  `actual_stock` WHERE `id`='$id'");

if ($r = mysqli_fetch_array($query)){

	$r['description'] = str_replace("\n",' ',$r['description']);	
	$r['description'] = trim(str_replace("\r",' ',$r['description']));	
		
	echo "{
		\"type\":\"{$r['part_type_ref_id']}\",
		\"condition\":\"{$r['condition']}\",
		\"year\":\"{$r['year']}\",
		\"description\":\"{$r['description']}\",
		\"price\":\"{$r['price']}\",
		\"quantity\":\"{$r['quantity']}\"
	}";
}


