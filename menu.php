<?php

if (isset($_GET['bg'])){ $BACKGROUND = $_GET['bg']; } else { $BACKGROUND = "black";}  //can be any color normall blank "" or black
if (isset($_GET['tb'])){ $TEXTCOLOR = ""; } else { $TEXTCOLOR = "text-white";}   // must be either blank ""  or text-white
if (isset($_GET['store'])){ $LOCATION = $_GET['store'];} else { $LOCATION = "Greer"; }

require_once("./mongotest.php");

if (isset($_GET['first_tap'])) { $first_tap=$_GET['first_tap']; } else { $first_tap=1; }
if (isset($_GET['last_tap'])) { $last_tap=$_GET['last_tap']; } else { $last_tap=8; }

	$db = new mongoTest;

	//$taplist = $db->findall_test();

switch (strtoupper($LOCATION)) {
    case "LANDRUM":
	$taplist = $db->getTaps_Landrum();
	break;
    case "GREER":
    default:
	$taplist = $db->getTaps_Greer();
	break;
}


?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="refresh" content="90">
<link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">
<style type="text/css">
    body { background: <?php echo $BACKGROUND; ?> !important;  /* Adding !important forces the browser to overwrite the default style applied by Bootstrap */
     background-image: url(images/beer-bg.jpg);
     background-opacity: 0.3;
     }

	.card-title {
		font-family: 'Exo', sans-serif;
	}

	div.container {
	  margin: 30px;
	  background-color: <?php echo $BACKGROUND; ?> ;
	  border: 1px solid black;
	  opacity: 1.0;
	  font-family: 'Exo', sans-serif;
	  filter: alpha(opacity=60); /* For IE8 and earlier */
	}

</style> 

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <style>
  /* Make the image fully responsive */
  .carousel-inner img {
      width: 100%;
      height: 100%;
  }


  h5{
    margin-top: 10px;
    padding:0;
  }

  .carousel-item{
    margin-top: -5px;
    padding:0;
  } 
}
  </style>
	<title>Tap Menu</title>

</head>
	<body>
<div class="container">
<div class="card" style="width: 35em; background: <?php echo $BACKGROUND; ?> !important;"> 

<h1 class="card-title <?php echo $TEXTCOLOR; ?>">
	   On Tap</h1>
	   <div class="table table-condensed table-striped <?php echo $TEXTCOLOR; ?>"> 
        <?php

foreach($taplist as $x){
		if(($x->tap_number >= $first_tap) AND ($x->tap_number <= $last_tap)) { 
			$abv_perc=$x->ABV;
		        $discounted_price=$x->Price-($x->Price*$x->Discount);	
		echo "<div id='$x->_id' class='carousel slide' data-ride='carousel'>";
		    echo "<h5><strong>$x->tap_number</strong> - $x->Brewery $x->Brew </h5>";
		    echo "<div class='carousel-inner'>";
		        echo "<div class='carousel-item active'>&nbsp;&nbsp;&nbsp; $abv_perc%   $x->Pour Oz. $".money_format("%.2n", $discounted_price)."</div>";
		        echo "<div class='carousel-item'>&nbsp;&nbsp;&nbsp; $x->Category</div>";
		        //echo "<div class='carousel-item'>&nbsp;&nbsp;&nbsp; Patron Rating: $x->Rating out of 10</div>";
		    echo "</div>";
		    echo "</div>";
		} else { next($x); }
	    }
        ?>
</div>
</div>

</body></html> 

