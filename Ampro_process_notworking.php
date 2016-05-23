<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>

<?php
    include("Ampro_station_info.php");
    require_once("connMysql.php");
    if ($_POST['barcode'] == null ) {
        header("location:Ampro_php_form3.php"); 
    }
    
    $barcode = $_POST['barcode'];
    $operator = $_POST['name'];
    if ($station_type =="AOI") {
        $model = $_POST['model'];
    }
    
    include("Ampro_station_info.php");
    require_once("connMysql.php");
?>
<h1 style="text-align:center; color:blue; text-decoration: underline";> <?php echo "Ampro System PCB Check in/out"; ?></php></h1>
<h3 style="text-align:center; color:blue; text-decoration: underline";> <?php echo $station_type; echo " Station    "; echo $line_number; ?></php?></h3>
<h4 style="text-align:center; color:blue;";> <?php echo "Name: "; echo $operator;?></php?></h4>
<h4>
<?php
    //echo "You currently are processing PCB - ";
    //echo $barcode;
    //echo "<br>";
?></php?></h4>

<?php
    $con=mysql_connect($db_host,$db_username,$db_password);
    mysql_select_db($db_name);
    $sql = "SELECT * FROM `PCB_Tracking` WHERE `PCB`='$barcode' order by time DESC limit 1";
    $result=mysql_query($sql);
    $row=mysql_fetch_array($result);
    $top = $row['top'];
    $bottom = $row['bottom'];
    if ($station_type !=="AOI") {
        $model = $row['model'];
    $sql = "INSERT INTO `PCB_Tracking`(`PCB`, `model`, `top`, `bottom`,`line`, `station`, `status`,
      `scrapped`, `operator`, `note`) VALUES('$barcode', '$model', '$top', '$bottom','$line_number','$station_type',1,0,'$operator', 'Checked in')";
    $result=mysql_query($sql, $con);
    }
?>
    <h4 style="text-align:center; color:blue;";> <?php echo "Model: "; echo $row['model'];?></php?></h4>
<?php
    echo "You currently are processing PCB - ";
    echo $barcode;
    echo "<br>";
    echo "Message History: ";
    echo "<br>";
    if (!(($row['line'] == $line_number) and ($row['station'] == $station_type) and ($row['status'] == 1))) {
?>
    <h5>
<?php
    echo "<br>";
    echo $row['station'];
    echo " ";
    echo $row['line'];
    echo "<br>";
    echo "<br>";
    echo "<font color='red'>".$row['note']."</font>";
    echo "<br>";
?>
    </h5>
    
<?php
    mysql_close($con);
} 
?>

<?php
  if (($station_type=='AOI') or ($station_type=='Testing') or ($station_type=='QA')) {
     $con=mysql_connect($db_host,$db_username,$db_password);
     mysql_select_db($db_name);
     $sql = "SELECT `Issue` FROM `PCB_Issue` WHERE `station` = '$station_type'  ";
     $result=mysql_query($sql, $con);
  }
?>

<form name="issueform" action="<?php echo $PHP_SELF; ?>" method="POST">
    <div align="left"><br>

<?php
    echo "find ";
    while ($row= mysql_fetch_array($result)) {
    echo "<select name='issue'>";
        while ($row= mysql_fetch_array($result) ) {
            echo "<option value='" . $row['Issue'] ."'>" . $row['Issue'] ."</option>";
        }
    echo "</select>";
    echo " on ";
    }
?>
    <select name="topbottom">
        <option value="top">Top</option>
        <option value="bottom">Bottom</option>
    </select>
    
    In:  <input type="text" name="location" value="<?php echo "";?>">
    
    <input type="hidden" name="barcode" value="<?php echo  $barcode;?>">
    <input type="hidden" name="name" value="<?php echo  $operator;?>">
    <input type="hidden" name="model" value="<?php echo $model;?>">
    
    <input type="submit" name="submit6" style="color: #FF0000; font-size: larger;" value="Add this issue">
    </div>
</form>


<form name="myform" action="" method="POST">
    <div align="center"><br>
    <?php
        if ($top == 1){
    ?>
            <input type="checkbox" name="top" value=$top checked> Top is done!
    <?php
        }
        else {
    ?>
            <input type="checkbox" name="top" value=$top > Top is done!
    <?php
        }
        if ($bottom == 1){
    ?>      <input type="checkbox" name="bottom" value=$bottom checked> Bottom is done!
    <?php
        }
        else {
    ?>
            <input type="checkbox" name="bottom" value=$bottom > Bottom is done!  
    <?php
        }
    ?>

    <br>
    </div>
    <br>
    <br>
    (Please limit to  100 characters):<textarea name="note" id="note" cols=70 rows=2 style="color: #FF0000; font-size: larger;"></textarea>
    <br>
    <br>
    <input type="checkbox" name="Scrapped" value="Scrapped"> Scrapped this PCB <br>
    <br>
    <br>
    <input type="hidden" name="barcode" value="<?php echo  $barcode;?>">
    <input type="hidden" name="name" value="<?php echo  $operator;?>">
    <input type="hidden" name="model" value="<?php echo $model;?>">
    
    <input type="submit" name="submit2" style="color: #FF0000; font-size: larger;" value="Check Out">

</form>
<br>
<!--Note (Please limit to  500 characters): <textarea name="comment" rows="5" cols="80" form="usrform"></textarea>-->
<br>
<br>
<br>

<?php
    if (isset($_POST['submit6'])) {
      $issueinfo = $_Post['issue']. $_Post['topbottom']. $_Post['location'];
      echo $issueinfo;
    }

    
    
?>

</body>
</html>


