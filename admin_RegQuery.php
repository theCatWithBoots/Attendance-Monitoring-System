<?php include 'db.php' ?>
<?php session_start()?>
<?php
if( $_SESSION['id'] == NULL){
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
    $id = $_POST['Tid'];

    $query = "SELECT * FROM `loginkey` WHERE `id` = '$id'";
    $arr = $mysqli->query($query) or die($mysqli->error);
    $temp = $arr->fetch_assoc();

    if(!empty($temp['id'])){ //if has duplicate key
        echo "<script>
        alert('Duplicate ID!');
        window.location.href='admin_registration.php'
       </script>";
    }
 
        $username = $_POST['Tuser'];
        $password =password_hash($_POST['Tpass'], PASSWORD_DEFAULT);

        $query = "SELECT `id`, `fname`, `mname`, `lname`, `class` FROM `teacher` WHERE id = '$id'";
        $run = $mysqli->query($query) or die($mysqli->error);
        $teacherInfo = $run->fetch_assoc();
        
        if(mysqli_num_rows($run) > 0){
            $fname =  $teacherInfo['fname'];
            $mname =  $teacherInfo['mname'];
            $lname =  $teacherInfo['lname'];
            $class =  $teacherInfo['class'];
           
            $query = "INSERT INTO `loginkey`(`fname`, `mname`, `lname`, `class`, `id`, `username`, `password`) VALUES 
            ('$fname', '$mname', '$lname','$class', '$id', '$username', '$password')";
            $run = $mysqli->query($query) or die($mysqli->error);
         
            if($run){
                echo "<script>
                alert('Login key added successfully!');
                window.location.href='admin_index.php'
                </script>";
            }
            else{
                echo "<script>
                alert('Sorry, there was an error!');
                window.location.href='admin_index.php'
                </script>";
            }
        }
        else{
            echo "<script>
            alert('Invalid ID!');
            window.location.href='admin_registration.php'
           </script>";
        }   


}
else{
    header("Location: forbidden.php");
}
       
       


?>