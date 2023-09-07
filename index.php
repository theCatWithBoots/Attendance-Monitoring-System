
<?php include 'db.php' ?>
<?php session_start() ?>
<?php 
if(!empty($_SESSION['flag']))
$_SESSION['flag'] == NULL;

if( $_SESSION['id'] == NULL){
     header("Location: login.php");
}

if( $_SESSION['class'] == "ADMIN"){
    header("Location: admin_index.php");
}

if((time() -  $_SESSION['last_login_timestamp']) > 900){
    echo "<script>
    alert('Session Expired. Please Login again.' );
    window.location.href='logout.php'
   </script>";
}
else {
    $_SESSION['last_login_timestamp'] = time(); //refresh login time stamp
}

?>

<!DOCTYPE html>
<html>
<head>
        <meta charset ="atf-8">
        <title>Attendance Monitoring System</title>
        <link rel = "stylesheet" href = "css/style.css" type="text/css"  media="screen"/>      
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

        <div class = "header2">
                <h2>Attendance Monitoring System</h2>
        </div>
        <br/>

        <ul class="menu">
            <li><a href="attendance.php?n=1">Start</a></li>
            <li><a href="view.php">View list</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

        <div id="slideshow">
        <div class="container">
            
            </div>
        <br/>
        <div class="footer">
        <p>Login id: <?php echo $_SESSION['id']?></p>
        <p>Logged in as: <?php echo  $_SESSION['user']?></p>
        <p>Class: <?php echo $_SESSION['class']?></p>
        <p> Copyright &copy 2021</p>
        </div>        

    </body>
</html>