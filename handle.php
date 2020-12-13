<?php
	require "connect.php";
	if(isset($_POST['content']))
	{
		$content=$_POST['content'];
		$sql = "insert into requests values(NULL,'".$_SESSION['user']."','".$content."')";
		$result = mysqli_query($conn, $sql);
	}
	$i=0;
	$sql="select previous,question,answer from users where username='".$_SESSION['user']."'";
	while(1)
	{
		$result=mysqli_query($conn,$sql);
		$row = $result -> fetch_assoc();
		if(trim($row['answer'])!="")
		{
			$answer=$row['answer'];
			$question=$row['question'];
			$previous=$row['previous'];
			break;
		}
		$i+=1;
	}
	$updated=$previous.$question."~".$answer."|";
	$sql="update users set previous='{$updated}' where username='{$_SESSION['user']}'";
	$result=mysqli_query($conn,$sql);
	$sql="update users set answer='',question='' where username='{$_SESSION['user']}'";
	$result=mysqli_query($conn,$sql);
	echo $answer;
?>