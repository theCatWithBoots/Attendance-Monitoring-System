<?php include 'db.php' ?>
<?php session_start(); ?>
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
}

?>
<?php
    if(empty($_GET['upkey'])){
        header("Location: forbidden.php");
    }

    $updateKey = $_GET['upkey'];

    $updateKey2 = explode(',', $updateKey);
    $dateTime = current($updateKey2); 
    $lrn = end($updateKey2);

   // $query = "SELECT * FROM `attendance` WHERE `dateandtime` = '$dateTime' AND `lrn` = $lrn";
    $query = "SELECT * FROM `student` WHERE `lrn` = $lrn";
    $result = $mysqli->query($query) or die($mysqli->error);
    $studentinfo = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
        <meta charset ="atf-8">
        <title>Attendance Monitoring System</title>
        <link rel = "stylesheet" href = "css/style2.css" type="text/css" />  
    <style>
        div.sticky {
        position: -webkit-sticky; /* Safari */
        position: sticky;
        top: 0;
        padding:0px;
        }
    </style>
    
    </head>
    <body>
    <header>
            <div class = "header1">
                <h1>BANQUEROHAN NATIONAL HIGH SCHOOL</h1>
            </div>
            <br/>
    </header>
        <main>
        <div class = "container">
                <h2>Attendance Monitoring System - Admin</h2>
        </div>
        
        <br/>

        <ul class="menu">
            <li><a href="admin_index.php" >Home</a></li>
               <li><a href="#"  >Login Keys</a>
                   <ul>
                    <li><a href="admin_registration.php" >Create LogIn Key</a></li>
                    <li><a href="admin_logKey.php" >View Login Key</a></li>
                    <li><a href="teacher.php"  >Add Teacher</a></li>
                    <li><a href="teacher_view.php"  >Teacher's Record</a></li>
                  </ul>
                </li>
                <li><a href="#"  >Students</a>
                    <ul>
                    <li><a href="admin_viewG7.php"  >Grade 7</a></li>
                    <li><a href="admin_viewG8.php"  >Grade 8</a></li>
                    <li><a href="admin_viewG9.php"  >Grade 9</a></li>
                    <li><a href="admin_viewG10.php" >Grade 10</a></li>
                    </ul>                   
                </li>
                <li><a href="db_update.php?n=1"  >Update Database</a></li>
                <li><a href="logout.php"  >Logout</a></li>
            </ul>
        <br/><br/>
        <div class ="fillup">
                <p class="list">
                    <?php echo $studentinfo['lname']?>
                    <?php echo ","?>
                    <?php echo $studentinfo['fname']?>
                    <?php echo $studentinfo['mname'] ?>
                    <br>
                    <?php echo "Grade "?>
                    <?php echo $studentinfo['gradelvl']?>
                    <?php echo $studentinfo['section']?>
                    <br>
                    <?php echo "Gender: "?>
                    <?php echo $studentinfo['gender']?>
                    <br>
                    <?php echo "LRN: "?>
                    <?php echo $studentinfo['lrn']?>
                </p>
                <hr>
                <form method="POST" action="admin_updateprocess.php"  enctype = "multipart/form-data" >
                        
                        <label class = "rdobutton">
                        <input name="choice" type="radio" value="p" required>Present
                        <span class="checkmark"></span>
                        </label> 

                        <label class = "rdobutton">
                        <input name="choice" type="radio" value="ue">Unexcused Absentee
                        <span class="checkmark"></span>
                        </label> 
                        
                        <label class = "rdobutton">
                        <input name="choice" type="radio" value="ea">Excused Absentee
                        <span class="checkmark"></span>
                        </label> 

                        <label class = "rdobutton">
                        <input name="choice" type="radio" value="t">Tardy
                        <span class="checkmark"></span>
                        </label> 
                    
                    <input type="file" name="file">
                    <input type = "submit" value="Update"> 
                    <input type="hidden" name="lrn" value= "<?php echo $lrn?>">
                    <input type="hidden" name="dt" value= "<?php echo $dateTime?>">                  
                </form>
            </div>
        </main>
    </br>
        <footer>
            <div class = "container">
                Copyright
            </div>
        </footer>

    </body>
</html>