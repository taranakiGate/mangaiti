<!doctype html>
<html> 

<head>
<div id="dom-target" style="display: none;">
    <?php
		if (isset($_GET["t"])){
			echo htmlspecialchars($_GET["t"]);
    }
	else
		{
			echo htmlspecialchars(99); 
		};
    ?>
</div>

<div id="dom-user" style="display: none;">
    <?php
	if ($_COOKIE['userid']!=''){
	$authenticatedUserID=$_COOKIE['userid'];
	echo $authenticatedUserID;
	};
    ?>
</div>

<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Fontdiner Swanky','Special Elite::latin','Share Tech Mono' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>
  
  <title>quizMe</title>
  <link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
  <div id="quizMe"></div>
  <script src="js/phaser.js"></script>
  <script type="text/javascript">
var questionNumber=1;
var div = document.getElementById("dom-target");
var myData = Math.floor(div.textContent);
var div = document.getElementById("dom-user");
var myUserID = Math.floor(div.textContent);
var topic=myData;
var quizGrade=0;
var numberOfQuestions=4;
var quizPercent=0;
var smallBoundary=150;
var answerATop=140;
var answerSpace=12;
var answerHeight=50;
var answerHeightBig=50;
var PercentNumberText="";
var answerAText="";
var answerBText="";
var answerCText="";
var answerDText="";
var HeaderText="";
var questionCountText="";
var style =         { font: '11pt Share Tech Mono', fill: 'white', align: 'left', wordWrap:   true, wordWrapWidth: 500 };
var styleSmall =    { font: '8pt Share Tech Mono', fill: 'white', align: 'left', wordWrap:    true, wordWrapWidth: 450 };
var headerStyle =   { font: '25pt Share Tech Mono', fill: 'white', align: 'center', wordWrap: true, wordWrapWidth: 350 };
var scoreStyle =    { font: '20pt Share Tech Mono', fill: 'white', align: 'center', wordWrap: true, wordWrapWidth: 350 };
var questionStyle = { font: '14pt Share Tech Mono', fill: 'white', align: 'left', wordWrap:   true, wordWrapWidth: 500 };

function answerQuiz(meAnswer,questionNo,quizType) {
	qRightAnswer=rightAnswer (quizType,questionNo);
	if (meAnswer == qRightAnswer) {
		this.quizGrade=this.quizGrade+1;
		scoreSound.play();
		}
	else {
		wrongSound.play();
		badAnswer (quizType,questionNo,meAnswer);
	};
	if (questionNo>0){
	quizPercent=quizGrade/questionNo;
	};
	scorebar.scale.x = quizPercent;	
	scorebarY.scale.x = quizPercent;
	if (quizPercent>0.5){
	if (!(scorebar.visible)){
		scoreback.visible=true;
		scorebar.visible=true;
		scorebarY.visible=false;
		};
		}
	else {
		if (!(scorebarY.visible)){
		scoreback.visible=true;
		scorebar.visible=false;
		scorebarY.visible=true;
		};
		};
	PercentNumberText=quizPercent*100;
	PercentNumberText=PercentNumberText.toFixed(2);	
	//restart game
	cleanupQuestions(quizType);
	inProgress(quizType,questionNo,quizPercent);
	}
	

function nextQuestion (topicNo,quextionNo) {
var xmlhttp =  new XMLHttpRequest();
	var url = "./php/questions.php?q="+questionNumber+"&t="+topic;
	var Questiontxt = "";
	var res;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		Questiontxt = xmlhttp.responseText;
		res = Questiontxt.split("||");
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();
	answerAText=res[2];
	answerBText=res[3];
	answerCText=res[4];
	answerDText=res[5];	
	HeaderText =   this.game.add.text(40, 45,"Question: " +res[0] , style);
	if (HeaderText._text.length>11){
		questionCountText.x=150;
		};
	QuestionText = this.game.add.text(40, 65,res[1], questionStyle);
	if (QuestionText._height>50){
		answerATop=(QuestionText._height+100);
	}
	else {
		answerATop=130;
	};
	answerA.y = answerATop-answerHeight/3;
	answerB.y = answerATop+answerHeight-answerHeight/3;
	answerC.y = answerATop+answerHeight*2-answerHeight/3;
	answerD.y = answerATop+answerHeight*3-answerHeight/3;
	if 	(answerAText.length<smallBoundary){
		AText = game.add.text(40, answerATop-answerSpace,"A. " +answerAText, style);
		}
	else {
		AText = game.add.text(40, answerATop-answerSpace,"A. " +answerAText, styleSmall);
		};
	if 	(answerBText.length<smallBoundary){
		BText = game.add.text(40, answerATop+answerHeight-answerSpace,"B. " +answerBText, style);
		}
	else {
		BText = game.add.text(40, answerATop+answerHeight-answerSpace,"B. " +answerBText, styleSmall);
		};
	if 	(answerCText.length<smallBoundary){
		CText = game.add.text(40, answerATop+answerHeight*2-answerSpace,"C. " +answerCText, style);
		}
	else {
		CText = game.add.text(40, answerATop+answerHeight*2-answerSpace,"C. " +answerCText, styleSmall);
		};
	if 	(answerDText.length<smallBoundary){
		DText = game.add.text(40, answerATop+answerHeight*3-answerSpace,"D. " +answerDText, style);
		}
	else {
		DText = game.add.text(40, answerATop+answerHeight*3-answerSpace,"D. " +answerDText, styleSmall);
		};
	PercentText = this.game.add.text(scorebar.x+2, scorebar.y+2,PercentNumberText + " %" , style);
}

function questionCount (topicNo) {
var xmlhttp =  new XMLHttpRequest();
	var url = "./php/qsum.php?t="+topicNo;
	var Questiontxt = "";
	var res;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		Questiontxt = xmlhttp.responseText;
		res = Questiontxt.split("||");
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();
	numberOfQuestions=res[0];	
	questionCountText = this.game.add.text(150, 45, "of:  " + numberOfQuestions , style);	
}

function rightAnswer (topicNo,quextionNo) {
var xmlhttp =  new XMLHttpRequest();
	var url = "./php/answers.php?q="+questionNumber+"&t="+topic;
	var Questiontxt = "";
	var res;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		Questiontxt = xmlhttp.responseText;
		res = Questiontxt.split("||");
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();		
	rightanswerText = res[0];
	return (rightanswerText);
}

function badAnswer (topicNo,questionNo,wrong) {
var xmlhttp =  new XMLHttpRequest();
	var url = "./php/badanswer.php?q="+questionNo+"&t="+topicNo+"&b='"+wrong+"'";
	var result;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		result = xmlhttp.responseText;
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();		
	return (result[0]);
}

function nameUser(myUserID) {
	var xmlhttp =  new XMLHttpRequest();
	var url = "./php/nameUser.php?u="+myUserID;
	var result;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		Usertxt = xmlhttp.responseText;
		res = Usertxt.split("||");
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();
	myName=res[2];	
	return (res[2]);
}

function inProgress(quizType,questionNo,quizPercent) {
	var xmlhttp =  new XMLHttpRequest();
	var url = "./php/inprogress.php?n="+questionNo+"&t="+quizType+"&u="+myUserID+"&s="+PercentNumberText;
	var result;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		result = xmlhttp.responseText;
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();		
	return (result[0]);
}

function saveFinalGrade(PercentNumberText,topicNo) {
	var xmlhttp =  new XMLHttpRequest();
	var url = "./php/finalscore.php?t="+topicNo+"&s="+PercentNumberText+"&u="+myUserID;
	var result;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		result = xmlhttp.responseText;
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();			
	return (result[0]);
}

function cleanupQuestions(quizType) {
	HeaderText.destroy();
	QuestionText.destroy();
	AText.destroy();
	BText.destroy();
	CText.destroy();
	DText.destroy();
	questionNumber=questionNumber+1;
	if (questionNumber>numberOfQuestions) {
		endGame();
	}
	else {
		PercentText.destroy();
		nextQuestion(quizType,questionNumber);
	};
	
}

function endGame() {
	answerA.inputEnabled = false;
	answerA.visible = false;
	answerB.inputEnabled = false;
	answerB.visible = false;
	answerC.inputEnabled = false;
	answerC.visible = false;
	answerD.inputEnabled = false;
	answerD.visible = false;
	questionCountText.destroy();
	quizbackground.destroy();
	scoreback.visible=false; 
	scorebar.visible=false; 
	scorebarY.visible=false; 
	PercentText.destroy();


	nameUser(myUserID);
	NameText=myName;
	TopicSum=topicTxt;
	DateTakenText=new Date();
	curr_date = DateTakenText.getDate();
    curr_month = DateTakenText.getMonth() + 1; //Months are zero based
    curr_year = DateTakenText.getFullYear();
    DateTakenText=(curr_date + "-" + curr_month + "-" + curr_year);
	
	userSum = 		game.add.text(150, 100,'User :   '+NameText, scoreStyle);
	topicSum = 		game.add.text(150, 130,'Topic:   '+TopicSum, scoreStyle);
	finalGrade = 	game.add.text(150, 160,'Grade:   '+PercentNumberText+ "%", scoreStyle);
	quizDate = 		game.add.text(150, 190,'Date :   '+DateTakenText, scoreStyle);
	saveFinalGrade(PercentNumberText,topic);
};

function showTimer() {
    this.ready = true;
  };
  
var game = new Phaser.Game(600, 600, Phaser.AUTO, 'quizMe',{ preload: preload, create: create, play: play,update: update });

function preload() {
	this.game.scale.pageAlignHorizontally = true;
	this.game.scale.pageAlignVertically = true;
	this.game.scale.refresh();
	this.load.image('background', 'assets/simple_blue.png');
	this.load.image('ground', 'assets/ticker.jfif');
	this.load.image('green', 'assets/green.png');
	this.load.image('yellow', 'assets/yellow.png');
	this.load.image('goodops', 'assets/goodops.png');
	this.load.image('quizbackground', 'assets/simple_blue_small.png');
	this.load.image('scorebar','assets/scorebarG.png');
	this.load.image('scorebarY','assets/scorebarY.png');
	this.load.image('scoreback','assets/scoreBack.png');
	this.load.image('help', 'assets/help.png');
    this.load.audio('wrong', 'assets/wrong.wav');
    this.load.audio('score', 'assets/score.wav');
	this.load.audio('gameover', 'assets/gameover.wav');
}


function create() {
	var Ground = function(game, x, y, width, height) {
	Phaser.TileSprite.call(this, game, x, y, width, height, 'ground');
	this.autoScroll(-200,0); 
	};
	 // add the ticker background sprite
    this.background = this.game.add.sprite(0,0,'background');
    this.ground = this.game.add.tileSprite(0,500, 601,112,'ground');
    this.ground.autoScroll(-200,0);
	greenBack = this.game.add.sprite(140,80,'green');
	greenBack.visible=false;
	yellowBack = this.game.add.sprite(140,80,'yellow');
	yellowBack.visible=false;
	this.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL ;
	this.scale.minWidth =  500;
	this.scale.minHeight = 500;
	this.scale.maxWidth =  600;
	this.scale.maxHeight = 600;
	this.game.scale.pageAlignHorizontally = true;
	this.game.scale.pageAlignVertically = true;
	this.game.scale.refresh();
	this.scale.refresh();
	this.play();
	}
	

function play() {
	
	var xmlhttp =  new XMLHttpRequest();
	var url = "./php/topic.php?q=1&t="+topic;
	var Questiontxt = "";
	var res;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		topicTxt = xmlhttp.responseText;
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();
	
	this.TopicText = this.game.add.text(this.game.width/2-topicTxt.length*7, 5,topicTxt,headerStyle);
	if (topicTxt == "no matching topic exists") {
		var endGame;
		endGame=true;
	};
	
	if (!endGame) {
	//Load first question
	var url = "./php/questions.php?q=1&t="+topic;
	var Questiontxt = "";
	var res;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		Questiontxt = xmlhttp.responseText;
		res = Questiontxt.split("||");
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();

	quizbackground = this.add.sprite(30,90,'quizbackground');	
	answerAText=res[2];
	answerBText=res[3];
	answerCText=res[4];
	answerDText=res[5];
	HeaderText = this.game.add.text(40, 45,"Question: 1" , style);
	QuestionText = this.game.add.text(40, 65,res[1], questionStyle);
	if (QuestionText._height>50){
		answerATop=(QuestionText._height+100);
	}
	else {
		answerATop=130;
	};
	answerA = this.add.sprite(35,answerATop-answerHeight/3,'goodops');
	answerA.inputEnabled = true;
	answerA.input.useHandCursor = true;
	answerB = this.add.sprite(35,answerATop+answerHeight-answerHeight/3,'goodops');
	answerB.inputEnabled = true;
	answerB.input.useHandCursor = true;
	answerC = this.add.sprite(35,answerATop+answerHeight*2-answerHeight/3,'goodops');
	answerC.inputEnabled = true;
	answerC.input.useHandCursor = true;
	answerD = this.add.sprite(35,answerATop+answerHeight*3-answerHeight/3,'goodops');
	answerD.inputEnabled = true;
	answerD.input.useHandCursor = true;
	if 	(answerAText.length<smallBoundary){
		AText = game.add.text(40, answerATop-answerSpace,"A. " +answerAText, style);
		}
	else {
		AText = game.add.text(40, answerATop-answerSpace,"A. " +answerAText, styleSmall);
		};
	if 	(answerBText.length<smallBoundary){
		BText = game.add.text(40, answerATop+answerHeight-answerSpace,"B. " +answerBText, style);
		}
	else {
		BText = game.add.text(40, answerATop+answerHeight-answerSpace,"B. " +answerBText, styleSmall);
		};
	if 	(answerCText.length<smallBoundary){
		CText = game.add.text(40, answerATop+answerHeight*2-answerSpace,"C. " +answerCText, style);
		}
	else {
		CText = game.add.text(40, answerATop+answerHeight*2-answerSpace,"C. " +answerCText, styleSmall);
		};
	if 	(answerDText.length<smallBoundary){
		DText = game.add.text(40, answerATop+answerHeight*3-answerSpace,"D. " +answerDText, style);
		}
	else {
		DText = game.add.text(40, answerATop+answerHeight*3-answerSpace,"D. " +answerDText, styleSmall);
		};
	PercentText = this.game.add.text(2,2,PercentNumberText, style);
	answerA.events.onInputDown.add(function() { answerQuiz(answerAText,questionNumber,topic);});
	answerB.events.onInputDown.add(function() { answerQuiz(answerBText,questionNumber,topic);});
	answerC.events.onInputDown.add(function() { answerQuiz(answerCText,questionNumber,topic);});
	answerD.events.onInputDown.add(function() { answerQuiz(answerDText,questionNumber,topic);});

	scoreback = game.add.sprite(220,45,'scoreback');
	scoreback.visible=false;
	scorebar = game.add.sprite(222,45,'scorebar');
	scorebar.visible=false;
	scorebarY = game.add.sprite(222,45,'scorebarY');
	scorebarY.visible=false;
	questionCount (topic);
	scoreSound = this.game.add.audio('score');
	wrongSound = this.game.add.audio('wrong');
}
}
	function update() {

}
  </script>
</body>
</html>