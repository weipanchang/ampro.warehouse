<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model =$_POST['model'];
}
else {
    $model = "";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/x
html1/DTD/xhtml1-strict.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />  
<title>Ampro System Add New Model</title>
</head>
<!--<link href="default.css" rel="stylesheet" type="text/css" /> -->
</head>  
<body> 
<div id='fg_membersite_content'>
<h2 style="color:blue; text-decoration: underline ">Ampro System</h2>
<p style="color:red">
Warning: This page is only to allow Ampro Management to access.<br> 
</p>
<!--<p style="color:blue">-->
<h4 style="text-align:left; color:blue;";>Add New Model</h4>
<!--</p>-->

<form name="myform" method="post" action="">
<table> 
<tr>
<td style="color:blue" >Enter The Model Name</td>
<td><input type="text" name="model" size="30" value="<?php echo $model;?>"></td>
</tr>
<td ><input type="submit" name="submit" value="submit" style="background-color:#0000ff; color:#fff;" ></td>
</table>
</form>

<?php
    require_once("connMysql.php");
    echo "<table width='600' border='5'; style='border-collapse: collapse;border-color: silver;'>";  
    echo "<tr style='font-weight: bold;'>";  
    echo "<td width='20%' align='center'>Rec Number</td><td width='50%' align='center'>Model Name</td></tr>";  
    
    $con=mysql_connect($db_host,$db_username,$db_password) or die(mysql_error());
    mysql_select_db("$db_name") or die(mysql_error());
    
    $sql = "SELECT * FROM `PCB_Model` order by model";
    $result=mysql_query($sql, $con);
    while($row=mysql_fetch_array($result))  {
    echo "<tr style='font-weight: bold;'>"; 
    echo "<tr>";  
    echo "<td align='center' width='20%'>" . $row['recnumber'] . "</td>";  
    echo "<td align='left' width='50%'>" . $row['model'] . "</td>";

    echo "</tr>";
    }
    if (isset($_POST['submit'])) {
        $model = $_POST['model'];
        $con=mysql_connect($db_host,$db_username,$db_password) or die(mysql_error());
        mysql_select_db("$db_name") or die(mysql_error());
        
        $sql = "INSERT INTO `PCB_Model` (`model`) VALUES('$model')";
        $result=mysql_query($sql, $con) or die(mysql_error());
        
        mysql_close($con);
        header('Location:Ampro_model_menu.php');
    }
?>
<p>
Logged in as: <?= $fgmembersite->UserFullName() ?>
</p>
<p>
<a href='Ampro_model_menu.php'>Back to Edit Model Name List Main Page</a>
</p>
<p>&nbsp;</p>
<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: left;"><a href='Ampro_model_menu.php'>Back to Edit Model Name List Main Page</a></p>
</div>
</body>
</html>
