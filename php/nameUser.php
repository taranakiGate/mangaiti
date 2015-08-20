<?php
include('database_access_param.php');

$db_link=@mysqli_connect($hostname, $dbuser, $dbpassword) or die("Unable to connect to the server!");
$dbchosen=@mysqli_select_db($db_link,$dbname) or die("Unable to connect to the database.");

$usernumber=$_GET["u"];


$sql = "select * from students where stid=".$usernumber;
$result=@mysqli_query($db_link,$sql);
$count=@mysqli_num_rows($result);
if($count)	{
	$row = mysqli_fetch_row($result);		
	$firstname  =$row[1];
	$lastname   =$row[2];
	$username   =$row[3];
			}
else 		{
	$firstname  ='';
	$lastname   ='';
	$username   ='';
			};
echo $firstname;
echo "||";
echo $lastname;
echo "||";
echo $username;

$close=@mysqli_close($db_link);
?>