<?php
require_once "../models/DB_Connection.php";

$k = array();
 $query = mysqli_query($conn, "SELECT * FROM  `car_part_types` ");
 while ($res = mysqli_fetch_array($query)){
	//echo $res['id'].', '.$res['name']."<br>";
	$k[$res['id']]=$res['name'];
 }
  
echo "var car_part_type=".json_encode($k).";\n";