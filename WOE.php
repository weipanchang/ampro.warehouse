<?PHP
require_once("./include/membersite_config.php");
$operator = $fgmembersite->UserFullName();

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
?>

<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>

<?php
   // define variables and set to empty values
   $operator = "";
   //$model = "";
   $comment = "";
   $modelerror = "";
   $error=0;
  
   function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
   }
   
   include("Ampro_station_info.php");
   require_once("connMysql.php");
?>

<h1 style="text-align:center; color:blue; text-decoration: underline";>Ampro Warehouse Contract Manufacture Order Entry Page</h1>
<h3 style="text-align:center; color:blue; text-decoration: underline";> <?php echo $station_type; echo " Station    "; echo $line_number; ?></php?></h3>
Welcome back <?= $fgmembersite->UserFullName(); ?>!

<form name="myform3" method="POST" action="">

<?php
      $con=mysql_connect($db_host,$db_username,$db_password);
      mysql_select_db($db_name);
      $operator = $fgmembersite->UserFullName();
?>
  
<form name="myform3" method="POST" action="">
<p><span class="error">* Please select the Model number *</span></p>
<div style="text-align:left"> 
<ul>
<?php
    $sql = "SELECT * FROM `PCB_Model` group by model order by model";
    $result=mysql_query($sql);
    echo "<select name='model' size=8>";
    while ($row= mysql_fetch_array($result) ) {
       echo "<option value='" . $row['model'] ."'>" . $row['model'] ."</option>";
    }
    echo "</select>";
    echo "<br>";
?>
      
    <input type="submit" name="submit3" style="color: #FF0000; font-size: larger;" value="Select the Model and Click here">

<?php

    if ((isset($_POST['submit3'])) and (isset($_POST['model']))) {
?>            

<form name="myform4" method="POST" action="">
<?php                
        $model = $_POST['model'];
        echo "<h3 style='color:blue';>"."You Selected ".$model."</h3>";
        echo "<br>";
        $sql = "SELECT `revision` FROM `PCB_Model` where `model` = '$model' order by revision";
        $result=mysql_query($sql);
        echo "<select name='revision' size=3>";
        while ($row= mysql_fetch_array($result))   {
            echo "<option value='" . $row['revision'] ."'>" . $row['revision'] ."</option>";
        }
        echo "</select>";
        echo "<br>";
?>
        <input type="hidden" name="model" value="<?php echo  $model;?>">
<!--        <input type="hidden" name="revision" value="<?php echo  $row['revision'];?>">-->
        <input type="submit" name="submit4" style="color: #FF0000; font-size: larger;" value="Select the Revsion and Click here">
<?php
    }
?>
</ul>
</div>
</form> 
<?php
    if ((isset($_POST['submit4'])) and (isset($_POST['revision']))) {
        $model = $_POST['model'];
        $revision = $_POST['revision'];
        echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"; 
        echo "<h3 style='color:blue';>".$model;
        echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
        echo "R";
        echo "&nbsp";
        echo $revision;
        echo "</h3>";
        //$sql = "SELECT * from `PCB_Model where `model` = '$model' and `revision` = '$revision'";
        //$result=mysql_query($sql);
        //$rowcount=mysql_num_rows($result);
        //if ($rowcount != 0) {
        //    echo "Enter here";
        //    unset($_POST['submit4']);
        //    unset($_POST['submit3']);
        //    header('Location: WOE.php');
        //}
?>    
<form name="myform5" method="POST" action="">

        <input type="hidden" name="model" value="<?php echo  $model;?>">
        <input type="hidden" name="revision" value="<?php echo  $revision;?>">
        <table>
        <tr>
        <td>
        <h3 style="text-align:center; color:blue;";>Line No :</h3>
        </td>
        <td>
        <input type="text" name="LineNo" style="color: #FF0000; font-size: larger;">
        </td>
        </tr>
        <tr>
        <td>
        <h3 style="text-align:center; color:blue;";>PO :</h3>
        </td>
        <td>
        <input type="text" name="PO" style="color: #FF0000; font-size: larger;">
        </td>
        </tr>
        <tr>
        <td>
        <h3 style="text-align:center; color:blue;";>WorkOrder :</h3>
        </td>
        <td>
        <input type="text" name="WorkOrder" style="color: #FF0000; font-size: larger;">
        </td>
        </tr>
        <tr>
        <td>
        <h3 style="text-align:center; color:blue;";>BOM File :</h3>
        </td>
        <td>
        <input type="text" name="BOM" style="color: #FF0000; font-size: larger;">
        </td>
        </tr>
        <tr>
        <td>
        <h3 style="text-align:center; color:blue;";>Quality :<h3>
        </td>
        <td>
        <input type="text" name="Qty" style="color: #FF0000; font-size: larger;">
        </td>
        </tr>
        <tr>
        <td>
        <h3 style="text-align:center; color:blue;";>StartSN :<h3>
        </td>
        <td>
        <input type="text" name="StartSN" style="color: #FF0000; font-size: larger;">
        </td>
        </tr>
        <tr>
        <td>
        <h3 style="text-align:center; color:blue;";>EndSN :<h3>
        </td>
        <td>
        <input type="text" name="EndSN" style="color: #FF0000; font-size: larger;">
        </td>
        </tr>
        <tr><td> <input type="submit" name="btnInsert" style="color: #FF0000; font-size: larger;" value="Insert"></td></tr>
        </table>
</form> 
<?php
    }
    if (isset($_POST['btnInsert'])) {
        if (!(ctype_digit($_POST['Qty']))) {
                $_POST['Qty'] = "";
            }
        if (($_POST['model'] !="") and ($_POST['revision'] !="") and ($_POST['LineNo'] !="") and ($_POST['PO'] !="") and ($_POST['WorkOrder'] !="")
            and ($_POST['BOM'] !="") and($_POST['Qty'] !="") and ($_POST['StartSN'] !="") and ($_POST['EndSN'] !="")) {
            $model = $_POST['model'];
            $revision = $_POST['revision'];
            $LineNo = $_POST['LineNo'];
            $PO = $_POST['PO'];
            $WorkOrder = $_POST['WorkOrder'];
            $BOM = $_POST['BOM'];
            $Qty = $_POST['Qty'];
            $StartSN = $_POST['StartSN'];
            $EndSn = $_POST['EndSN'];

            
            $sql = "INSERT INTO `Contract_Manufacturer_Work_Order`(`model`, `revision`, `line`, `Purchasingorder`, `Work_Order`,
            `BOM_File`, `Start_PCB`, `End_PCB`, `operator`, `Qty`) VALUES ('$model', '$revision','$LineNo', '$PO', '$WorkOrder',
            '$BOM', '$StartSN', '$EndSn', '$operator', '$Qty')";
            $result=mysql_query($sql, $con);
            
            echo "<table width='1000' border='5'; style='border-collapse: collapse;border-color: silver;'>";  
            echo "<tr style='font-weight: bold;'>";  
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
            echo "</tr>";
            $con=mysql_connect($db_host,$db_username,$db_password) or die(mysql_error());
            mysql_select_db("$db_name") or die(mysql_error());
            
            $sql = "SELECT * FROM `Contract_Manufacturer_Work_Order` WHERE `model` = '$model' group by `model`";
            $result=mysql_query($sql, $con);
            while($row=mysql_fetch_array($result))  {
                echo "<tr style='font-weight: bold;'>"; 
                echo "<tr>";  
                echo "<td align='center' width='10%'>" . $model . "</td>";
                echo "<td align='center' width='10%'>" . $revision . "</td>";
                echo "<td align='center' width='5%'>" . $LineNo. "</td>";
                echo "<td align='left' width='20%'>" . $PO . "</td>";
                echo "<td align='left' width='20%'>" . $WorkOrder . "</td>";
                echo "<td align='left' width='20%'>" . $BOM . "</td>";
                echo "<td align='left' width='10%'>" . $StartSN. "</td>";
                echo "<td align='left' width='10%'>" . $EndSn . "</td>";
                echo "<td align='center' width='8%'>" . $Qty . "</td>";
                echo "<td align='left' width='10%'>" . $operator . "</td>";
                
                echo "</tr>";
                        echo "New Record Added:---- ";
                        unset ($_POST['submit4']);
                        //header('Location: WOE.php');
            }
        }
        else {
            echo "<h3 style='color:red';>"."Quality input should be numerical and All Field is needed, --- Re-Enter Please!"."</h3>";
        }
        mysql_close($con);
    } 
?>
<p><a href='WOE.php'>Refreash Page</a></p>
<p><a href='login-home.php'>Back</a></p>
<p><a href='logout.php'>Logout</a></p>

