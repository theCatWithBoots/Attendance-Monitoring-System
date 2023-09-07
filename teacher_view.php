
<?php include 'db.php' ?>
<?php session_start() ?>
<?php
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

$query = "SELECT * FROM `teacher` ORDER BY `gradelvl`";
$result =  $mysqli->query($query) or die($mysqli->error); 
?>

<!DOCTYPE html>
<html>
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

        <div class = "sticky">
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

    </div>
         <table id="students">       
                <tr>
                    <th>ID</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Class</th>
                    <th>Grade</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php
                    while($rows = $result->fetch_assoc()){
                ?>
                        <tr>
                            <td><?php echo $rows['id']?></td>
                            <td><?php echo $rows['lname'] ?></td>
                            <td><?php echo $rows['fname']?></td>
                            <td><?php echo $rows['mname']?></td>
                            <td><?php echo $rows['class']?></td>
                            <td><?php echo $rows['gradelvl']?></td>
                            <?php 
                            if($rows['id'] != "334556198"){
                                echo '<td><a href= "edit_teacher.php?id=',$rows['id'],'">Edit</a></td>';
                            }
                            else{
                                echo "<td>ADMIN</td>";
                            }
                            ?>
                            <?php
                            if($rows['id'] != "334556198"){
                                $delkey=$rows['id'].","."teacher";
                                echo '<td><a href= "delete.php?deleteKey=',$delkey,'">Delete</a></td>';
                            }
                            else{
                                echo "<td>ADMIN</td>";
                            }
                            ?>
                        </tr>
                <?php } ?>
              </table>
        </main>

        <footer>
            <div class = "container">
                Copyright &copy 2021
            </div>
        </footer>

    </body>
</html>