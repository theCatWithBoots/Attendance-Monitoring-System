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

    if(empty($_GET['deleteKey'])){
        header("Location: forbidden.php");
    }

     $delKey = $_GET['deleteKey'];

     $delKey2 = explode(',', $delKey);

     $id = current($delKey2); 
     $table = end($delKey2);

     if($table == "logkey"){
        $query = "DELETE FROM `loginkey` WHERE id = '$id'";
        $result =  $mysqli->query($query) or die($mysqli->error);

       if($result){
        echo "<script>
        alert('Record has been deleted successfully!' );
        window.location.href='admin_logkey.php'
        </script>";
       }
       else{
        echo "<script>
        alert('Sorry there was an error, please try again.' );
        window.location.href='admin_logkey.php'
        </script>";
       }

     }
     else if($table == "teacher"){
        $query = "DELETE FROM `teacher` WHERE id = '$id'";
        $result =  $mysqli->query($query) or die($mysqli->error);

       if($result){
        echo "<script>
        alert('Record has been deleted successfully!' );
        window.location.href='teacher_view.php'
        </script>";
       }
       else{
        echo "<script>
        alert('Sorry there was an error, please try again.' );
        window.location.href='teacher.php'
        </script>";
       }
     }
    else {
        $query = "SELECT * FROM `attendance` WHERE lrn = $id AND dateandtime = '$table'";
        $result =  $mysqli->query($query) or die($mysqli->error);
        $row = $result->fetch_assoc();

      if($row['excuseLetter'] != "NONE"){
        $filename =  $row['excuseLetter'];
        if(unlink("uploads/".$filename)){
          $query = "DELETE FROM `attendance` WHERE lrn = $id AND dateandtime = '$table'";
          $result =  $mysqli->query($query) or die($mysqli->error);
        }
        else{
          $query = "DELETE FROM `attendance` WHERE lrn = $id AND dateandtime = '$table'";
          $result =  $mysqli->query($query) or die($mysqli->error);
        }
        
      }
      else {
        $query = "DELETE FROM `attendance` WHERE lrn = $id AND dateandtime = '$table'";
        $result =  $mysqli->query($query) or die($mysqli->error);
      }

      if($result){
            switch ($_SESSION['glvl']){
              case 7:
                  echo "<script>
                  alert('Record has been deleted.' );
                  window.location.href='admin_viewG7.php'</script>";
                  break;
              case 8:
                  echo "<script>
                  alert('Record has been deleted.' );
                  window.location.href='admin_viewG8.php'</script>";
                  break;
              case 9:
                  echo "<script>
                  alert('Record has been deleted.' );
                  window.location.href='admin_viewG9.php'</script>";
                  break;
              case 10:
                  echo "<script>
                  alert('Record has been deleted.' );
                  window.location.href='admin_viewG10.php'</script>";
                  break;
          }
      }
      else{
          switch ($_SESSION['glvl']){
            case 7:
                echo "<script>
                alert('Sorry there was an error, please try again.' );
                window.location.href='admin_viewG7.php'</script>";
                break;
            case 8:
                echo "<script>
                alert('Sorry there was an error, please try again.t' );
                window.location.href='admin_viewG8.php'</script>";
                break;
            case 9:
                echo "<script>
                alert('Sorry there was an error, please try again.' );
                window.location.href='admin_viewG9.php'</script>";
                break;
            case 10:
                echo "<script>
                alert('Sorry there was an error, please try again.' );
                window.location.href='admin_viewG10.php'</script>";
                break;
        }
      }
     }
 



?>