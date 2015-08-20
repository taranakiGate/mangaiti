<?php
include('database_access_param.php');

$db_link=@mysqli_connect($hostname, $dbuser, $dbpassword) or die("Unable to connect to the server!");
$dbchosen=@mysqli_select_db($db_link,$dbname) or die("Unable to connect to the database.");
$questionnumber=$_GET["q"];
$topicnumber=$_GET["t"];
$sql = "select * from questions where qnumber=".$questionnumber. " and quizID=".$topicnumber;
if (($topicnumber)>99) 
{	
	$topicnumber=$topicnumber-100;
	$sql = "select * from questions where qnumber=".$questionnumber. " and quizID=".$topicnumber.  " and questiontype=1";
};

$result=@mysqli_query($db_link,$sql);
$count=@mysqli_num_rows($result);
if($count)	{
	$row = mysqli_fetch_row($result);
		{
				$rightanswer=$row[2];
		}
		};
echo $rightanswer;
mysqli_close($db_link);
?>