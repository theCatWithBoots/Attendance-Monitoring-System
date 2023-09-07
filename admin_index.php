
<?php include 'db.php' ?>
<?php session_start() ?>
<?php
if(!empty($_SESSION['flag']))
$_SESSION['flag'] == NULL;

 if( $_SESSION['id'] == NULL){
     header("Location: login.php");
}

if( $_SESSION['class'] != "ADMIN"){
    header("Location: index.php");
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
        <link rel = "stylesheet" href = "css/style2.css" type="text/css"  media="screen"/>     
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
            <br/>
        </header>
        <main>
            <div class = "container">
                <h2>Attendance Monitoring System - Admin</h2>
            </div>
            <br/>
            <ul class="menu">
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
        </main>
        <div id="slideshow">
    </div>
        <footer>
            <div class = "container">
                Copyright &copy 2021
            </div>
        </footer>

    </body>
</html>