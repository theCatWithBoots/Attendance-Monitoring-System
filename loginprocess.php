<?php include 'db.php' ?>
<?php session_start() ?>
<?php

if($_POST){
    $username = $_POST['user'];
    $password = $_POST['pass'];

            $query = "SELECT * FROM `loginkey` WHERE `username` = '$username'";
            $result =  $mysqli->query($query) or die($mysqli->error);
            $userinfo = $result->fetch_assoc(); //array

          if(!empty($userinfo['id'])){

            if($userinfo['username'] == $username &&  password_verify($password, $userinfo['password']) && $userinfo['class'] != "ADMIN" ){
              $_SESSION['id'] = $userinfo['id'];
              $_SESSION['user'] = $userinfo['fname']." ".$userinfo['mname']." ".$userinfo['lname'];
              $_SESSION['class'] = $userinfo['class'];
              $_SESSION['last_login_timestamp'] = time();
              header("Location: index.php");
              exit();
              }
            else if($userinfo['username'] == $username &&  password_verify($password, $userinfo['password'])){
              $_SESSION['id'] = $userinfo['id'];
              $_SESSION['class'] = $userinfo['class'];
              $_SESSION['last_login_timestamp'] = time();
              header("Location: admin_index.php");
              exit();
            }

            else {
              header("Location: login.php?n=0");
              $_SESSION['flag'] = 1;
              $_SESSION['id'] = NULL;

            }

          }
           
          else {
              header("Location: login.php?n=0");
              $_SESSION['flag'] = 1;
              $_SESSION['id'] = NULL;

            }
            
}
else header("Location: forbidden.php");
?>