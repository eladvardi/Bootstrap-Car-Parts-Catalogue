<?php
require "settings.php";
require "view/view_functions.php";

print_top();

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

echo print_results_table(get_parts($_GET['q']),$admin);

print_bottom();


