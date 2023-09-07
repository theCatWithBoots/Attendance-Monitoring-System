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
        $grade = $_POST['grade'];

        $query = "SELECT * FROM `teacher` WHERE id = '$id'";
        $arr = $mysqli->query($query) or die($mysqli->error);
        $temp = $arr->fetch_assoc();

        if(!empty($temp['id'])){ //if has duplicate key
            echo "<script>
            alert('Duplicate ID!');
            window.location.href='teacher.php'
           </script>";
        }

        if(ctype_digit($grade) && ($grade >= 7 && $grade <= 10 || $grade == 0)){
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mname = $_POST['mname'];
            $class = strtoupper($_POST['class']);
    
    
            $query = "INSERT INTO `teacher`(`id`, `fname`, `mname`, `lname`, `class`,`gradelvl`) 
            VALUES ('$id','$fname','$mname','$lname','$class',$grade)";
            $run = $mysqli->query($query) or die($mysqli->error);
    
            if($run){
                echo "<script>
                alert('Record Inserted Successfully!');
                window.location.href='admin_index.php'
               </script>";
            }
            else{
                echo "<script>
                alert('Sorry, there was an error!');
                window.location.href='teacher.php'
               </script>";
            }
            
            
        }
        else{
            echo "<script>
            alert('Invalid Grade Level!');
            window.location.href='teacher.php'
           </script>";
        }

        }

          else{
             header("Location: forbidden.php");
         }

   


?>