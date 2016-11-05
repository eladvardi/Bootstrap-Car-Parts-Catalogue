<?php/** * create admin welcome message * @return string - returns the HTML */function admin_jumbotron(){	$jumbotron = " <div class='jumbotron'>	<h1>Car Parts Store - Admin</h1>	<p>This is an example of a car parts stock store. In the Admin area we can EDIT each products, and Add new products, and also see products out of stock</p>  </div>";	return $jumbotron;}/** * create and print the popup admin modal for the admin enable to enter or edit an item */function edit_and_insert_modal_box(){ ?>	<div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>		<div class='modal-dialog' role='document'>			<div class='modal-content'>				<form method='post'>					<input type='hidden' name='product-id' id='product-id' value='0'>					<input type='hidden' name='action' id='action' value='insert'>					<div class='modal-header'>						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>							<span aria-hidden='true'>&times;</span>						</button>						<h4 class='modal-title' id='myModalLabel'>Add a new car part to stock</h4>					</div>					<script>						$(document).ready(function(){							var model_types = car_part_type;							var $select = $('#part-type');							$select.find('option').remove();							$.each(model_types,function(key, value){								$select.append('<option value=' + key + '>' + value + '</option>');							});						});					</script>					<div class='modal-body'>						<div class='form-group'>							<label for='part-type' class='form-control-label'>Part Type:</label>							<select class='form-control selectpicker' id='part-type' name='car_part_types' data-live-search='true' >								<option value='1'>Please Select</option>							</select>						</div>						<div class='form-group'>							<label for='part-condition' class='form-control-label'>Part Condition:</label>							<select class='form-control selectpicker' id='part-condition' name='car_part_condition'  data-live-search='true'>								<option value='0' selected='selected'>Good condition</option>								<option value='1'>Good as new</option>								<option value='2'>Bad Contition</option>								<option value='3'>New in box</option>							</select>						</div>						<div class='form-group'>							<label for='part-year' class='form-control-label'>Part Year:</label>							<input type='number' class='date-own form-control' id='part-year' name='part-year' required>							<script type='text/javascript'>								$('.date-own').datepicker({									minViewMode: 2,									format: 'yyyy'								});							</script>						</div>						<div class='form-group'>							<label for='description-text' class='form-control-label'>Description:</label>							<textarea class='form-control' id='part-description' name='description-text'></textarea>						</div>						<div class='form-group'>							<label for='part-price' class='form-control-label'>Price (USD):</label>							<input type='number' class='form-control' id='part-price' name='part-price' required>						</div>						<div class='form-group'>							<label for='part-name' class='form-control-label'>Quantity:</label>							<input type='number' class='form-control' id='part-quantity' name='part-quantity' value='1' required>						</div>					</div>					<div class='modal-footer'>						<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>						<button type='submit' class='btn btn-primary' >Save changes</button>					</div>				</form>			</div>		</div>	</div>	<script>		$('#myModal').on('show.bs.modal', function (event) {			var button = $(event.relatedTarget) // Button that triggered the modal			var recipient = button.data('product') // Extract info from data-* attributes			if (recipient>0){				var modal = $(this)				modal.find('.modal-title').text('Edit Product product #' + recipient)				$.getJSON( "ajax.edit.php?id="+recipient, function( data ) {					$.each( data, function( key, val ) {						modal.find('#part-'+key).val(val);						if (key == 'type'){							$('select[name=car_part_types]').val(val);							$('.selectpicker').selectpicker('refresh');						} else if (key == 'condition'){							$('select[name=car_part_condition]').val(val);							$('.selectpicker').selectpicker('refresh');						}					});				});				modal.find('#product-id').val(recipient);			} else {				var modal = $(this);				modal.find('.modal-title').text('Add a new car part to stock' );				modal.find('#product-id').val('0');			}		})	</script><?}/** * creates and returns the main table * @param $parts - list of parts * @return string - the html code of this table */function print_results_table($parts, $admin=0){	$admin_actions_header = "<th>Operations</th>";	$text = "		<table class='table sortable table-bordered tablesorter table-hover table-striped' cellspacing='0' width='100%'>		<thead class='thead-inverse'>			<tr>				<th>Product ID</th>				<th>Part Type</th>                				<th>Description</th>								<th>Year</th>				<th>Condition</th>				<th>Insertion date</th>				<th>Price</th>				<th>Quantity</th>				$admin_actions_header			</tr>		</thead>	   <tbody>	";	foreach ($parts as $id => $f){		$text .= "<tr><td>{$id}</td><td>{$f['type']}</td><td>{$f['description']}</td><td>{$f['year']}</td><td>{$f['condition']}</td><td>{$f['time']}</td><td>\${$f['price']}</td><td>{$f['quantity']}</td>";		// operations column is different in case of admin		if ($admin) {			$text .=  "<td><button type='button' class='btn btn-default btn-sm btn-option' data-toggle='modal' data-target='#myModal'  data-product='$id'><span class='glyphicon glyphicon-pencil' style='margin-right: 10px;'></span>Edit</button></td>";		} else {			$text .= "<td><button type='button' class='btn btn-success btn-sm btn-option' data-toggle='modal' data-target='#exampleModal' data-whatever='$id'><span class='glyphicon glyphicon-shopping-cart' style='margin-right: 10px;'></span>BUY</button></td>";		}		$text .= "</tr>\n";	}	$text .= "</tbody></table>";	return $text;}/** * creates and returns the cars table * @param $parts - list of cars * @return string - the html code of this table */function print_cars_table($parts){ 	$text = "	<table class='table sortable table-striped table-bordered tablesorter' cellspacing='0' width='100%'>		<thead>			<tr>				<th></th>                				<th>ID</th>				<th>Car Name</th>                				<th>Manufactured From</th>								<th>Manufactured Till</th>								<th>Wikipedia</th>			</tr>		</thead>	   <tbody>	";	foreach ($parts as $id => $f){		$img = trim($f['thumb_url']);		$img_big = trim($f['img_url']);	if ($img !=''){		$img = "<a href='$img_big' target='_blank'><img class='img-thumbnail' src='$img'></a>";	}		$wiki = trim($f['wiki_name']);	if ($wiki!=''){		$wiki = str_replace(' ','_',$wiki);		$wiki = "<a href='http://en.wikipedia.org/wiki/$wiki' target='_blank' role='button' type='button' class='btn btn-info btn-sm btn-option' data-toggle='modal'><span class='glyphicon glyphicon-globe' ></span></a>";		$wiki .= "<a href='$img_big' target='_blank' role='button' type='button' class='btn btn-warning btn-sm btn-option' data-toggle='modal'><span class='glyphicon glyphicon-camera'></span></a>";	}		$text .= "<tr><td>$img</td><td>{$id}</td><td>{$f['name']}</td><td>{$f['year_from']}</td><td>{$f['year_to']}</td><td>$wiki</td></td>";				$text .= "</tr>\n";	}	$text .= "</tbody></table>";	return $text;}/** * creates and returns the sales table * @param $parts - list of best sales array * @return string - the html code of this table */function print_sales_table($parts){ 		$text = "	<table class='table sortable table-striped table-bordered tablesorter' cellspacing='0' width='100%'>		<thead>			<tr>				<th>Sale Id</th>				<th>Buyer Name</th>				<th>Buyer address</th>                <th>Part Name</th>										<th>Part ID</th>						<th>Part Description</th>								<th>Part year</th>				<th>Part Condition</th>				<th>Purchase Time</th>								<th>Purchase Price</th>			</tr>		</thead>	   <tbody>	";	foreach ($parts as $id => $f){		$text .= "<tr><td>{$id}</td><td>{$f['user_name']}</td><td>{$f['address']}</td><td>{$f['actual_stock_name']}</td><td>{$f['stock_part_id']}</td><td>{$f['description']}</td><td>{$f['year']}</td><td>{$f['condition']}</td><td>{$f['time']}</td><td>\${$f['price']}</td></tr>\n";	}	$text .= "</tbody></table>";		return $text;}/** * creates and returns the best sales table * @param $parts - list of best sales array * @return string - the html code of this table */function print_best_sales_table($parts){ 	$text = "	<table class='table sortable table-striped table-bordered tablesorter' cellspacing='0' width='100%'>		<thead>			<tr>				<th>Part Name</th>										<th>Part ID</th>										<th>Amount of Sales</th>							</tr>		</thead>	   <tbody>	";	foreach ($parts as $id => $f){		$text .= "<tr><td>{$f['actual_stock_name']}</td><td>{$f['stock_part_id']}</td><td>{$f['amount_sales']}</td></tr>\n";	}	$text .= "</tbody></table>";		return $text;}/** * put a search box. * the search box uses ajax auto-complete * @param $placeholder - Text to show as a placeholder inside the search * @return string - return the html as a string */function create_search_bar($placeholder){global $admin;$operations = "";if ($admin){	$operations = "<button type='button' class='btn btn-success submitbtn'style='float:right;' data-toggle='modal' data-target='#myModal'>Add a new product</button>";}$html =  "<div id='remote'>	<form method='get'><input class='typeahead' type='text' name='q' placeholder='$placeholder'> <input type='submit' class='btn btn-primary submitbtn' value='Search'>	<input type='hidden' name='admin' value='$admin'>	$operations	</form>	<script>	var carParts = new Bloodhound({	  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),	  queryTokenizer: Bloodhound.tokenizers.whitespace,	  prefetch: 'autocomplete.search.ajax.php',	  remote: {		url: 'autocomplete.search.ajax.php?q=%QUERY',		wildcard: '%QUERY'	  }	});	$('#remote .typeahead').typeahead(null, {	  name: 'best-pictures',	  display: 'value',	  source: carParts	});	</script></div> ";return $html;}/** * Create the popup modal box which enables the user do a purchase */function purchase_box(){?><div class="bd-example">  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">    <div class="modal-dialog" role="document">      <div class="modal-content">        <div class="modal-header">          <button type="button" class="close" data-dismiss="modal" aria-label="Close">            <span aria-hidden="true">&times;</span>          </button>          <h4 class="modal-title" id="exampleModalLabel">New Purchase</h4>        </div>          <form method='post'>		  <input type='hidden' name='action' value='sale' >        <div class="modal-body">            <div class="form-group">              <label for="product-id" class="form-control-label">Purchase product ID:</label>              <input type="text" class="form-control" id="product-id" name="product-id" readonly required>            </div>            			<div class="form-group">              <label for="recipient-name" class="form-control-label">Please Enter your name</label>              <input type="text" class="form-control" id="recipient-name" name="recipient-name" required>            </div>            <div class="form-group">              <label for="address-text" class="form-control-label">Please Enter your Address:</label>              <textarea class="form-control" id="address-text" name='address-text' required></textarea>            </div>                  </div>        <div class="modal-footer">          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>          <button type="submit" class="btn btn-primary" >Place Order</button>        </div>		</form>      </div>    </div>  </div></div><script>$('#exampleModal').on('show.bs.modal', function (event) {  var button = $(event.relatedTarget) // Button that triggered the modal  var recipient = button.data('whatever') // Extract info from data-* attributes  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.  var modal = $(this)  modal.find('.modal-title').text('Purchase product #' + recipient)  modal.find('#product-id').val(recipient)})</script><?}/** * Prints a pie chart for the best sales * @param $best_sales - an array of the sales data */function pie_chart($best_sales){?>   <div id="piechart" style="width: 100%; height: 500px;"></div>      <script type="text/javascript">      google.charts.load('current', {'packages':['corechart']});      google.charts.setOnLoadCallback(drawChart);      function drawChart() {       var data = google.visualization.arrayToDataTable([	   	<?			$text ='';		foreach ($best_sales as $id => $f){ 			$text .= ", ['{$f['actual_stock_name']}',{$f['amount_sales']}]";		}	?>          ['Task', 'Hours per Day']          <?=$text?>        ]);        var options = {          title: ''        };        var chart = new google.visualization.PieChart(document.getElementById('piechart'));        chart.draw(data, options);      }    </script><?}/** * prints the top of the html page */function print_top(){	global $alerts, $page;	?>	<!DOCTYPE html>	<html lang="en">	<head>		<meta charset="utf-8">		<meta http-equiv="X-UA-Compatible" content="IE=edge">		<meta name="viewport" content="width=device-width, initial-scale=1">		<title>Car Parts Shop</title>		<script src="https://code.jquery.com/jquery-1.12.3.js"></script>		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>		<!--Bootstrap Select -->		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>		<!-- js variables and jsons -->		<script src="js/js_vars.php"></script>		<!--Bootstrap notify -->		<script src="js/bootstrap-notify.min.js"></script>		<script src="js/myfunctions.bootstrap-notify.js"></script>		<!-- Typeahead -->		<script  type="text/javascript" src="js/typeahead.js"></script>		<link rel="stylesheet" href="css/style.css">		<!-- Charts -->		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>		<!-- Year Picker -->		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">		<!-- Tablesorter -->		<script type="text/javascript" src="js/jquery.tablesorter.js"></script>	</head>	<body>	<div class="container">		<script>			$(document).ready(function() {				<? foreach ($alerts as $key=>$value){ echo $value; }?>	 		// Pop all notification				$(".sortable").tablesorter( {sortList: []} ); 					// Table sort			});		</script>		<nav class="navbar navbar-inverse">			<div class="container-fluid">				<div class="navbar-header">					<a class="navbar-brand" href="index.php">Car Parts Store</a>				</div>				<ul class="nav navbar-nav">					<li <?if ($page=='index'){echo ' class="active"'; }?>><a href="index.php">Client view</a></li>					<li <?if ($page=='index-admin'){echo ' class="active"'; }?>><a href="index.php?page=admin">Manager view</a></li>					<ul class="nav navbar-nav">						<li class="dropdown">							<a class="dropdown-toggle" data-toggle="dropdown"  href="#">Manager Tools<b class="caret"></b></a>							<ul class="dropdown-menu">								<li><a href="index.php?page=best-sales">Best Sellers </a></li>								<li><a href="index.php?page=sales">All Sales Report</a></li>								<li class="divider"></li>								<li><a href="index.php">Log off (switch to user view)</a></li>							</ul>						</li>					</ul>					<ul class="nav navbar-nav">						<li class="dropdown">							<a class="dropdown-toggle" data-toggle="dropdown"  href="#">Catalogue <b class="caret"></b></a>							<ul class="dropdown-menu">								<li><a href="index.php?page=cars">Car List + Wikipedia Info</a></li>							</ul>						</li>					</ul>				</ul>			</div>		</nav>	</div>	<div class="container"><?}/** * Prints the bottom of the html page */function print_bottom(){	?>	</div>  </body></html><?}/** * prints a page title * @param $title * @param $size * * @return string  - the html */function page_title($title,$size=2){	return "<h$size>$title</h$size><hr>";}