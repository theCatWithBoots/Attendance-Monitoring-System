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
        $currentID = $_POST['currentID'];
        $id = $_POST['Tid'];
        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $class = $_POST['class'];
        $grade = $_POST['grade'];


        $query = "UPDATE `teacher` SET `id`= '$id',`fname`='$fname',`mname`='$mname',`lname`='$lname',`class`='$class',`gradelvl`=$grade WHERE `id` = '$currentID'";
        $run = $mysqli->query($query) or die($mysqli->error);

        if($run == true){
            echo "<script>
            alert('Record Updated Successfully!');
            window.location.href='teacher_view.php'
           </script>";
        }
        else{
            echo "<script>
            alert('Sorry, there was an error!');
            window.location.href='teacher_view.php'
           </script>";
        }
        
        }

          else{
            header("Location: forbidden.php");
         }

   


?>