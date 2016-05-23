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
   $model = "";
   $comment = "";
   $operatorerror = "Your name is missing";
   $modelerror = "";
   $error=0;
   
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["operator"])) {
        $barcodeerror = "Name is required";
        $error=1;
      }
      else {
        $barcode = test_input($_POST["operator"]);
        $error=0;
      }
   }
   
   function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
   }
   
   include("Ampro_station_info.php");
   require_once("connMysql.php");
?>

<h1 style="text-align:center; color:blue; text-decoration: underline";>Ampro System PCB Check in/out</h1>
<h3 style="text-align:center; color:blue; text-decoration: underline";> <?php echo $station_type; echo " Station    "; echo $line_number; ?></php?></h3>
<form name="myform3" method="POST" action="">
<!--   <p><span class="error">* Please select your name *</span></p>-->
   Welcome back <?= $fgmembersite->UserFullName(); ?>!

<?php
      $con=mysql_connect($db_host,$db_username,$db_password);
      mysql_select_db($db_name);
      $operator = $fgmembersite->UserFullName();

      if ($station_type=='AOI') {
?>
      <p><span class="error">* Please select the Model number *</span></p>
   
   <table>
   <tr>
   <td>
   <h3 style="text-align:center; color:blue; text-decoration";>Date<h3>
   </td>
   <td>
   <input type="text" name="submit3" style="color: #FF0000; font-size: larger;">
   </td>
   </tr>
   <tr>
   <td>
   <h3 style="text-align:center; color:blue; text-decoration";>Line No.#<h3>
   </td>
   <td>
   <input type="text" name="submit3" style="color: #FF0000; font-size: larger;">
   </td>
   </tr>
   
   <tr>
   <td>
   <h3 style="text-align:center; color:blue; text-decoration";>Model<h3>
   </td>
   <td>
   <input type="text" name="submit3" style="color: #FF0000; font-size: larger;">
   </td>
   </tr>
   
      <tr>
   <td>
   <h3 style="text-align:center; color:blue; text-decoration";>Revision<h3>
   
   </td>
   <td>
   <input type="text" name="submit3" style="color: #FF0000; font-size: larger;">
   </td>
   </tr>
   
   <tr>
   <td>
   <h3 style="text-align:center; color:blue; text-decoration";>PO<h3>
   
   </td>
   <td>
   <input type="text" name="submit3" style="color: #FF0000; font-size: larger;">
   </td>
   </tr>
         <tr>
   <td>
   <h3 style="text-align:center; color:blue; text-decoration";>WorkOrder#<h3>
   
   </td>
   <td>
   <input type="text" name="submit3" style="color: #FF0000; font-size: larger;">
   </td>
   </tr>
         <tr>
   <td>
   <h3 style="text-align:center; color:blue; text-decoration";>BOM File<h3>
   
   </td>
   <td>
   <input type="text" name="submit3" style="color: #FF0000; font-size: larger;">
   </td>
   </tr>
         <tr>
   <td>
   <h3 style="text-align:center; color:blue; text-decoration";>Qty<h3>
   
   </td>
   <td>
   <input type="text" name="submit3" style="color: #FF0000; font-size: larger;">
   </td>
   </tr>
         <tr>
   <td>
   <h3 style="text-align:center; color:blue; text-decoration";>StartSN :<h3>
   
   </td>
   <td>
   <input type="text" name="submit3" style="color: #FF0000; font-size: larger;">
   </td>
   </tr>
         <tr>
   <td>
   <h3 style="text-align:center; color:blue; text-decoration";>EndSN :<h3>
   
   </td>
   <td>
   <input type="text" name="submit3" style="color: #FF0000; font-size: larger;">
   </td>
   </tr>
   <tr><td> <input type="submit" name="btnInsert" style="color: #FF0000; font-size: larger;" value="Insert"></td></tr>
   </table>
   
   
<?php
    if (isset($_POST['btnInsert'])) {
        $defect= $_POST['defect'];
        $issueinfo = $_POST['Model']. " on " .$_POST['Revision']. " in ".  $_POST['Lineno'].$_POST['Purchasingorder'].$_POST['Wordorder'].$_POST['BOMfile'].$_POST['Startsn'].$_POST['Endsn'].$_POST['Qty'];
        if (!($issueinfo === ' on top in ')) {
            if ((substr($issueinfo, 0, 11)) == ' on top in '){
                $issueinfo = substr($issueinfo, 11);
            }
            
            $sql="SELECT `Issue_log`, `create_time` FROM `PCB_Issue_Tracking` where `PCB` = '$barcode' order by `create_time` DESC";
            $result = mysql_query($sql, $con);
            $row= mysql_fetch_array($result); 
            $dd = new DateTime();
            //echo $dd->format('Y-m-d H:i:s');
            //echo "<br>";
            $dd= ($dd->modify("-20 minutes"));
            //echo $dd->format('Y-m-d H:i:s');
            //echo "<br>";
            //echo $row['create_time'];
            //echo "<br>";
            //echo $row['Issue_log'];
            //echo "<br>";
            if (!($issueinfo == $row['Issue_log'] and $row['create_time'] <= $dd)) {
            $sql = "INSERT INTO `PCB_Issue_Tracking`(`PCB`, `Issue_log`, `defect`, `station`, `line`, `operator`) VALUES('$barcode','$issueinfo', '$defect', '$station_type','$line_number', '$operator')";
            $result=mysql_query($sql, $con);
 
            echo "New issue Added:---- " . $issueinfo;
            }
        }
    }
    mysql_close($con);
  }
?>

   


<?php
   
      if ($station_type=='AOI') {
         //$con=mysql_connect($db_host,$db_username,$db_password);
         //mysql_select_db($db_name);
         $sql = "SELECT * FROM `PCB_Model` order by model";
         $result=mysql_query($sql);
         echo "<select name='model' size=8>";
         while ($row= mysql_fetch_array($result) ) {
            echo "<option value='" . $row['model'] ."'>" . $row['model'] ."</option>";
         }
         echo "</select>";
      }
?>

   <br><br>
   <br><br>
   <input type="submit" name="submit3" style="color: #FF0000; font-size: larger;" value="Confirm Your Select">
   </form>
   <br><br>
      
<?php
   if (($station_type=='AOI') and (isset($_POST['submit3']))) {
      //$operator=$_POST['name'];
      $model=$_POST['model'];
      echo "<h4>Your Login ID is:  $operator </h4>";
      echo "<h4>Model:  $model </h4>";
?>
   <form method="post" action="Ampro_php_form3.php" >
   <input type="hidden" name="name"
     value="<?php echo  $operator; ?>">
   <input type="hidden" name="model"
     value="<?php echo  $model; ?>">
   <input type="submit" name="submit3" style="color: #FF0000; font-size: larger;" value="Next">
   </form>
<?php   
   }
   elseif (isset($_POST['submit3'])) {
      $operator = $_SESSION['username'];
      echo "<h4>Your Login ID is :  $operator </h4>";
?>   
   <form method="post" action="Ampro_php_form3.php" >
      <input type="hidden" name="name"
        value="<?php echo  $operator; ?>">
      <input type="hidden" name="model"
        value="<?php echo  $model; ?>">
      <input type="submit" name="submit3" style="color: #FF0000; font-size: larger;" value="Next">
   </form>
<?php
   }
   echo "<br>";
   mysql_close($con);
?>

<p><a href='logout.php'>Logout</a></p>

