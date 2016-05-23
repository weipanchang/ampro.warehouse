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
      <title>PCB Through AOI On Night Shift</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css">
</head>
<body>
<div id='fg_membersite_content'>
<h2 style="color:blue; text-decoration: underline ">PCB Throgh AOI Night Shift</h2>
<p style="color:red">
Warning: This page is only to allow Ampro Management to access.<br> 
</p>
<p style="color:blue">
PCB Throgh AOI Night Shift
</p>


<form method="post" action="PCB_Through_AOI_Night.php">

<table>
<?php
  $timezone = "America/Los_Angeles";
  date_default_timezone_set($timezone);
  $today = date("Y-m-d 00:00:00");
?>

<tr>

<td style="color:blue" >Date (YYYY-MM-DD)<span style ="font-style:italic;font-size:70%;color:green"> Search with PCB on AOI with Date (Day Shift)</span></td>
<!--<td style="color:blue" ><span style ="font-style:italic;font-size:70%;color:black">Search with member crateion date</span> End Date YYYY-MM-DD</td>-->
<td><input type="text" name="Query_Day" size="10" value="<?php echo 'YYYY-MM-DD'; ?>"></td>
</tr>

<tr>
<td ><input type="submit" value="Submit" style="background-color:#0000ff; color:#fff;" ></td>
</tr>
</table>

</form>

<?php  

require_once("connMysql.php");


if (!isset($_POST['Query_Day']))
    {
    $Query_Day = null;
    }
else
    {
    $Query_Day = $_POST['Query_Day'];
    }

if (($_POST) && ( strlen($Query_Day) > 9) && ($Query_Day !='YYYY-MM-DD')) {
    //echo $Query_Day;

    echo "<h2> PCB Through AOI on Day Shift  : </h2>";
    echo "<table width='1000' border='5'; style='border-collapse: collapse;border-color: silver;'>";  
    echo "<tr style='font-weight: bold;'>";  
    echo "<td width='30' align='center'>Rec Number</td><td width='30' align='center'>PCB Number</td><td width='8' align='center'>Assembler Line</td><td width='20' align='center'>Station</td><td width='10%' align='center'>status</td>  ";  
    echo "<td width='10%' align='center'>Scripped</td><td width='200' align='center'>note</td><td width='20%' align='center'>Time</td></tr>";  
    
    $DBConnect=mysql_connect("$db_host", "$db_username", "$db_password") or die(mysql_error());
    mysql_select_db("$db_name") or die(mysql_error());

    $result = mysql_query("SELECT * FROM `$db_tablename` where DATE(time) = '$Query_Day' and TIME(time) >= '15:30:15' and TIME(time) <= '23:59:59' and station= 'AOI' and status= 0 and note <> 'New PCB Record Created !' order by PCB ASC, time DESC");

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
    echo "<td align='center' width='30'>" . $row['recnumber'] . "</td>";  
    echo "<td align='center' width='30'>" . $row['PCB'] . "</td>";  
    echo "<td align='center' width='20'>" . $row['line'] . "</td>";  
    echo "<td align='center' width='8'>" . $row['station'] . "</td>";  
    echo "<td align='center' width='10%'>" . $checkin . "</td>";  
    echo "<td align='center' width='10%'>" . $scrapped . "</td>";  
    echo "<td align='center' width='200'>" . $row['note'] . "</td>";  
    echo "<td aliyyyy-mm-ddgn='center' width='20%'>" . $row['time'] . "</td>";  
    echo "</tr>"; 
    $success = true; 

    }  
    echo "</table>";  

    echo "   ";
    mysql_close($DBConnect);
}




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
