<?php
require "settings.php";
require "view/view_functions.php";

print_top();

switch (get_page()) {

	case 'index':
		echo create_search_bar('Search a car part in stock');
		echo purchase_box();
		echo print_results_table(get_parts($_GET['q']),$admin);
		break;

	case 'admin':
		$admin = 1;
		echo admin_jumbotron();
		echo create_search_bar('Search a car part in stock');
		echo edit_and_insert_modal_box();
		echo print_results_table(get_parts($_GET['q']),$admin);
		break;

	case 'best-sales':
		echo page_title("Best Selling Parts",2);
		$best_sales = get_sales('best-selling');
		echo pie_chart($best_sales);
		echo print_best_sales_table($best_sales);
		break;

	case 'sales':
		echo page_title("Total Sales",2);
		echo print_sales_table(get_sales($_GET['q']));
		break;

	case 'cars':
		echo page_title("Cars Catalogue",2);
		echo print_cars_table(get_car_list());
		break;
}

print_bottom();


