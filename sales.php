<?php
require "settings.php"; 
require "view/top.php"; 
require "view/view_functions.php";

if (isset($_GET['best']) && $_GET['best']==1){

	echo "<h2>Best Selling Parts</h2><hr>";
	
	$best_sales = get_sales('best-selling');
	echo pie_chart($best_sales);

	echo print_best_sales_table($best_sales);

} else {
	echo "<h2>Total Sales</h2><hr>";
	$sales = get_sales($_GET['q']);
	echo print_sales_table($sales);
}

require "view/bottom.php";


