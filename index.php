<?php 
require_once "connect.php";

if(!empty($_SESSION['user'])){
    header('Location: chat.php');
  die();
}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HackOff</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
    <conn href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <conn rel="stylesheet" href="css/login.css">
    <style type="text/css">
      html,body
      {
        background-color: black;
        animation: mymove 15s infinite;
      }
      @keyframes mymove {
        0% {background-color: black;}
        25%{background-color: #1f3057;}
        50%{background-color: #757639;}
        75%{background-color: #3b3629;}
        100% {background-color: #676f76;}
      }
    </style>
</head>

<body>
  <div class="container" style="margin-top: 5%;">
    <?php
    if(isset($_SESSION['invalid']) && !empty($_SESSION['invalid'])){
      echo "<p style='color:red; text-align:center; font-size:17px;'>
       Wrong Username or Password.</p>";
       unset($_SESSION['invalid']);
    }
     ?>

    <form role="form" method="post" action="loginCheck.php">
        <input class="form-control" id="username" type="text" name="username" placeholder="Username" required/>
        <input class="form-control" id="password" type="password" name="password" placeholder="Password" required/>
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
  </div>
</body>

</html>
