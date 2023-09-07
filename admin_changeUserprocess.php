<?php include 'db.php' ?>
<?php session_start() ?>
<?php if( $_SESSION['id'] == NULL){
     header("Location: login.php");
}
if( $_SESSION['class'] != "ADMIN"){
    header("Location: index.php");
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
<?php

if($_POST){
    $id = $_POST['id'];
    $username = $_POST['Nuser'];

    $query = "UPDATE `loginkey` SET `username`='$username' WHERE id = '$id'";
    $run = $mysqli->query($query) or die($mysqli->error);

    if($run){
        echo "<script>
        alert('Username Changed Successfully' );
        window.location.href='admin_logkey.php'
       </script>";
    }
    else{
        echo "<script>
        alert('Sorry, there was an error, please try again!' );
        window.location.href='admin_logkey.php'
       </script>";
    }
}
else{
    header("Location: forbidden.php");
}


?>