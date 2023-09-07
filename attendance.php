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

?>
<?php

    if(empty($_GET['n'])){
        header("Location: forbidden.php");
    }
    //set student no
    $number = (int)$_GET['n'];

    /*
    *   Get student info
    */
    $class = $_SESSION['class'];
    $query = "SELECT * FROM `student` WHERE `classno` = $number AND `section` = '$class'";
    //get result
    $result = $mysqli->query($query) or die($mysqli->error);
    $studentinfo = $result->fetch_assoc();

    //get total number of students
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
                <h2>Attendance Monitoring System</h2>
            </div>
            <br/>
            <ul class="menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="view.php">View list</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        <br/>

        <main>
            <div class = "fillup">
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
                <hr>
                <form method="POST" action="process.php"  enctype = "multipart/form-data" >
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
                    <input type = "submit" value="submit"> 
                    <input type="hidden" name="number" value= "<?php echo $number?>">             
                </form>
            </div>
    <br/>
        </main>

        <div class="footer">
            <p>Login id: <?php echo $_SESSION['id']?></p>
            <p>Logged in as: <?php echo  $_SESSION['user']?></p>
            <p>Class: <?php echo $_SESSION['class']?></p>
            <p> Copyright &copy 2021</p>
        </div>   
    </body>
</html>