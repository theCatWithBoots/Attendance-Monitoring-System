<?php include 'db.php' ?>
<?php session_start(); ?>
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
}
if( $_SESSION['class'] == "ADMIN"){
    header("Location: admin_index.php");
}
?>
<?php
    if(empty($_GET['upkey'])){
        header("Location: forbidden.php");
    }

    $updateKey = $_GET['upkey'];
    $class = $_SESSION['class'];

    $updateKey2 = explode(',', $updateKey);
    $dateTime = current($updateKey2); 
    $lrn = end($updateKey2);

   // $query = "SELECT * FROM `attendance` WHERE `dateandtime` = '$dateTime' AND `lrn` = $lrn";
    $query = "SELECT * FROM `student` WHERE `lrn` = $lrn";
    $result = $mysqli->query($query) or die($mysqli->error);
    $studentinfo = $result->fetch_assoc();

    $query="SELECT * FROM `student` WHERE `section` = '$class'";
    $result =  $mysqli->query($query) or die($mysqli->error);
    $total = $result->num_rows;

?>
<!DOCTYPE html>
<html>
<head>
        <meta charset ="atf-8">
        <title>Attendance Monitoring System</title>
        <link rel = "stylesheet" href = "css/style3.css" type="text/css"  media="screen"/>      
        <style>
        div.sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
        }
        </style>
    </head>
    <body>
        <header>
            <div class = "header1">
                <h1>BANQUEROHAN NATIONAL HIGH SCHOOL</h1>
            </div>
        </header>
        <br/>

        <div class = "container">
                <h2>Attendance Monitoring System</h2>
        </div>
        <br/>
        
        <ul class="menu">
        <li><a href="index.php">Home</a></li>
            <li><a href="attendance.php?n=1">Start</a></li>
            <li><a href="view.php">View list</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

        <br/>

        <main>
        <div class ="fillup">
                <div class="current">Student <?php echo $studentinfo['classno']?> of <?php echo $total?></div>
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
                <form method="POST" action="updateprocess.php"  enctype = "multipart/form-data" >
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
        <br/>
        <div class="footer">
            <p>Login id: <?php echo $_SESSION['id']?></p>
            <p>Logged in as: <?php echo  $_SESSION['user']?></p>
            <p>Class: <?php echo $_SESSION['class']?></p>
            <p> Copyright &copy 2021</p>
        </div>
    </body>
</html>