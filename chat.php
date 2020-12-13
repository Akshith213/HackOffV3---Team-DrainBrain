<?php
require 'connect.php';
if(empty($_SESSION['user'])){
	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Health Care Chatbot</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	</head>
	<style type="text/css">
		html,body {
		margin: 0px;
		padding: 0px;
		}
		body,html {
		height: 100vh;
		width: 100vw;
		}
		* {
		box-sizing: border-box;
		margin: 0px;
		padding: 0px;
		}
		.leftscreen,.rightarea{
			height: 100vh;
		}
		.mainarea{
			height: 90vh;
			overflow: auto;
		}
		.chat{
			width: 100%;
			height: 11%;
			padding: 10px;
		}
		.sen{
			float: right;
			width: 60%;
			background-color: aqua;
			margin: 10px;
			padding: 20px;
			border-radius: 20px 0px 20px 20px;
			color: white;
			font-weight:bold;
		}
		.rec{
			float: left;
			width: 60%;
			border: solid aqua 3px;
			background-color: white;
			margin: 10px;
			padding: 20px;
			border-radius: 0px 20px 20px 20px;
		}
		.chatarea{
			background-color: #353a40;
			/*border: solid black 2px ;*/
			height: 10vh;
			padding-right: 10px;
			padding-left: 10px;
			color: white;
		}
		.enterchat{
			margin: 10px;
			width: 80%;
			padding: 10px;
		}
		.btn{
			margin: 10px;
			width: 10%;
			background-color: green;
		}
		.ico{
			font-size: 2rem;
			color: white;
		}
		.inp-cont{
			margin-top: 10px;
			margin-bottom: 10px;
		}
		.but{
			background-color: transparent;
			border-style: none;
		}
		.but:focus{
			outline: none;
		}
		.mainarea::-webkit-scrollbar {
		display: none;
		}
		.mainarea {
		-ms-overflow-style: none;
		scrollbar-width: none;
		}
		.strip{
			height: 5px;
			background-color: red;
			width: 10vw;
		}
		td{
			padding: 10px;
			border:3px solid white;
		}
		tr{
			border:3px solid white;	
		}
		.card{
			background-color: #353a40;
			padding: 10px;
			font-size: 20px;
			color: white;
			border-radius: 10px 0px 0px 10px;
		}
		.scrollarea{
			overflow: auto;
			height: 80vh;
			padding:10px 0px 10px 10px;
		}
		.profile{
			height: 10vh;
			background-color: #353a40;
			position: fixed;
		    bottom: 0px;
		    left: 0px;
		    width: 100%;
		    padding: 0px;
		}
	</style>
	<body style="font-family: sans-serif;">
		<div class="container-fluid">
			<div class="row">
				<div class="leftscreen col-sm-3" style="background-color:aqua;">
					<div class="scrollarea">
						<div class="card">
							Default Bot
						</div>
					</div>
					<div class="profile row chatarea">
						<img class="align-middle" style="width: auto;height: 100%;margin-left: 15px;" src="profile.jpg">
						<p class="align-middle" style="font-size:30px;"><?php echo $_SESSION['user']?></p>
						<i class="fa fa-gear ico align-middle"></i>
					</div>
				</div>
				<div class="rightscreen col-sm-9" style="background-color:white;">
					<div class="mainarea" id="mainarea">
						<?php
							$sql="select previous from users where username='{$_SESSION['user']}'";
							$result=mysqli_query($conn,$sql);
							$row=$result->fetch_assoc();
							$arr=explode("|",$row['previous']);
							for($i=0;$i<count($arr)-1;$i++){ 
								$x=explode("~",$arr[$i]);
								$ar=explode("@",$x[1]);
								$ans="<table class='table-dark'>";
								for ($i=0;$i<count($ar)-1;$i++){ 
									$sub=explode(";",$ar[$i]);
				            		if($i==count($ar)-2){
				            			$ans.="<tr><td rowspan=3>Ans:".($i+1)."</td><td>Answer:</td><td>".$sub[0]."</td></tr><tr><td>Context:</td><td>".$sub[1]."</td></tr> <tr><td>Probability:</td><td>".$sub[2]."</td></tr>";
				            		}
				            		else{
				            			$ans.="<tr><td rowspan=3>Ans:".($i+1)."</td><td>Answer</td><td>".$sub[0]."</td></tr>  <tr><td>Context</td><td>".$sub[1]."</td></tr> <tr><td>Probability</td><td>".$sub[2]."</td></tr>";
				            		}
								}
								$ans.="</table>";
								echo "<div class='sen'>".$x[0]."</div>";
								echo "<div class='rec'>".$ans."</div>";
							}
						?>
					</div>
					<div>
						<form class="chatarea row text-center">
							<button onclick="runSpeechRecognition()" class="col-1 but text-center" type="button">
								<i id="normal" class="fa fa-microphone ico inp-cont"></i>
								<div id="record" style="display: none;" class="spinner-grow text-danger inp-cont" role="status">
									<span class="sr-only"></span>
								</div>
							</button>
							<input type="text" placeholder="Type a message" name="content" class="rounded col-10 inp-cont" id="chat">
							<button type="submit" class="col-1 but" onclick="return add()">
								<i class="fa fa-send ico inp-cont"></i>
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			document.getElementById('mainarea').scrollTop=9999999;
		</script>
	</body>
	<script type="text/javascript">

		function chk(){
	        var content="content="+document.getElementById('chat').value;
	        $.ajax({
	            type: 'POST',
	            url: 'handle.php',
	            data: content,
	            success: function(data) {
	            	var arr=data.split("@");
	            	var ans="";
	            	for (var i=0;i<arr.length-1;i++){
	            		var sub=arr[i].split(";");
	            		if(i==arr.length-2){
	            			ans+="Answer: "+sub[0]+"<br>Context: "+sub[1]+"<br>Probability: "+sub[2];
	            		}
	            		else{
	            			ans+="Answer: "+sub[0]+"<br>Context: "+sub[1]+"<br>Probability: "+sub[2]+"<br><hr>";
	            		}
	            	}
	            	var prev=document.getElementById('mainarea').innerHTML;
	            	var fin='<div class="chat"><div class="rec">'+ans+'</div></div>';
	                $('#mainarea').html(prev+fin);
	            }
	        });
	    }

		function add()
		{
			chk();
			var pointer=document.getElementById('chat');
			var data=pointer.value;
			pointer.value="";
			if(data.trim()!="")
			{
				document.getElementById('mainarea').innerHTML+='<div class="chat"><div class="sen">'+data+'</div></div>';
			}
			document.getElementById('mainarea').scrollTop = 9999999;
			return false;
		}
		function runSpeechRecognition() {
			var output = document.getElementById("output");
			var action = document.getElementById("action");
			var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
			var recognition = new SpeechRecognition();
			recognition.onstart = function() {
					document.getElementById('normal').style.display="none";
					document.getElementById('record').style.display="block";		
				};
				recognition.onspeechend = function() {
				recognition.stop();
				document.getElementById('normal').style.display="block";
					document.getElementById('record').style.display="none";
				}
				recognition.onresult = function(event) {
				var transcript = event.results[0][0].transcript;
				var confidence = event.results[0][0].confidence;
				document.getElementById('chat').value=transcript;
				if(transcript.trim()!="")
				{
					add();
				}
			};
			recognition.start();
		}
	</script>
</html>

<?php
	// echo $_SESSION['answer'];
	// echo $_SESSION['user'];	
?>