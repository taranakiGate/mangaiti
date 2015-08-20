<?php
include('database_access_param.php');

$db_link=@mysqli_connect($hostname, $dbuser, $dbpassword) or die("Unable to connect to the server!");
$dbchosen=@mysqli_select_db($db_link,$dbname) or die("Unable to connect to the database.");
$topicnumber=$_GET["t"];
$quiznumber=$_GET["q"];
$badanswer=$_GET["b"];
$date=date('Y-m-d H:i:s');
// Replace / characters with space
$badanswer = stripslashes($badanswer);
$badanswer = trim($badanswer);
if (($topicnumber)>99) 
{	
	$topicnumber=$topicnumber-100;
};
$sql = "insert into badAnswer (quizID,questionNumber,badAnswer,student,quizDate) values (".$topicnumber.",".$quiznumber.",".$badanswer.",999,'".$date."')";

//echo $starttopicnumber;
$result=@mysqli_query($db_link,$sql);
$count=@mysqli_num_rows($result);
if($count)		{
	$row = mysqli_fetch_row($result);
	//echo $row;
		{
			$result=$row[0];
		}
		};
echo $result;
mysqli_close($db_link);
?>