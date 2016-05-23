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
<h2 style="color:blue; text-decoration: underline ">Ampro Warehouse Contract Manufacture Order Search by Model Page</h2>
<p style="color:red">
Warning: This page is only to allow PingShow employee to access.<br> 
</p>
<p style="color:blue">
Ampro Warehouse Contract Manufacture Order Search by Model Page
</p>

<form name="myform3" method="POST" action="">
<p><span class="error">* Please select the Model *</span></p>
<div style="text-align:left"> 
<ul>
<?php
    require_once("connMysql.php");
    $con=mysql_connect($db_host,$db_username,$db_password) or die(mysql_error());
    mysql_select_db($db_name);
    $sql = "SELECT `model` FROM `Contract_Manufacturer_Work_Order` group by `model` order by `model`";
    $result=mysql_query($sql);
    echo "<select name='model' size=8>";
    while ($row= mysql_fetch_array($result) ) {
       echo "<option value='" . $row['model'] ."'>" . $row['model'] ."</option>";
    }
    echo "</select>";
?>
    <input type="submit" name="submit3" style="color: #FF0000; font-size: larger;" value="Select the Model and Click here">
</ul>
</div>
</form>
<?php
   
if (isset($_POST['submit3']))
{

    if (!isset($_POST['model']))
        {
        $model = null;
        }
    else 
        {
        $model = $_POST['model'];
        }
    //$model = $_POST['model'];
    //echo $model;

    echo "<table width='1000' border='5'; style='border-collapse: collapse;border-color: silver;'>";  
    echo "<tr style='font-weight: bold;'>";  
    echo "<td width='10%' align='center'>Rec</td>";
    echo "<td width='10%' align='center'>Model</td>";  
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
    
    $sql = "SELECT * FROM `Contract_Manufacturer_Work_Order` WHERE `model` = '$model' group by `model`";
    $result=mysql_query($sql, $con);
    while($row=mysql_fetch_array($result))  {
    echo "<tr style='font-weight: bold;'>"; 
    echo "<tr>";  
    echo "<td align='center' width='10%'>" . $row['recnumber'] . "</td>";  
    echo "<td align='center' width='10%'>" . $row['model'] . "</td>";
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
<p>
Logged in as: <?= $fgmembersite->UserFullName() ?>
</p>
<p>
<p><a href='login-home.php'>Back</a></p>
<p><a href='logout.php'>Logout</a></p>
</p>
<p>&nbsp;</p>

</div>
</body>
</html>

