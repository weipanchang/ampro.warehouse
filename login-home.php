<?PHP

require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}


$_SESSION['username'] = $fgmembersite->UserFullName();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Home page</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css">
</head>
<body>
<div id='fg_membersite_content'>
<h2>Home Page</h2>
Welcome back <?= $fgmembersite->UserFullName(); ?>!

<li><p><a href='change-pwd.php'>Change password</a></p></li>
<HR WIDTH="100%" COLOR="#6699FF" SIZE="6">
<li><a href='WOE.php' style="color:blue"> Input Warehouse Contract Manufacture Order</a></li>
<li><a href='Search_by_Model.php' style="color:blue"> Search Warehouse Contract Manufacture Order by Model</a></li>
<li><a href='Search_by_Date.php' style="color:blue"> Search Warehouse Contract Manufacture Order by Date</a></li>
<li><a href='delete_wo.php' style="color:blue"> Delete Warehouse Contract Manufacture Order</a></li>
<br><br><br>
<p><a href='logout.php'>Logout</a></p>
</div>
</body>
</html>
