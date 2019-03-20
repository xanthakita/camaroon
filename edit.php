<?php

require_once("./mongotest.php");

        $db = new mongoTest;

        $taplist = $db->getAll();

// the following if structure is called when the file is loaded from the edit form and updates the database
        // the page then reloads with the edited data

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	//echo "<pre>"; var_dump($_POST);
  $db->update();
  //exit;
  header('Location: edit.php');
}
?>

	
<!DOCTYPE HTML>
<html lang="en">
    <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>


  <!--    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
  -->

  <style>
  .container {
      top_margin: 25px;
  }
  </style>
      <style type="text/css">
    .odd {
      background-color: #FFF8FB !important;
    }
    .even {
      background-color: #DDEBF8 !important;
    }
    a {
        text-decoration: none;
    }
    .error {
        color: red;
    }
    </style>
        <title>Inventory Admin Panel</title>

</head>
        <body>
<div class="container">
	<h2>Beer Inventory</h2>
	   <table id="beerlist" class="table table-condensed table-striped display">
		<thead>
			<tr>
				<th></th>
				<th>UUID</th>
				<th>Location</th>
				<th>Tap_Number</th>
				<th>Brewery</th>
				<th>Brew</th>
				<th>ABV</th>
				<th>Pour</th>
				<th>Discount</th>
				<th>Price</th>
				<th>Menu Description</th>
			</tr>
			<tr>
				<th colspan=2></th><th colspan=9>Detailed Description</th>
			</tr>
		</thead>
		<tbody> 
        <?php
	foreach($taplist as $x){
		echo "<tr>";
		echo "<td rowspan=2><a href='http://intheupstate.net/edit_inventory.php?item=".$x->_id."' type='button' class='btn btn-info' role='button'>Edit</a></td>";
		echo "<td rowspan=2>$x->_id</td><td>$x->Location</td><td>$x->tap_number</td><td>$x->Brewery</td>";
		echo "<td>$x->Brew</td><td>$x->ABV</td><td>$x->Pour</td><td>$x->Discount</td><td>$x->Price</td>";
                echo "<td>$x->Category</td>";
                echo "</tr>";
                echo "<tr><td colspan=14>$x->Description</td></tr>";
            }
?>
		</tbody>
	</table>
</div>
<script>


$(document).ready(function() {
    $('#beerlist').DataTable( {
        "processing": true,
        "serverSide": true,
        "pagingType": "full_numbers",
        "ajax": {
            "url": "/get_admin.php",
            "type": "POST"
        },
        "columns": [
            { "data": "_id" },
            { "data": "Location" },
            { "data": "tap_number" },
            { "data": "Brewery" },
            { "data": "Brew" },
            { "data": "ABV" },
            { "data": "Pour" },
            { "data": "Discount" },
            { "data": "Price" },
            { "data": "Category" }
        ]
    } );
} );

</script>
</body></html> 	
	
