<?php
include('database_access_param.php');

$db_link=@mysqli_connect($hostname, $dbuser, $dbpassword) or die("Unable to connect to the server!");
$dbchosen=@mysqli_select_db($db_link,$dbname) or die("Unable to connect to the database.");

$questionnumber=$_GET["q"];
$topicnumber=$_GET["t"];
$sql = "select * from questions where qnumber=".$questionnumber. " and quizID=".$topicnumber;
if (($topicnumber)>99) 
{	
	$newtopic=$topicnumber-100;
	$sql = "select * from questions where qnumber=".$questionnumber. " and quizID=".$newtopic.  " and questiontype=1";
};


$result=@mysqli_query($db_link,$sql);
$count=@mysqli_num_rows($result);
if($count)	{
	$row = mysqli_fetch_row($result);		
	$qid=$row[0];
	$question=$row[1];
	$answers[0]=$row[2];
	$answers[1]=$row[3];
	$answers[2]=$row[4];
	$answers[3]=$row[5];
	$qnumber=$row[6];
	$rightanswer=$row[2];
	srand((float) microtime() * 80000000);
	$rand_keys = array_rand($answers,4);
	
	shuffle($answers);
	$answer0=$answers[$rand_keys[3]] ;
	$answer1=$answers[$rand_keys[2]] ;
	$answer2=$answers[$rand_keys[1]] ;
	$answer3=$answers[$rand_keys[0]] ;
			}
else 		{
	$qnumber=0;
	$question='there are no questions for this topic';
	$answer0='';
	$answer1='';
	$answer2='';
	$answer3='';
			};

echo $qnumber;
echo "||";
echo $question;
echo "||";
echo $answer0;
echo "||";
echo $answer1;
echo "||";
echo $answer2;
echo "||";
echo $answer3;
$close=@mysqli_close($db_link);
?>