<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/x
html1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />  
<title>Ampro Warehouse Contract Manufacture Order Search by Date Page</title>
</head>
<!--<link href="default.css" rel="stylesheet" type="text/css" /> -->
</head>  
<body> 
<div id='fg_membersite_content'>
<h2 style="color:blue; text-decoration: underline ">Ampro Warehouse Contract Manufacture Order Search by Model Page</h2>
<p style="color:red">
Warning: This page is only to allow Ampro Management to access.<br> 
</p>
<!--<p style="color:blue">-->
<h4 style="text-align:left; color:blue;";>Search Manufacture Order by Date </h4>
<!--</p>-->

<form method="post" action="Search_by_Date.php">
<table>

<?php
require_once("connMysql.php");
$con=mysql_connect($db_host,$db_username,$db_password);
mysql_select_db("$db_name") or die(mysql_error());
$timezone = "America/Los_Angeles";
date_default_timezone_set($timezone);
$today = date("Y-m-d 00:00:00");
?>

<tr>
<td style="color:blue" >Start Date YYYY-MM-DD<span style ="font-style:italic;font-size:70%;color:green"> Search with Start date</span></td>
<td><input type="text" name="start_time" size="10" value=""</td>

<td style="color:blue" >End Date YYYY-MM-DD<span style ="font-style:italic;font-size:70%;color:green"> Search with End date</span></td>
<td><input type="text" name="end_time" size="10" value="<?php echo date('Y-m-d'); ?>"></td>
</tr>
<tr>
<td ><input type="submit" name=""submit3" value="Submit" style="background-color:#0000ff; color:#fff;" ></td>
</table>
</form>
<p>
Logged in as: <?= $fgmembersite->UserFullName() ?>

<?php
if ($_POST) {
    if (!isset($_POST['start_time']))
        {
        $start_time = null;
        }
    else
        {
        $start_time = $_POST['start_time'];
        }
    if (!isset($_POST['end_time']))
        {
        $end_time = null;
        }
    else
        {
        $end_time = $_POST['end_time'];
        }
    $start2=$start_time;
    $end2=$end_time;
    echo "<table width='1000' border='5'; style='border-collapse: collapse;border-color: silver;'>";  
    echo "<tr style='font-weight: bold;'>";  
    echo "<td width='10%' align='center'>Rec</td>";
    echo "<td width='10%' align='center'>Model</td>";
    echo "<td width='10%' align='center'>Rev</td>";  
    echo "<td width='10%' align='center'>Line</td>";
    echo "<td width='10%' align='center'>PO</td>";
    echo "<td width='10%' align='center'>WO</td>";
    echo "<td width='10%' align='center'>BOM</td>";
    echo "<td width='10%' align='center'>Start</td>";
    echo "<td width='10%' align='center'>&nbspEnd&nbsp</td>";
    echo "<td width='8%' align='center'>&nbspQty&nbsp</td>";
    echo "<td width='10%' align='center'>Operator</td>";
    echo "<td width='10%' align='center'>Date</td>";
    echo "</tr>";
    $con=mysql_connect($db_host,$db_username,$db_password) or die(mysql_error());
    mysql_select_db("$db_name") or die(mysql_error());
    $sql = "SELECT * FROM `Contract_Manufacturer_Work_Order` WHERE DATE(`date`) >= '$start2' and DATE(`date`) <= '$end2' order by `model`, `date` DESC";
    $result=mysql_query($sql, $con);
    while ($row=mysql_fetch_array($result))  {
        echo "<tr style='font-weight: bold;'>"; 
        echo "<tr>";  
        echo "<td align='center' width='10%'>" . $row['recnumber'] . "</td>";  
        echo "<td align='center' width='10%'>" . $row['model'] . "</td>";
        echo "<td align='center' width='10%'>" . $row['revision'] . "</td>";
        echo "<td align='center' width='5%'>" . $row['line'] . "</td>";
        echo "<td align='left' width='20%'>" . $row['Purchasingorder'] . "</td>";
        echo "<td align='left' width='20%'>" . $row['Work_Order'] . "</td>";
        echo "<td align='left' width='20%'>" . $row['BOM_File'] . "</td>";
        echo "<td align='left' width='10%'>" . $row['Start_PCB'] . "</td>";
        echo "<td align='left' width='10%'>" . $row['End_PCB'] . "</td>";
        echo "<td align='center' width='8%'>" . $row['Qty'] . "</td>";
        echo "<td align='left' width='10%'>" . $row['operator'] . "</td>";
        echo "<td align='left' width='10%'>" . $row['date'] . "</td>";
        echo "</tr>";
    }
}
?>

</p>
<p>
<p><a href='login-home.php'>Back</a></p>
<p><a href='logout.php'>Logout</a></p>
</p>
<p>&nbsp;</p>

</div>

</body>
<!--<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: left;"><a href='Ampro_model_menu.php'>Back to Edit Model Name List Main Page</a></p>-->
</html>

