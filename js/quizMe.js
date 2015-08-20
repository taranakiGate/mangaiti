var questionNumber=1;
var topic=99;
//var topic=0;
var quizGrade=0;
var numberOfQuestions=4;
var quizPercent=0;
var smallBoundary=60;
var answerATop=140;
var answerHeight=50;
var answerHeightBig=50;
var PercentNumberText="";
var answerAText="";
var answerBText="";
var answerCText="";
var answerDText="";
var style = { font: '10pt Pragmata', fill: 'white', align: 'left', wordWrap: true, wordWrapWidth: 380 };
var styleSmall = { font: '8pt Pragmata', fill: 'white', align: 'left', wordWrap: true, wordWrapWidth: 400 };
var headerStyle = { font: '25pt Pragmata', fill: 'white', align: 'left', wordWrap: true, wordWrapWidth: 350 };
var questionStyle = { font: '11pt Pragmata', fill: 'white', align: 'left', wordWrap: true, wordWrapWidth: 385 };


function answerQuiz(meAnswer,questionNo,quizType) {
	qRightAnswer=rightAnswer (quizType,questionNo);
	if (meAnswer == qRightAnswer) {
		this.quizGrade=this.quizGrade+1;
		scoreSound.play();
		}
	else {
		wrongSound.play();
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
	}
	


function nextQuestion (topicNo,quextionNo) {
var xmlhttp =  new XMLHttpRequest();
	var url = "./php/questions.php?q="+questionNumber+"&t="+topic;
	//var url = "http://localhost/quizMe/php/README.txt";
	var Questiontxt = "";
	var res;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		console.log("Here...");
		console.log(xmlhttp.responseText);
		Questiontxt = xmlhttp.responseText;
		res = Questiontxt.split("||");
		console.log(res[0]);
		console.log(res[1]);
		console.log(res[2]);
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();
	//////	
			answerAText=res[2];
			answerBText=res[3];
			answerCText=res[4];
			answerDText=res[5];		
			HeaderText = this.game.add.text(40, 45,"Question: " +res[0] , style);
			QuestionText = this.game.add.text(40, 65,res[1], questionStyle);
		if 	(answerAText.length<smallBoundary){
				AText = game.add.text(40, answerATop,"A. " +answerAText, style);
				}
			else {
				AText = game.add.text(40, answerATop,"A. " +answerAText, styleSmall);
				};
			if 	(answerBText.length<smallBoundary){
				BText = game.add.text(40, answerATop+answerHeight,"B. " +answerBText, style);
				}
			else {
				BText = game.add.text(40, answerATop+answerHeight,"B. " +answerBText, styleSmall);
				};
			if 	(answerCText.length<smallBoundary){
				CText = game.add.text(40, answerATop+answerHeight*2,"C. " +answerCText, style);
				}
			else {
				CText = game.add.text(40, answerATop+answerHeight*2,"C. " +answerCText, styleSmall);
				};
			if 	(answerDText.length<smallBoundary){
				DText = game.add.text(40, answerATop+answerHeight*3,"D. " +answerDText, style);
				}
			else {
				DText = game.add.text(40, answerATop+answerHeight*3,"D. " +answerDText, styleSmall);
				};
		
			PercentText = this.game.add.text(scorebar.x+2, scorebar.y+2,PercentNumberText + " %" , style);
}

function questionCount (topicNo) {
var xmlhttp =  new XMLHttpRequest();
	var url = "./php/qsum.php?t="+topic;
	//var url = "http://localhost/quizMe/php/README.txt";
	var Questiontxt = "";
	var res;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		console.log("Here...");
		console.log(xmlhttp.responseText);
		Questiontxt = xmlhttp.responseText;
		res = Questiontxt.split("||");
		console.log(res[0]);
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();
	//////
	numberOfQuestions=res[0];	
	questionCount = this.game.add.text(118, 45, "of: " + numberOfQuestions , style);
	
		
}

function rightAnswer (topicNo,quextionNo) {
var xmlhttp =  new XMLHttpRequest();
	var url = "./php/answers.php?q="+questionNumber+"&t="+topic;
	//var url = "http://localhost/quizMe/php/README.txt";
	var Questiontxt = "";
	var res;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		console.log("Here...");
		console.log(xmlhttp.responseText);
		Questiontxt = xmlhttp.responseText;
		res = Questiontxt.split("||");
		console.log(res[0]);
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();
	//////			
	rightanswerText = res[0];
	return (rightanswerText);
}

function cleanupQuestions(quizType) {
	HeaderText.destroy();
	QuestionText.destroy();
	AText.destroy();
	BText.destroy();
	CText.destroy();
	DText.destroy();
	questionNumber=questionNumber+1;
	if (questionNumber>numberOfQuestions){
	//if (questionNumber>2){
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
	//answerA.destroy();
	answerB.inputEnabled = false;
	answerB.visible = false;
	//answerB.destroy();
	answerC.inputEnabled = false;
	answerC.visible = false;
	//answerC.destroy();
	answerD.inputEnabled = false;
	answerD.visible = false;
	//answerD.destroy();
	questionCount.destroy();
	quizbackground.destroy();
	scoreback.visible=false; 
	scorebar.visible=false; 
	scorebarY.visible=false; 
	PercentText.destroy();

	if (PercentNumberText>50){
	greenBack.visible=true;
	yellowBack.visible=false;
	}
	else {
	greenBack.visible=false;
	yellowBack.visible=true;
	};
	finalGrade = game.add.text(200, 160,PercentNumberText+ "%", headerStyle);
	//finalGrade = game.add.bitmapText(40, 120, PercentNumberText, 30);
};
function showTimer() {
    this.ready = true;
  };
  
var game = new Phaser.Game(500, 500, Phaser.AUTO, 'quizMe',{ preload: preload, create: create, play: play,update: update });


function preload() {
  
    this.load.image('background', 'assets/stock_market_generic.png');
	this.load.image('ground', 'assets/ticker.jfif');
    this.load.image('title', 'assets/title.png');
	this.load.image('bond', 'assets/bondsampleSM.png');
	this.load.image('stock', 'assets/bondsampleSM.png');
	this.load.image('goodprice', 'assets/goodprice.png');
	this.load.image('green', 'assets/green.png');
	this.load.image('yellow', 'assets/yellow.png');
	this.load.image('goodops', 'assets/goodops.png');
	this.load.image('badprice', 'assets/badprice.png');
	this.load.image('backdrop', 'assets/backdrop.png');
	this.load.image('details', 'assets/darkgray.png');
	this.load.image('progress', 'assets/progress.png');
	this.load.image('monthprogress', 'assets/monthprogress.png');
	this.load.image('daygap', 'assets/daygap.png');
	this.load.image('daybackground', 'assets/dayBackground.png');
	this.load.image('quizbackground', 'assets/quizbackground.png');
	this.load.image('scorebar','assets/scorebarG.png');
	this.load.image('scorebarY','assets/scorebarY.png');
	this.load.image('scoreback','assets/scoreBack.png');
	this.load.image('intro', 'assets/intro.png');
	this.load.image('monthEnd', 'assets/monthEnd.png');
	this.load.image('reconAnswer', 'assets/reconAnswer.png');
	this.load.image('resolveColor', 'assets/reconcilecolor.png');
	this.load.image('dayEnd', 'assets/dayEnd.png');
	this.load.spritesheet('startButton', 'assets/startbuttonspritesheet.png', 110,65);
	this.load.spritesheet('restartButton', 'assets/restartspritesheet.png', 110,65);
    this.load.image('instructions', 'assets/instructions.png');
    this.load.image('getReady', 'assets/get-ready.png');
    this.load.image('scoreboard', 'assets/scoreboard.png');
    this.load.spritesheet('medals', 'assets/medals.png',44, 46, 2);
	this.load.image('goodgame', 'assets/checkmark.gif');
	this.load.image('badgame', 'assets/cross.gif');
    this.load.image('gameover', 'assets/gameover1.png');
	this.load.image('reconbackground', 'assets/greenbar.png');
	this.load.image('break', 'assets/reconbreak.png');
    this.load.image('particle', 'assets/particle.png');
	this.load.image('reconhelp', 'assets/help.png');
    this.load.audio('wrong', 'assets/wrong.wav');
    this.load.audio('bigwrong', 'assets/bigwrong.wav');
    this.load.audio('score', 'assets/score.wav');
	this.load.audio('gameover', 'assets/gameover.wav');
    this.load.audio('ouch', 'assets/ouch.wav');
    this.load.bitmapFont('squarefont', 'assets/fonts/tradeMefont/squarefont.png', 'assets/fonts/tradeMefont/squarefont.fnt');
	this.load.bitmapFont('tradeMefont', 'assets/fonts/nokia/nokia16.png', 'assets/fonts/nokia/nokia16.xml');
	this.load.bitmapFont('numbers', 'assets/fonts/numbers/numbers2.png', 'assets/fonts/numbers/numbers2.fnt');
}


function create() {
	var Ground = function(game, x, y, width, height) {
	Phaser.TileSprite.call(this, game, x, y, width, height, 'ground');
	// start scrolling our ground
	this.autoScroll(-200,0); 
	// enable physics on the ground sprite
	// this is needed for collision detection
	this.game.physics.arcade.enableBody(this);
	// we don't want the ground's body
	// to be affected by gravity or external forces
	this.body.allowGravity = false;
	this.body.immovable = true;
	};
	 // add the background sprite
    this.background = this.game.add.sprite(0,0,'background');
    // add the ground sprite as a tile
    // and start scrolling in the negative x direction
    this.ground = this.game.add.tileSprite(0,400, 501,112,'ground');
    this.ground.autoScroll(-200,0);
	greenBack = this.game.add.sprite(140,80,'green');
	greenBack.visible=false;
	yellowBack = this.game.add.sprite(140,80,'yellow');
	yellowBack.visible=false;
	this.play();
	}
	


function play() {
	
	var xmlhttp =  new XMLHttpRequest();
	var url = "./php/topic.php?q=1&t="+topic;
	//var url = "http://localhost/quizMe/php/README.txt";
	var Questiontxt = "";
	var res;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		console.log("topic...");
		console.log(xmlhttp.responseText);
		topicTxt = xmlhttp.responseText;
		console.log(res[0]);
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();
	
	this.TopicText = this.game.add.text(155, 5,topicTxt,headerStyle);
	
	var url = "./php/questions.php?q=1&t="+topic;
	//var url = "http://localhost/quizMe/php/README.txt";
	var Questiontxt = "";
	var res;
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		console.log("Here...");
		console.log(xmlhttp.responseText);
		Questiontxt = xmlhttp.responseText;
		res = Questiontxt.split("||");
		console.log(res[0]);
		console.log(res[1]);
		console.log(res[2]);
		}
	  };
	xmlhttp.open("GET",url,false);
	xmlhttp.send();
	//////
			quizbackground = this.add.sprite(30,90,'quizbackground');
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
			
			
			answerAText=res[2];
			answerBText=res[3];
			answerCText=res[4];
			answerDText=res[5];
			//wideMouthFrog='xxxxxxxxxxxxxxxxxxxxxxxxxxx xxxxxxxxxxxxxx xxxxxxxxxxxxxxxxxxxxxxxx xxxxxxxxxxxxxxxxx xxxxxxxxxx'
			
			HeaderText = this.game.add.text(40, 45,"Question: 1" , style);
			QuestionText = this.game.add.text(40, 65,res[1], questionStyle);
			if 	(answerAText.length<smallBoundary){
				AText = game.add.text(40, answerATop,"A. " +answerAText, style);
				}
			else {
				AText = game.add.text(40, answerATop,"A. " +answerAText, styleSmall);
				};
			if 	(answerBText.length<smallBoundary){
				BText = game.add.text(40, answerATop+answerHeight,"B. " +answerBText, style);
				}
			else {
				BText = game.add.text(40, answerATop+answerHeight,"B. " +answerBText, styleSmall);
				};
			if 	(answerCText.length<smallBoundary){
				CText = game.add.text(40, answerATop+answerHeight*2,"C. " +answerCText, style);
				}
			else {
				CText = game.add.text(40, answerATop+answerHeight*2,"C. " +answerCText, styleSmall);
				};
			if 	(answerDText.length<smallBoundary){
				DText = game.add.text(40, answerATop+answerHeight*3,"D. " +answerDText, style);
				}
			else {
				DText = game.add.text(40, answerATop+answerHeight*3,"D. " +answerDText, styleSmall);
				};

			//PercentText = this.game.add.bitmapText(2,2, 'tradeMefont',PercentNumberText, 14);
			PercentText = this.game.add.text(2,2,PercentNumberText, style);
			answerA.events.onInputDown.add(function() { answerQuiz(answerAText,questionNumber,topic);});
			answerB.events.onInputDown.add(function() { answerQuiz(answerBText,questionNumber,topic);});
			answerC.events.onInputDown.add(function() { answerQuiz(answerCText,questionNumber,topic);});
			answerD.events.onInputDown.add(function() { answerQuiz(answerDText,questionNumber,topic);});
			//var scorebar = this.game.add.sprite(0,0,'scorebar');
			scoreback = game.add.sprite(80,answerATop+answerHeight*4,'scoreback');
			scoreback.visible=false;
			scorebar = game.add.sprite(82,answerATop+answerHeight*4+2,'scorebar');
			scorebar.visible=false;
			scorebarY = game.add.sprite(82,answerATop+answerHeight*4+2,'scorebarY');
			scorebarY.visible=false;
			questionCount (topic);
			//this.Countdown = this.game.time.events.loop(Phaser.Timer.SECOND * 1/2, showTimer, this);
			//this.Countdown.timer.start();
			scoreSound = this.game.add.audio('score');
			wrongSound = this.game.add.audio('wrong');
 
}

	function update() {

}