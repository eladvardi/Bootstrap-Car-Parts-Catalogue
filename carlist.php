<?php
require "settings.php"; 
require "view/top.php"; 
require "view/view_functions.php";

$cars = get_car_list();
echo print_cars_table($cars);

include "view/bottom.php";

