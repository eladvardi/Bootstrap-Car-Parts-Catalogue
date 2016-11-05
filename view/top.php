<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car Parts Shop</title>
	
	<script src="https://code.jquery.com/jquery-1.12.3.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
		
	<!--Bootstrap Select -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>
	
	<!-- js variables and jsons -->
	<script src="js/js_vars.php"></script>
	
	<!--Bootstrap notify -->
	<script src="js/bootstrap-notify.min.js"></script>
	<script src="js/myfunctions.bootstrap-notify.js"></script>
	
	<!-- Typeahead -->
	<script  type="text/javascript" src="js/typeahead.js"></script>
	<link rel="stylesheet" href="css/style.css">
	
	<!-- Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	
	<!-- Year Picker -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
	
	<!-- Tablesorter -->
	<script type="text/javascript" src="js/jquery.tablesorter.js"></script> 	
</head>

<body>
    <div class="container">

	<script>
	
	$(document).ready(function() {
		<? foreach ($alerts as $key=>$value){ echo $value; }?>	 		// Pop all notification
		$(".sortable").tablesorter( {sortList: []} ); 					// Table sort
	}); 	
	</script>	

    <nav class="navbar navbar-inverse">
	
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="index.php">Car Parts Store</a>
		</div>
		<ul class="nav navbar-nav">
		  
		  <li <?if ($admin==0){echo ' class="active"'; }?>><a href="index.php">Client view</a></li> 
		  <li <?if ($admin==1){echo ' class="active"'; }?>><a href="index.php?admin=1">Manager view</a></li>
		  
		  	<ul class="nav navbar-nav">
			  <li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown"  href="#">Manager Tools<b class="caret"></b></a>
				<ul class="dropdown-menu">
                  <li><a href="sales.php?best=1">Best Sellers </a></li>
                  <li><a href="sales.php">All Sales Report</a></li>
                  <li><a href="carlist.php">Car List + Wikipedia Info</a></li>
                  <li class="divider"></li>
                  <li><a href="index.php">Log off (switch to user view)</a></li>
                </ul>
			  </li>
			</ul>
		</ul>
	  </div>
	</nav>
	</div> 
	
	<div class="container">