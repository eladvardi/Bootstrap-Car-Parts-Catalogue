<?php
require "settings.php";
require "view/view_functions.php";

print_top();

echo page_title("Cars Catalogue",2);
echo print_cars_table(get_car_list());

print_bottom();

