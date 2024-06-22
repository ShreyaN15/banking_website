<?php 
$dbservername = "localhost"; 
$dbusername = "root"; 
$dbpassword = ""; 
$dbname = "test"; 
$con = mysqli_connect($dbservername,$dbusername,$dbpassword,$dbname); 
if(mysqli_connect_errno()) 
{ 
echo "<div style='color:#fff;'>not connected</div>"; 
} 
else 
{ 
echo "<div style='color:#fff;'>connected</div>"; 
} 
?>