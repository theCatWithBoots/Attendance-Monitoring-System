<?php include 'db.php' ?>
<?php session_start() ?>
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
 
if(empty($_GET['query'])){
     header("Location: forbidden.php");
}

 $output = '';
 $query = $_GET['query'];
 $result = $mysqli->query($query) or die($mysqli->error);

 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Last Name</th>
                         <th>First Name</th>  
                         <th>Middle Name</th>    
                         <th>LRN</th>  
                         <th>Grade Level</th>  
                         <th>Section</th>
                         <th>Gender</th>
                         <th>Date and Time</th>
                         <th>Checked by</th>
                         <th>Status</th>
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
        <tr>  
            <td>'.$row["lname"].'</td>
            <td>'.$row["fname"].'</td>  
            <td>'.$row["mname"].'</td>  
            <td>'.$row["lrn"].'</td>  
            <td>'.$row["gradelvl"].'</td>  
            <td>'.$row["section"].'</td>  
            <td>'.$row["gender"].'</td>  
            <td>'.$row["dateandtime"].'</td>  
            <td>'.$row["checkedby"].'</td>  
            <td>'.$row["astatus"].'</td>    
        </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;
 }

?>
