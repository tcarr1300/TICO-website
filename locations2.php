<?php require_once('Connections/tigsTico.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_tigsTico, $tigsTico);
$query_rsDlr = "SELECT  * FROM tbldealers WHERE (corp = 'Tico' and terminationdate is NULL) ORDER BY country, dealername, hq, stateProvince, city";
$rsDlr = mysql_query($query_rsDlr, $tigsTico) or die(mysql_error());
$row_rsDlr = mysql_fetch_assoc($rsDlr);
$totalRows_rsDlr = mysql_num_rows($rsDlr);
// --sample sprintf a pacode to filter on
//$getDlr_rsDlr = "";
//if (isset( $_POST['pa'] )) {
//  $getDlr_rsDlr =  $_POST['pa'] ;	// if you posted the PA Code (dealer code) use it
//}
//mysql_select_db($database_tigsTico, $tigsTico);
//$query_rsDlr = sprintf("SELECT  * FROM tbldealers WHERE (terminationdate is NULL)ORDER BY country, dealername, hq, stateProvice, city", GetSQLValueString($getDlr_rsDle, "int"));
//$rsDlr = mysql_query($query_rsDlr, $tigsTico) or die(mysql_error());
//$row_rsDlr = mysql_fetch_assoc($rsDlr);
//$totalRows_rsDlr = mysql_num_rows($rsDlr);
// --end samplle spintf filter
// --sample paging--
//$maxRows_rsCategory = 10;
//$pageNum_rsCategory = 0;
//if (isset($_GET['pageNum_rsCategory'])) {
//  $pageNum_rsCategory = $_GET['pageNum_rsCategory'];
//}
//$startRow_rsCategory = $pageNum_rsCategory * $maxRows_rsCategory;

//mysql_select_db($database_tigsTico, $tigsTico);
//$query_rsCategory = "SELECT * FROM tblcategory ORDER BY tblcategory.category";
//$query_limit_rsCategory = sprintf("%s LIMIT %d, %d", $query_rsCategory, $startRow_rsCategory, $maxRows_rsCategory);
//$rsCategory = mysql_query($query_limit_rsCategory, $tigsTico) or die(mysql_error());
//$row_rsCategory = mysql_fetch_assoc($rsCategory);
// --end sample paging--
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Tico Pro-Spotters</title>
<link rel="stylesheet" type="text/css" media="screen, projection" href="css/tico.css" />
<link rel="stylesheet" type="text/css" media="screen, projection" href="css/text.css" />
<link rel="stylesheet" type="text/css" media="screen, projection" href="css/specialtyitems.css" />
<link rel="stylesheet" type="text/css" media="screen, projection" href="css/nav.css" />
<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" />
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<script src="HTTP://use.edgefonts.net/alfa-slab-one;arimo:n4,i4,n7,i7:all.js"></script>

</head>

<body>
<div class="container_16">
<h1 style="display:none">TICO Pro-Spotter Advantages</h1>

<header class="grid_16">
<a href="index.html" class="ticologo left"><img src="images/ticologo.png" width="299" height="37" alt="Tico Trucks" /></a>

<div class="blocktag right"><h2>FOR THE REAL WORLD</h2></div>

 
<a href="tel:8002898426" class="ticophone left">800.BUY.TICO (800.289.8426)</a>
</header> 

<!-- Begin Nav -->
<nav class="grid_16">
<div class="tophr">
<hr />
</div>
<ul id="nav">
<li> <a href="index.html" alt="TICO Pro-Spotter Advantages">TICO Pro-Spotter Advantages</a> </li>
<li> <a href="galvanized.html" alt="TICO Galvanized Pro-Spotter">Galvanized Pro-Spotter</a> </li>
<li><a href="comparisons.html" alt="Compare TICO and the Competition">Competitive Comparisons</a></li>
<li class="current"><a href="locations.html" alt="US/Canada Locations">Locations</a></li>
</ul>
<div class="tophr">
<hr />
</div>
</nav> 


<!-- Dealer Locations -->
<article class="grid_16 main locator">
<?php
//	header break on country (null is considered U.S. Dealers)
   $countryBreak = "none";	
   $countryHeader = "U.S. Dealers";
?>
<?php  do { ?>
<?php 
  if ($countryBreak != $row_rsDlr['country']) {
  		if ($row_rsDlr['country']){
		   $countryHeader = $row_rsDlr['country']." Dealers";
		}
		if ($dealerBreak!=""){
			echo"</tr></table>";
		}
?>
<h2><?php echo $countryHeader;?></h2>
<?php 
  		$countryBreak = $row_rsDlr['country'];	  
		$dealerBreak="";
?>
<?php
  }
?>
<?php 	//  break to a new table for each dealername
	if ($dealerBreak != $row_rsDlr['pacode']) {
		if ($dealerBreak!=""){
			echo"</tr></table>";
		}
		$dealerBreak = $row_rsDlr['pacode'];	
		$i=0;			
?>
<table>
<th colspan="3"><?php echo $row_rsDlr['dealername'];?>
</th>
<tr>
<?php
	}
?>
<td>
<?php if ($row_rsDlr['hq'] == true ){
	echo"<h5>Dealer Corporate Office</h5>";
}
?>
<h4><?php echo $row_rsDlr['addressLine1'];?><br />
<?php echo $row_rsDlr['city']." ".$row_rsDlr['stateProvince']."  ".$row_rsDlr['zipcode'];?></h4>
<a href="https://maps.google.com/maps?q=<?php echo urlencode($row_rsDlr['addressLine1']." ".$row_rsDlr['addressLine2'].", ".$row_rsDlr['city']." ".$row_rsDlr['stateProvince']." ".$row_rsDlr['zipcode'].", ".$row_rsDlr['country']);?>">Map This Location</a>
<?php echo $row_rsDlr['contactType']." ".$row_rsDlr['contact']?><br />
<?php echo $row_rsDlr['altContactType']." ".$row_rsDlr['altContact']?>
</td>
<?php
	// break to a new row after 3 locations
		$i++;
		if ($i>2) {
			echo"</tr><tr>";
			$i=0;
		}
?>

<?php } while ($row_rsDlr = mysql_fetch_assoc($rsDlr));
?>
</tr></table>

<br/><br/>
<hr />
</article> 

<footer class="grid_16">
<a href="index.html"><img src="images/ticologosmall.png" width="190" height="24" alt="Tico - For The Real World"/></a>

<address>
PO Box 1434 Savannah, Georgia 31402
</address>

<h6><a href="tel:800.289.8426">800.BUY.TICO</a> (800.289.8426) Main:<a href="tel:912.232.2124"> 912.232.2124</a> Fax: 912.232.9025</h6>

<div>
    <ul class="bottomlinks">
	<li><a href="terms.html">Terms and Conditions</a></li>
	<li style="border:none">Copyright &copy; 2014</li>
	</ul>
  </div>
</footer>

</div><!-- end .container_16 -->

</body>
</html>
