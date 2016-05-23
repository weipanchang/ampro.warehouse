<?php
    include ("Ampro_EAN13.php");
    require_once("connMysql.php");
    date_default_timezone_set('America/Los_Angeles');
    //echo (getdate()['year']);
    //$year = substr(getdate()['year'],2,2);
    //echo $year;
    $mday= getdate()['mday'];
    echo $mday;
    if (strlen($mday) == 1) {
        $mday = "0".$mday;
    }
    echo "<br>";
    $mon= getdate()['mon'];
    if (strlen($mon) == 1) {
        $mon = "0".$mon;
    }
    //echo $mon;

    $today = substr(getdate()['year'],2,2).$mon.getdate()['mday'];
    echo $today;
    echo "<br>";
    $con=mysql_connect($db_host,$db_username,$db_password);
    mysql_select_db($db_name);
    $sql = "SELECT * FROM `PCB_Barcode` WHERE `barcode` like '$today%' order by barcode DESC";
    //$result = true;
    $result=mysql_query($sql, $con);
    $rowcount=mysql_num_rows($result);
    if ($rowcount == 0) {
        //echo "in there";
        $start_barcode = 10000;
    }
    else{
        //echo "in here";
        $row=mysql_fetch_array($result);
        $start_barcode = (((int)substr($row['barcode'], 6, 2)) + 1) * 1000 ;
    }
    
    echo $start_barcode;
    

?>