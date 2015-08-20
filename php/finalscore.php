<?php
include('database_access_param.php');

$db_link=@mysqli_connect($hostname, $dbuser, $dbpassword) or die("Unable to connect to the server!");
$dbchosen=@mysqli_select_db($db_link,$dbname) or die("Unable to connect to the database.");

$topicnumber=$_GET["t"];
$score=$_GET["s"];
$userid=$_GET["u"];
$date=date('Y-m-d H:i:s');
if (($topicnumber)>99) 
{	
	$topicnumber=$topicnumber-100;
};
$sql = "insert into grade (studentID,grade,quizID,quizDate) values (".$userid.",".$score.",".$topicnumber.",'".$date."')";
$result=@mysqli_query($db_link,$sql);
$count=@mysqli_num_rows($result);
if($count)	{
	$row = mysqli_fetch_row($result);
		{
			$result=$row[0];
		}
		};
echo $result;
$close=@mysqli_close($db_link);
?>