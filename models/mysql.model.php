<?php
require_once "DB_Connection.php";
$alerts = array();


/**
 * check if we have a purchase, and if so decrease amount from stock
 */
function check_post_purchase(){
	global $alerts, $conn;

	if (isset($_POST['action']) && ($_POST['action']=='sale')) {
		$product_id = (int)$_POST['product-id'];
		$name 		= mysqli_real_escape_string($conn,$_POST['recipient-name']);
		$address 	= mysqli_real_escape_string($conn,$_POST['address-text']);

		$query = mysqli_query($conn, "INSERT INTO `car_parts_shop`.`sales` ( `user_name`, `address`, `stock_part_id`, `purchase_time`) VALUES ( '$name', '$address', '$product_id', CURRENT_TIMESTAMP)");
		if ($query){
			mysqli_query($conn, "UPDATE `car_parts_shop`.`actual_stock` SET `quantity` =`quantity`-1 WHERE `actual_stock`.`id` = $product_id;");
			$alerts[] = "myNotify('Product purched successfully','success');";
		} else {
			$alerts[] = "myNotify('Product purchase failed','danger');";
		}
	}
}

/**
 * adding a new car part to stock (admin mode only)
 */
function check_main_car_part_insertion(){
	global $alerts, $conn;

	if (isset($_POST['product-id']) && ( (int)$_POST['product-id']==0)){

		$part_type 	= (int)$_POST['car_part_types'];
		$year 		= (int)$_POST['part-year'];
		$details 	= mysqli_real_escape_string($conn, $_POST['description-text']);
		$price 		= (float)$_POST['part-price'];
		$condition	= (int)$_POST['part-condition'];
		$quantity	= (int)$_POST['part-quantity'];

		$query = mysqli_query($conn, "INSERT INTO `car_parts_shop`.`actual_stock` (`id`, `part_type_ref_id`, `price`, `description`, `year`, `condition`, `quantity`, `insertion_time`) VALUES (NULL, '$part_type', '$price', '$details', '$year', '$condition', '$quantity', CURRENT_TIMESTAMP)");
		if ($query){
			$alerts[] = "myNotify('Car part added successfully','success');";
		} else {
			$alerts[] = "myNotify('Car part was not added','danger');";
		}


	}
}


/**
 * edit car part
 * check data prom POST
 */
function check_main_car_part_edit(){
	global $alerts, $conn;

	if (isset($_POST['product-id']) && ((int)$_POST['product-id']>0)){
		$id 		= (int)$_POST['product-id'];
		$part_type 	= (int)$_POST['car_part_types'];
		$year 		= (int)$_POST['part-year'];
		$details 	= mysqli_real_escape_string($conn, $_POST['description-text']);
		$price 		= (float)$_POST['part-price'];
		$condition	= (int)$_POST['part-condition'];
		$quantity	= (int)$_POST['part-quantity'];

		$query = mysqli_query($conn, "UPDATE `car_parts_shop`.`actual_stock` SET `part_type_ref_id`='$part_type', `price`='$price', `description`='$details', `year`='$year', `condition`='$condition', `quantity`='$quantity' WHERE `id`='$id'	");
		if ($query){
			$alerts[] = "myNotify('Car part was edited successfully','success');";
		} else {
			$alerts[] = "myNotify('Car part was not edited successfully','danger');";
		}
	}
}


/**
 * create and returns array of car parts
 * @param string $q - like query
 * @return array|bool
 */
function get_parts($q=''){
	global $conn, $global_conditions, $admin;
	$parts = array();
	$search_query = '';

	if (!$admin)	{
		$quantity_sql = " AND `quantity`>0 ";
	}

	if ($q!=''){
		$q = mysqli_real_escape_string($conn,$q);
		$search_query = " AND (`description` LIKE '%$q%' OR t.name LIKE '%$q%')";
	}

	if ($query = mysqli_query($conn, "SELECT s.*,t.name as type_name FROM `actual_stock` s ,`car_part_types` t where s.part_type_ref_id=t.id $search_query  $quantity_sql ORDER BY `insertion_time` DESC")){
		while ($r = mysqli_fetch_array($query)){
			$parts[$r['id']] = array('type'=>$r['type_name'],'description'=>$r['description'],'year'=>$r['year'],'condition'=>$global_conditions[$r['condition']],'time'=>$r['insertion_time'],'quantity'=>$r['quantity'],'price'=>$r['price']);
		}
		return $parts;
	}
	return false;
}


/**
 * get car list catalogue array
 * @param string $q
 * @return array|bool
 */
function get_car_list($q=''){
	global $conn;
	$parts = array();

	if ($query = mysqli_query($conn, "SELECT * FROM `car_models` ORDER BY `year_from` DESC ")){

		while ($r = mysqli_fetch_array($query)){
			$parts[$r['id']] = array('name'=>$r['name'],'year_from'=>$r['year_from'],'year_to'=>$r['year_to'],'img_url'=>$r['img_url'],'thumb_url'=>$r['thumb_url'],'wiki_name'=>str_replace('.','',$r['wiki_name']));
		}
		return $parts;
	}
	return false;
}


/**
 * return the sales array
 *
 * @param string $type
 * @return array|bool
 */
function get_sales($type=''){

	$group_by = '';
	$sum = '';
	$limit = ' ';

	if ($type=='best-selling'){
		$group_by = ' group by stock_part_id ';
		$order_by = '  ORDER BY amount_sales DESC ';
		$sum = ' ,sum(1) as amount_sales ';
		$limit = ' LIMIT 10 ';
	} else {
		$order_by = ' ORDER BY `purchase_time` DESC ';
	}

	global $conn, $global_conditions, $admin;
	$parts = array();

	$query_str = "SELECT * $sum FROM sales s, car_part_types t, actual_stock a WHERE s.stock_part_id = a.id AND a.part_type_ref_id = t.id $group_by $order_by $limit";
	if ($query = mysqli_query($conn, $query_str)){
		while ($r = mysqli_fetch_array($query)){

			if ($type=='best-selling'){
				$parts[$r['sale_id']] = array('stock_part_id'=>$r['stock_part_id'],'amount_sales'=>$r['amount_sales'],'actual_stock_name'=>$r['name'],'description'=>$r['description'],'year'=>$r['year'],'condition'=>$global_conditions[$r['condition']],'time'=>$r['purchase_time'],'price'=>$r['price']);
			} else {
				$parts[$r['sale_id']] = array('stock_part_id'=>$r['stock_part_id'],'user_name'=>$r['user_name'],'address'=>$r['address'],'actual_stock_name'=>$r['name'],'description'=>$r['description'],'year'=>$r['year'],'condition'=>$global_conditions[$r['condition']],'time'=>$r['purchase_time'],'price'=>$r['price']);
			}
		}
		return $parts;
	}
	return false;
}


/**
 * get car part types
 * @param string $q
 * @return array|bool
 */
function get_car_part_types($q=''){
	global $conn;

	$parts = array();
	$search_query = '';
	if ($q!=''){
		$q = mysqli_real_escape_string($conn,$q);
		$search_query = " AND (`name` LIKE '%$q%')";
	}

	if ($query = mysqli_query($conn, "SELECT * FROM `car_part_types` WHERE 1 $search_query ")){
		while ($r = mysqli_fetch_array($query)){
			$parts[] = $r['name'];
		}
		return $parts;
	}
	return false;
}