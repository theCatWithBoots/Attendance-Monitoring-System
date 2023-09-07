
<?php include 'db.php' ?>
<?php session_start()  ?>
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

    $query = "SELECT * FROM `attendance` WHERE gradelvl = 8";
    $result =  $mysqli->query($query) or die($mysqli->error);

    $_SESSION['glvl'] = 8;
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
                <li><?php echo '<a href= "excel.php?query=',$query,'" class="start">Export</a>'?></li>
                <li><a href="db_update.php?n=1"  >Update Database</a></li>
                <li><a href="logout.php"  >Logout</a></li>
            </ul>
           <br/><br/>

        <form method="POST" action="admin_search.php">
            <label for="searchBox">LRN:</label>
            <input type = "text" name="searchBox" value="">

            <label for="startDate">From:</label>
            <input type = "date" name="startDate" value="">

            <label for="endDate">To:</label>
            <input type = "date" name="endDate" value="">

            <label for="searchSection">Section:</label>
            <input type = "text" name="searchSection" value="">

            <br/> <br/>

            <input type = "submit" name="submit" value="Search with LRN only">
            <input type = "submit" name="submitWithDate" value="Search with LRN and Date">
            <input type = "submit" name="submitWithDateOnly" value="Search with Date">
            <input type = "submit" name="submitWithSection" value="Search with Section">
            <input type = "submit" name="submitWithSectionAndDate" value="Search with Date and Section">
        </form>
        <br/>
        </div>
        
              <table id="students"  style="font-size: 13px;">       
                <tr>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>LRN</th>
                    <th>Grade Level</th>
                    <th>Section</th>
                    <th>Gender</th>
                    <th>Date and time</th>
                    <th>Checked by</th>
                    <th>Status</th>
                    <th>Excuse Letter</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
                <?php
                    while($rows = $result->fetch_assoc()){
                ?>
                        <tr>
                            <td><?php echo $rows['lname'] ?></td>
                            <td><?php echo $rows['fname']?></td>
                            <td><?php echo $rows['mname']?></td>
                            <td><?php echo $rows['lrn']?></td>
                            <td><?php echo $rows['gradelvl']?></td>
                            <td><?php echo $rows['section']?></td>
                            <td><?php echo $rows['gender']?></td>
                            <td><?php echo $rows['dateandtime']?></td>
                            <td><?php echo $rows['checkedby']?></td>
                            <td><?php echo $rows['astatus']?></td>
                            <?php 
                            if(strcmp($rows['excuseLetter'], "NONE") != 0){ 
                            $dlFile=$rows['excuseLetter'];
                            echo '<td><a href= "admin_download.php?File=',$dlFile,'">Download</a></td>';
                             } 
                             else{
                                 echo '<td></td>';
                             }
                             
                             ?>
                             <?php 
                             $updateKey = $rows['dateandtime'].",".$rows['lrn'];
                             echo '<td><a href= "admin_update.php?upkey=',$updateKey,'">Update</a></td>'?>

                            <?php 
                             $delKey = $rows['lrn'].",".$rows['dateandtime'];
                             echo '<td><a href= "delete.php?deleteKey=',$delKey,'">Delete</a></td>'?>
                        </tr>
                <?php } ?>
              </table>
            <br/>
            
        </main>

        <footer>
            <div class = "container">
                Copyright &copy 2021
            </div>
        </footer>

    </body>
</html>