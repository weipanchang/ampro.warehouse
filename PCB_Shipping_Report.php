<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />  
      <title>Display Shipping Report</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css">
</head>
<body>
<div id='fg_membersite_content'>
<h2 style="color:blue; text-decoration: underline ">Display Shipping Report</h2>
<p style="color:red">
Warning: This page is only to allow Ampro Management to access.<br> 
</p>
<p style="color:blue">
Shipping Report
</p>

<form method="post" action="PCB_Shipping_Report.php">
<table>

<?php
require_once("connMysql.php");
$con=mysql_connect($db_host,$db_username,$db_password);
mysql_select_db($db_name);
$timezone = "America/Los_Angeles";
date_default_timezone_set($timezone);
$today = date("Y-m-d 00:00:00");
?>

<tr>
<td style="color:blue" >Start Date YYYY-MM-DD<span style ="font-style:italic;font-size:70%;color:green"> Search with Shipping Start date</span></td>
<td><input type="text" name="shipping_start_time" size="10" value=""</td>

<td style="color:blue" >End Date YYYY-MM-DD<span style ="font-style:italic;font-size:70%;color:green"> Search with Shipping End date</span></td>
<td><input type="text" name="shipping_end_time" size="10" value="<?php echo date('Y-m-d'); ?>"></td>
</tr>
<tr>
<td ><input type="submit" value="Submit" style="background-color:#0000ff; color:#fff;" ></td>
</table>
</form>


<?php

if (!isset($_POST['shipping_start_time']))
    {
    $shipping_start_time = null;
    }
else
    {
    $shipping_start_time = $_POST['shipping_start_time'];
    }
if (!isset($_POST['shipping_end_time']))
    {
    $shipping_end_time = null;
    }
else
    {
    $shipping_end_time = $_POST['shipping_end_time'];
    }

if ($_POST)
//if ( (($_POST) and ( strlen($shipping_start_time) >= 8 ) and strlen($shipping_end_time) >= 8 ))
{
    echo "<h2> Ampro Shipment Report : </h2>";
    echo "<table border='1' style='border-collapse: collapse;border-color: silver;'>";
    echo "<tr style='font-weight: bold;'>";
    echo "<td width='10' align='center'>Rec</td>";
    echo "<td width='120' align='center'>AMP_bardode</td>";
    echo "<td width='120' align='center'>SMC_bardode</td>";
    echo "<td width='200' align='center'>Model</td>";
    echo "<td width='150' align='center'>Date</td></tr>";
    
    $start2=$shipping_start_time;
    $end2=$shipping_end_time;
    //echo $shipping_start_time;
    //echo $shipping_end_time;
//    $sql= "SELECT * FROM `PCB_Barcode`"
    $sql= "SELECT * FROM `PCB_Barcode` WHERE DATE(time) >= '$start2' and DATE(time) <= '$end2' and `shipping_status` = 1  order by `model`, `time` DESC";
//    $sql= "SELECT * FROM `PCB_Barcode` WHERE DATE(time) >= '$start2' and `shipping_status` = 1 group by `model` order by `time` DESC";
    $result = mysql_query($sql);
    while($row=mysql_fetch_array($result))
    {
        echo "<tr style='font-weight: bold;'>";
        echo "<td align='center' width='10'>" . $row['recnumber'] . "</td>";
        echo "<td align='center' width='120'>" . $row['AMP_barcode'] . "</td>";
        echo "<td align='center' width='120'>" . $row['SMC_barcode'] . "</td>";
        echo "<td align='left' width='200'>" . $row['model'] . "</td>";
        echo "<td align='center' width='150'>" . $row['time'] . "</td>";
        echo "</tr>";
    }
    $sql= "SELECT COUNT(model) as cnt, model FROM `PCB_Barcode` WHERE DATE(time) >= '$start2' and DATE(time) <= '$end2' and `shipping_status` = 1
	GROUP BY model";
	$result = mysql_query($sql);
    while($row=mysql_fetch_array($result))
    {
        echo " TOTAL Shipment of " . $row['model'];
		echo '&nbsp';
		echo " are";
		echo '&nbsp';
		echo '&nbsp';
		echo $row['cnt'];

        echo "<br>";
    }
    mysql_close($con);
}
?>

<p>
Logged in as: <?= $fgmembersite->UserFullName() ?>
</p>
<p>
<a href='login-home.php'>Menu Page</a>
</p>
</div>
</body>
</html>
