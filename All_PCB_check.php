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
      <title>Recent PCB Activity Check</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css">
</head>
<body>
<div id='fg_membersite_content'>
<h2 style="color:blue; text-decoration: underline ">Monitoring All PCB</h2>
<p style="color:red">
Warning: This page is only to allow Ampro Management to access.<br> 
</p>
<p style="color:blue">
Check Recent PCB Activity
</p>


<?php  

require_once("connMysql.php");


    echo "<h2> PCB Activity Check  : </h2>";
    echo "<table width='1000' border='5'; style='border-collapse: collapse;border-color: silver;'>";  
    echo "<tr style='font-weight: bold;'>";  
    echo "<td width='25' align='center'>Rec Number</td><td width='35' align='center'>PCB Number</td>";
    echo "<td width='20%' align='center'>Model</td>";
    echo "<td width='8' align='center'>Line</td><td width='20' align='center'>Station</td>";
    echo "<td width='10%' align='center'>status</td>  ";  
    echo "<td width='10%' align='center'>Scrappped</td><td width='10%' align='center'>note</td>";
    echo "<td width='15%' align='center'>Time</td></tr>";  
    
    $DBConnect=mysql_connect("$db_host", "$db_username", "$db_password") or die(mysql_error());
    mysql_select_db("$db_name") or die(mysql_error());
    //$phonenum1 = preg_replace("/[^0-9]/", '', $phonenum1);
    
    //$number=$phonenum1;
    //$num = rtrim($number);
    //$num1 = ltrim($num);
    
    //$num1 = "+".$num1;
    $success = false;
	
    $result = mysql_query("SELECT * FROM $db_tablename order by time desc limit 50");  
    while($row=mysql_fetch_array($result))  
    {
    if ($row['status'] == 1) {
        $checkin = "Check in";
    }
    else {
        $checkin =  "Check out";
    }
    
    if ($row['scrapped'] == 1) {
        $scrapped = "Scrapped!";
    }
    else {
        $scrapped =  "Not Scrapped";
    }
    echo "<tr style='font-weight: bold;'>"; 
    echo "<tr>";  
    echo "<td align='center' width='25'>" . $row['recnumber'] . "</td>";  
    echo "<td align='center' width='35'>" . $row['PCB'] . "</td>";  
    echo "<td align='center' width='20%'>" . $row['model'] . "</td>";
    echo "<td align='center' width='20'>" . $row['line'] . "</td>"; 
    echo "<td align='center' width='8'>" . $row['station'] . "</td>";  
    echo "<td align='center' width='10%'>" . $checkin . "</td>";  
    echo "<td align='center' width='10%'>" . $scrapped . "</td>";  
    echo "<td align='center' width='10%'>" . $row['note'] . "</td>";  
    echo "<td align='center' width='15%'>" . $row['time'] . "</td>";  
    echo "</tr>"; 
    $success = true; 

    }  
    echo "</table>";  

    echo "   ";

  mysql_close($DBConnect);
?> 

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<p>
Logged in as: <?= $fgmembersite->UserFullName() ?>
</p>
<p>
<a href='login-home.php'>Menu Page</a>
</p>
</div>
</body>
</html>
