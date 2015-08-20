<?php

include('database_access_param.php');

$db_link=@mysqli_connect($hostname, $dbuser, $dbpassword) or die("Unable to connect to the server!");
$dbchosen=@mysqli_select_db($db_link,$dbname) or die("Unable to connect to the database.");

$topicnumber=$_GET["t"];
$sql = "select name from quiz where id=".$topicnumber;
if (($topicnumber)>99) 
{	
	$newtopic=$topicnumber-100;
	$sql = "select name from quiz where id=".$newtopic;
};

$result=@mysqli_query($db_link,$sql);
$count=@mysqli_num_rows($result);
if($count)		{
	$row = mysqli_fetch_row($result);
	$topic=$row[0];
	}
else{
	$topic='no matching topic exists';
	};	
echo strtolower($topic);
$close=@mysqli_close($db_link);
?>