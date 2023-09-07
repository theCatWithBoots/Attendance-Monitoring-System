<?php include 'db.php' ?>
<?php session_start() ?>
<?php if( $_SESSION['id'] == NULL){
     header("Location: login.php");
}

if(time() -  $_SESSION['last_login_timestamp'] > 900){
    echo "<script>
    alert('Session Expired. Please Login again.' );
    window.location.href='logout.php'
   </script>";
}
else {
    $_SESSION['last_login_timestamp'] = time(); //refresh login time stamp
}?>
<html> 
<head> 
    <title>403 Forbidden</title> 
</head> 
<body> 
 
<h1>Directory access is forbidden.</h1> 
 <?php
    if( $_SESSION['class'] == "ADMIN"){
            echo '<a href="admin_index.php"  class = "start" >Back to Home</a>';
    }
    else   
    echo '<a href="index.php"  class = "start" >Back to Home</a>';
 
 
 ?>
</body> 
</html> 