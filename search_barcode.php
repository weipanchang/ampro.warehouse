<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />  
<title>Ampro System Barcode Re-Associate</title>
</head>

<body>
<div id='fg_membersite_content'>
<h2 style="color:blue; text-decoration: underline ">Barcode Re-Associate Page</h2>
<p style="color:red">
Warning: This page is only to allow PingShow employee to access.<br> 
</p>
<p style="color:blue">
Management Ampro System Barcode, SMC Barcode and Shipping Flag
</p>

<form method="post" action="search_barcode.php">
<table> 
<tr>
<td style="color:blue" >Enter Ampro System Barcode</td>
<td><input type="text" name="AMP_barcode" size="12" value=""></td>
</tr>

<tr>
<td style="color:blue" >Enter SuperMicro Barcode</td>
<td><input type="text" name="SMC_barcode" size="12" value=""></td>
</tr>
<td ><input type="submit" value="Submit" style="background-color:#0000ff; color:#fff;" ></td>
</table>
</form>

<?php
require_once("connMysql.php");
if (!isset($_POST['AMP_barcode'])) 
    {
    $AMP_barcode = null;
    }
else 
    {
    $AMP_barcode = $_POST['AMP_barcode'];
    }

if (!isset($_POST['SMC_barcode'])) 
    {
    $SMC_barcode = null;
    }
else 
    {
    $SMC_barcode = $_POST['SMC_barcode']; 
    }
   
if (($_POST) && ( strlen($AMP_barcode) == 12 ))
{    
    echo "<table width='1000' border='5'; style='border-collapse: collapse;border-color: silver;'>";  
    echo "<tr style='font-weight: bold;'>";  
    echo "<td width='5%' align='center'>Rec Number</td><td width='20%' align='center'>AMP Barcode</td>";  
    echo "<td width='20%' align='center'>SMC Barcode</td>";
    echo "<td width='10%' align='center'>Shipping</td>";
    echo "<td width='20%' align='center'>Set date</td>";
    echo "<td width='20%' align='center'>update</td>";
    echo "</tr>";
    $con=mysql_connect($db_host,$db_username,$db_password) or die(mysql_error());
    mysql_select_db("$db_name") or die(mysql_error());
    
    $sql = "SELECT * FROM `PCB_Barcode` WHERE `AMP_barcode` = '$AMP_barcode'";
    $result=mysql_query($sql, $con);
    while($row=mysql_fetch_array($result))  {
        if ($row['shipping_status'] == 1) {
            $shipping = "Ship Out";
        }
        else {
            $shipping = "On Hold";
        }
    echo "<tr style='font-weight: bold;'>"; 
    echo "<tr>";  
    echo "<td align='center' width='5%'>" . $row['recnumber'] . "</td>";  
    echo "<td align='left' width='20%'>" . $row['AMP_barcode'] . "</td>";
    echo "<td align='left' width='20%'>" . $row['SMC_barcode'] . "</td>";
    echo "<td align='left' width='10%'>" . $shipping . "</td>";
    echo "<td align='left' width='20%'>" . $row['date'] . "</td>";
    echo "<td align='left' width='20%'>" . $row['time'] . "</td>";

    echo "</tr>";
    }
}
if (($_POST) && ( strlen($SMC_barcode) == 12 ))
{    
    echo "<table width='1000' border='5'; style='border-collapse: collapse;border-color: silver;'>";  
    echo "<tr style='font-weight: bold;'>";  
    echo "<td width='5%' align='center'>Rec Number</td><td width='20%' align='center'>AMP Barcode</td>";  
    echo "<td width='20%' align='center'>SMC Barcode</td>";
    echo "<td width='10%' align='center'>Shipping</td>";
    echo "<td width='20%' align='center'>Set date</td>";
    echo "<td width='20%' align='center'>update</td>";
    echo "</tr>";
    $con=mysql_connect($db_host,$db_username,$db_password) or die(mysql_error());
    mysql_select_db("$db_name") or die(mysql_error());
    
    $sql = "SELECT * FROM `PCB_Barcode` WHERE `SMC_barcode` = '$SMC_barcode'";
    $result=mysql_query($sql, $con);
    while($row=mysql_fetch_array($result))  {
        if ($row['shipping_status'] == 1) {
            $shipping = "Ship Out";
        }
        else {
            $shipping = "On Hold";
        }
    echo "<tr style='font-weight: bold;'>"; 
    echo "<tr>";  
    echo "<td align='center' width='5%'>" . $row['recnumber'] . "</td>";  
    echo "<td align='left' width='20%'>" . $row['AMP_barcode'] . "</td>";
    echo "<td align='left' width='20%'>" . $row['SMC_barcode'] . "</td>";
    echo "<td align='left' width='10%'>" . $shipping . "</td>";
    echo "<td align='left' width='20%'>" . $row['date'] . "</td>";
    echo "<td align='left' width='20%'>" . $row['time'] . "</td>";

    echo "</tr>";
    }    
    
}
?>
<p>
Logged in as: <?= $fgmembersite->UserFullName() ?>
</p>
<p>
<a href='Ampro_operator_menu.php'>Back to Edit Operator Name List Main Page</a>
</p>
<p>&nbsp;</p>
<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: left;"><a href='Ampro_operator_menu.php'>Back to Edit Operator Name List Main Page</a></p>
</div>
</body>
</html>

