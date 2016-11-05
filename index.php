<?php
require "settings.php"; 
require "view/top.php"; 
require "view/view_functions.php";

// welcome message for admins		
if ($admin) {
	echo admin_jumbotron();			
}

// search bar with auto-complete, and also include the "add a new product" button in a case of admin
echo create_search_bar('Search a car part in stock');

// in admin view,  this is the 'popup' form which lets us insert a new product, or edit exist one
if ($admin) {
	echo edit_and_insert_modal_box();
} else {
	echo purchase_box();
}

// create an array of results matching search query, or get all rows in a case of no query
$parts = get_parts($_GET['q']); 

// create a nice results table
echo print_results_table($parts,$admin);


//html for footer
require "view/bottom.php";

