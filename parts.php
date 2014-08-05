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
$query_Recordset1 = "SELECT * FROM tblvehicles";
$Recordset1 = mysql_query($query_Recordset1, $tigsTico) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

// DROP THESE - NOT IN USE
//mysql_select_db($database_tigsTico, $tigsTico);
//$query_Recordset2 = "SELECT * FROM tbltocheader WHERE tbltocheader.TOC = 75193";
//$Recordset2 = mysql_query($query_Recordset2, $tigsTico) or die(mysql_error());
//$row_Recordset2 = mysql_fetch_assoc($Recordset2);
//$totalRows_Recordset2 = mysql_num_rows($Recordset2);

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

//if (isset($_GET['totalRows_rsCategory'])) {
//  $totalRows_rsCategory = $_GET['totalRows_rsCategory'];
//} else {
//  $all_rsCategory = mysql_query($query_rsCategory);
//  $totalRows_rsCategory = mysql_num_rows($all_rsCategory);
//}
//$totalPages_rsCategory = ceil($totalRows_rsCategory/$maxRows_rsCategory)-1;

//mysql_select_db($database_tigsTico, $tigsTico);
//$query_rsDetail = "SELECT * FROM tbltocdetail WHERE tbltocdetail.category = 1 AND tbltocdetail.TOC = 75193 ORDER BY tbltocdetail.line";
//$rsDetail = mysql_query($query_rsDetail, $tigsTico) or die(mysql_error());
//$row_rsDetail = mysql_fetch_assoc($rsDetail);
//$totalRows_rsDetail = mysql_num_rows($rsDetail);

$getTOC_rsTOC = "";
if (isset( $_POST['toc'] )) {
  $getTOC_rsTOC =  $_POST['toc'] ;	// if you posted the TOC use it
}else if (isset( $_POST['vin'] )) { // look up a vin's toc
  $getVIN_rsVIN =  $_POST['vin'] ;
	mysql_select_db($database_tigsTico, $tigsTico);
	$query_rsVIN = sprintf("SELECT * FROM tblvehicles WHERE tblvehicles.VIN = '%s'", GetSQLValueString($getVIN_rsVIN, "str"));
	$rsVIN = mysql_query($query_rsVIN, $tigsTico) or die(mysql_error());
	$row_rsVIN = mysql_fetch_assoc($rsVIN);
	$totalRows_rsVIN = mysql_num_rows($rsVIN);

  $getTOC_rsTOC = $row_rsVIN['TOC'];

}else if (isset( $_POST['sn'] )) { // look up a serial#'s toc
  $getSN_rsSN =  $_POST['sn'] ;
	mysql_select_db($database_tigsTico, $tigsTico);
	$query_rsSN = sprintf("SELECT * FROM tblvehicles WHERE tblvehicles.serial = %u", GetSQLValueString($getSN_rsSN, "int"));
	$rsSN = mysql_query($query_rsSN, $tigsTico) or die(mysql_error());
	$row_rsSN = mysql_fetch_assoc($rsSN);
	$totalRows_rsSN = mysql_num_rows($rsSN);
  $getTOC_rsTOC = $row_rsSN['TOC'];
}
mysql_select_db($database_tigsTico, $tigsTico);
$query_rsTOC = sprintf("SELECT  tbltocheader.TOC, tbltocheader.partBookName, tbltocheader.serialRange, tbltocdetail.category, tbltocdetail.line, tbltocdetail.partNumber, tbltocdetail.partName, tbltocdetail.image, tblcategory.categoryName FROM (tbltocheader INNER JOIN tbltocdetail ON tbltocheader.TOC = tbltocdetail.TOC) INNER JOIN tblcategory ON tbltocdetail.category = tblcategory.category WHERE tbltocdetail.TOC = %s ORDER BY tbltocdetail.category, tbltocdetail.line", GetSQLValueString($getTOC_rsTOC, "int"));
$rsTOC = mysql_query($query_rsTOC, $tigsTico) or die(mysql_error());
$row_rsTOC = mysql_fetch_assoc($rsTOC);
$totalRows_rsTOC = mysql_num_rows($rsTOC);

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">

<link rel="stylesheet" type="text/css" media="screen, projection" href="css/tico.css">
<link rel="stylesheet" type="text/css" media="screen, projection" href="css/text.css">
<link rel="stylesheet" type="text/css" media="screen, projection" href="css/specialtyitems.css">
<link rel="stylesheet" type="text/css" media="screen, projection" href="css/nav.css">
<link rel="stylesheet" href="http://use.edgefonts.net/c/b9bf9d/alfa-slab-one:n4,arimo:i4:i7:n4:n7.WW1:N:2,WX8:N:1,WX9:N:1,WX6:N:1,WX7:N:1/d">
<script src="HTTP://use.edgefonts.net/alfa-slab-one;arimo:n4,i4,n7,i7:all.js"></script>

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<title>TICO Parts</title>
</head>

<body>
<div class="container_16">
<div class="searchwrap">
<div class="logoandtitle">
<a href="index.html"><img src="images/ticologosearch.png" /></a>
<h1>Parts Manual Search</h1>
</div>

<div class="textsearch">
<form action="<?php echo $_SERVER['PHP_SELF'] ; ?>" method="post" id="vinsearch">
<input type="text" name="vin" maxlength="17" placeholder="Enter a TICO VIN" required="">
<button type="submit">Search</button>
</form>

<form  action="<?php echo $_SERVER['SCRIPT_NAME'] ; ?>" method="post" id="snsearch">
<input name="sn" type="text" maxlength="4" placeholder="Enter a TICO Serial Number (SN)" required="">
<button type="submit">Search</button>
</form>
</div>

<div class="dropdown">
<form action="<?php echo $_SERVER['SCRIPT_NAME']  ; ?>" method="post" id="vindrop"  >
<select name="toc" onChange="this.form.submit()">
  <option selected="selected" disabled="disabled">Select a TICO VIN from this list</option>
<?php
do {  
?>
    <option value="<?php echo $row_Recordset1['TOC']?>"><?php echo $row_Recordset1['VIN']?></option>
<?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
  </select>
<br>
<select name="toc" onChange="this.form.submit()">
	<option selected="selected" disabled="disabled">Select a TICO SN from this list</option>
<?php
do {  
?>
    <option value="<?php echo $row_Recordset1['TOC']?>"><?php echo $row_Recordset1['Serial']?></option>
<?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
</select>
</form>
</div>
				 
<div class="searchdisclaimers">
<p class="searchlegal">
By accessing the TICO Online Parts Manuals you are agreeing to the terms and conditions described <a href="terms.html"> here</a>.
</p>
</div>
</div> 
<!--End Search -->

<!-- Begin Dynamic TOC --> 
<article class="main parts" id="toc">
<h1 class="toctitle">
<?php
if 	($row_rsTOC['TOC']) {
	echo 'Table of Contents for ' . $row_rsTOC['partBookName'] .  ' ' . $row_rsTOC['serialRange']; 
	}else if (isset( $_POST['sn'] )) {
		echo 'Table of Contents for ' . $getSN_rsSN . ' was not found.<p>Please check your entry and try again or call: <a href="#">800.289.8426</a> <i>Monday through Friday, 9AM to 5PM EST.'; 		
	}else if (isset( $_POST['vin'] )) {
		echo 'Table of Contents for VIN: ' . $getVIN_rsVIN . ' was not found.<p>Please check your entry and try again or call: <a href="#">800.289.8426</a> <i>Monday through Friday, 9AM to 5PM EST.'; 		
	}
?>
</h1>


<?php   $groupBreak = NULL;	?>
<?php do { ?>
<?php 
  if ($groupBreak != $row_rsTOC['category']) {
?>
    <table>
    <colgroup>
        <col width="30%">
        <col width="70%">
    </colgroup>
	    <tr>
      <td colspan="2" class="tablesubhead">Section &nbsp;<?php echo $row_rsTOC['category']; ?>:&nbsp;<?php echo $row_rsTOC['categoryName']; ?></td>
      </tr>
		  <tr>
		    <th>Parts List Number</th>
		    <th>Description</th>
		    </tr>
<?php
}
  $groupBreak = $row_rsTOC['category'];

?>
          
		    <tr>
		      <td><?php echo $row_rsTOC['partNumber']; ?></td>
		      <td><?php
			  		if ($row_rsTOC['image']) {
			  		echo '<a href="partsPdf/' . $row_rsTOC['image'] .'" target="draw">'; 
					}
			        echo $row_rsTOC['partName']; 
				?></td>
		      </tr>
		    <?php } while ($row_rsTOC = mysql_fetch_assoc($rsTOC)); ?>
</table>
<br>
<hr>
</article> 
<!--End Dynamic TOC-->
<footer class="grid_16">
<a href="index.html"><img src="images/ticologosmall.png" width="190" height="24" alt="Tico - For The Real World"></a>

<address>
PO Box 1434 Savannah, Georgia 31402
</address>

<h6><a href="tel:8002898426">800.BUY.TICO</a> (800.289.8426) Main:<a href="tel:9122322124"> 912.232.2124</a> Fax: 912.232.9025</h6>

<div>
    <ul class="bottomlinks">
	<li><a href="terms.html">Terms and Conditions</a></li>
	<li style="border:none">Copyright © 2014</li>
	</ul>
</div>
</footer>
</div><!-- end .container_16 -->

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($rsCategory);

mysql_free_result($rsDetail);

mysql_free_result($rsTOC);
?>
