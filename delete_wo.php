<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
$rec_number="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $rec_number =$_POST["record"];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/x
html1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />  
<title>Ampro arehouse Contract Manufacture Order Delete Page< </title>
</head>
<!--<link href="default.css" rel="stylesheet" type="text/css" /> -->
</head>  
<body> 
<div id='fg_membersite_content'>
<h2 style="color:blue; text-decoration: underline ">Ampro arehouse Contract Manufacture Order Delete Page</h2>
<p style="color:red">
Warning: This page is only to allow Ampro Management to access.<br> 
</p>
<!--<p style="color:blue">-->
<h4 style="text-align:left; color:blue;";>Delete Model</h4>
<!--</p>-->

<form name="myform" method="post" action="">
<table> 
<tr>
<td style="color:blue" >Enter The Record Number</td>
<td><input type="text" name="record" size="10" value="<?php echo $rec_number;?>"></td>
</tr>
<td ><input type="submit" name="submit" value="submit" style="background-color:#0000ff; color:#fff;" ></td>
</table>
</form>

<?php
    require_once("connMysql.php");
    
    if ((isset($_POST['submit'])) and ($_POST['record'] != "")) {
    $rec_number = $_POST['record'];
    $con=mysql_connect($db_host,$db_username,$db_password) or die(mysql_error());
    mysql_select_db("$db_name") or die(mysql_error());
    
    $sql = "DELETE FROM `PCB_Model` WHERE `recnumber` = '$rec_number'";
    $result=mysql_query($sql, $con) or die(mysql_error());
    
    mysql_close($con);
    header('Location:delete_wo.php');
    }
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
    
    $sql = "SELECT * FROM `Contract_Manufacturer_Work_Order`";
    $result=mysql_query($sql, $con);
    while($row=mysql_fetch_array($result))  {
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
    
    if ((isset($_POST['submit'])) and ($_POST['record'] != "")) {
        $rec_number = $_POST['record'];
        $con=mysql_connect($db_host,$db_username,$db_password) or die(mysql_error());
        mysql_select_db("$db_name") or die(mysql_error());
        
        $sql = "DELETE FROM  `Contract_Manufacturer_Work_Order` WHERE `recnumber` = '$rec_number'";
        $result=mysql_query($sql, $con) or die(mysql_error());
        
        mysql_close($con);
        //header('Location:Ampro_model_menu.php');
    }
?>
<p>
Logged in as: <?= $fgmembersite->UserFullName() ?>
</p>
<p>
<p><a href='login-home.php'>Back</a></p>
<p><a href='logout.php'>Logout</a></p>
</p>
<p>&nbsp;</p>
<!--<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: left;"><a href='Ampro_model_menu.php'>Back to Edit Model Name List Main Page</a></p>-->
</div>
</body>
</html>
