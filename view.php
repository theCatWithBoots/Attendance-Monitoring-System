
<?php include 'db.php' ?>
<?php session_start() ?>
<?php if( $_SESSION['id'] == NULL){
     header("Location: login.php");
}

if( $_SESSION['class'] == "ADMIN"){
    header("Location: admin_index.php");
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
    $class = $_SESSION['class'];
    $query = "SELECT * FROM `attendance` WHERE section = '$class'";
    $result =  $mysqli->query($query) or die($mysqli->error);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset ="atf-8">
        <title>Attendance Monitoring System</title>
        <link rel = "stylesheet" href = "css/style3.css" type="text/css" />    
    
    <style>
        div.sticky {
        position: -webkit-sticky; /* Safari */
        position: sticky;
        top: 0;
        }
    </style>
    
    </head>
    <body>
        <header>
            <div class = "header1">
                <h1>Banquerohan National High School</h1>
            </div>
        </header>

        <br/>
        
        <div class = "container">
                <h2>Attendance Monitoring System</h2>
            </div>
            <br/>

        <div class = "sticky">
            <h1>Attendance Record</h1>
        <ul class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="attendance.php?n=1">Start</a></li>
            <li><a href="view.php">View list</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <br/>
        
        <form method="POST" action="search.php">
            <label for="searchBox">LRN:</label>
            <input type = "text" name="searchBox" value="">

            <label for="startDate">From:</label>
            <input type = "date" name="startDate" value="">

            <label for="endDate">To:</label>
            <input type = "date" name="endDate" value="">

            <br/> <br/>
         <input type = "submit" name="submit" value="Search with LRN only">
         <input type = "submit" name="submitWithDate" value="Search with LRN and Date">
         <input type = "submit" name="submitWithDateOnly" value="Search with Date">
        </form>

        </div>
        <br />
        <main>
              <table id="students" style="font-size: 13px;">       
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
                            echo '<td><a href= "download.php?File=',$dlFile,'">Download</a></td>';
                             } 
                             else{
                                 echo '<td></td>';
                             }
                             
                             ?>
                             <?php 
                             $updateKey = $rows['dateandtime'].",".$rows['lrn'];
                             echo '<td><a href= "update.php?upkey=',$updateKey,'">Update</a></td>'?>
    
                        </tr>
                <?php } ?>
              </table>
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