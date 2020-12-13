<?php
require_once 'connect.php';

$flag=0;
if(isset($_POST['username']))
{
    $flag=1;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = 'SELECT * FROM users WHERE username="'.$username.'" AND password="'.$password.'"';
    echo $query;
    $result=$conn->query($query);
    
    if (mysqli_num_rows($result)>=1) {
        echo "hi";
        $rowuser = mysqli_fetch_assoc($result);
        $_SESSION['user']=$rowuser['username'];
        header('Location: chat.php');
    } 
    else {
              $_SESSION['invalid']="invalid";
        header('Location: index.php');
    }
}
?>
