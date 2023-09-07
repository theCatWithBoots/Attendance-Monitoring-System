
<?php include 'db.php' ?>
<?php session_start()?>
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

if(empty($_GET['id'])){
    header("Location: forbidden.php");
}

$id = $_GET['id'];

$query = "SELECT * FROM `teacher` WHERE id = '$id'"; 
$result =  $mysqli->query($query) or die($mysqli->error);
$teacherinfo = $result->fetch_assoc();

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
        <main>
        <div class ="fillup">
           <form action="edit_teacherProcess.php" method="POST">
               <input type= "hidden" name="action" value="registration">
               <h1>Edit Teacher Record</h1>
                <hr>
                    <label for="Tid">Teacher ID: </label>
                    <input type = "text" name ="Tid"  value = "<?php echo $teacherinfo['id'] ?>" required> 
                    <br/><br/>

                    <label for="lname">Last name: </label>
                    <input type = "text" name ="lname" value = "<?php echo $teacherinfo['lname'] ?>" required>
                    <br/><br/>

                    <label for="fname">First name: </label>
                    <input type = "text" name ="fname" value = "<?php echo $teacherinfo['fname'] ?>" required >
                    <br/><br/>

                    <label for="mname">Middle name: </label>
                    <input type = "text" name ="mname" value = "<?php echo $teacherinfo['mname'] ?>" required >
                    <br/><br/>

                    <label for="class">Class: </label>
                    <input type = "text" name ="class" value = "<?php echo $teacherinfo['class'] ?>" required >
                    <br/><br/>

                    <label for="grade">Grade: </label>
                    <input type = "text" name ="grade" value = "<?php echo $teacherinfo['gradelvl'] ?>" required >
                    <br/><br/>

                    <button type="submit" class="registerbtn">Register</button>
                    <input type = "hidden" name ="currentID" value="<?php echo $teacherinfo['id'] ?>">
                 
            </form>
    </div>
        </main>
        <br/><br/>
        <footer>
            <div class = "container">
                Copyright &copy 2021
            </div>
        </footer>

    </body>
</html>