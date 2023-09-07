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



    if($_POST){
        $updateDate = $_POST['dt'];
        $updateLrn = $_POST['lrn'];

        $selected_choice = $_POST['choice'];


        $query = "SELECT * FROM `student` WHERE lrn = $updateLrn";
        $result = $mysqli->query($query) or die($mysqli->error);
        $studentinfo = $result->fetch_assoc();

        $file = $_FILES['file'];
        $filename = $_FILES['file']['name']; //get file name

        $month = "SELECT EXTRACT(MONTH FROM `dateandtime`) FROM `attendance` WHERE dateandtime = '$updateDate'";
        $resultMonth = $mysqli->query($month) or die($mysqli->error);
        $Marray = $resultMonth->fetch_assoc();
        $M = strval($Marray['EXTRACT(MONTH FROM `dateandtime`)'] );

        $day =  "SELECT EXTRACT(DAY FROM `dateandtime`) FROM `attendance` WHERE dateandtime = '$updateDate'";
        $resultDay = $mysqli->query($day) or die($mysqli->error);
        $Darray = $resultDay->fetch_assoc();
        $D = strval($Darray['EXTRACT(DAY FROM `dateandtime`)'] );

        $year =  "SELECT EXTRACT(YEAR FROM `dateandtime`) FROM `attendance` WHERE dateandtime = '$updateDate'";
        $resultYear = $mysqli->query($year) or die($mysqli->error);
        $Yarray = $resultYear->fetch_assoc();
        $Y = strval($Yarray['EXTRACT(YEAR FROM `dateandtime`)'] );
    
        $date = $Y."-".$M."-".$D;

        $name = $studentinfo['lname']."_".$studentinfo['fname']."_".$studentinfo['mname'];


        if($filename != NULL){
            $fileTmpname = $_FILES['file']['tmp_name']; //get temporary location of file
            $fileSize = $_FILES['file']['size']; //get file size
            $fileError = $_FILES['file']['error']; //if there's error
            $fileType = $_FILES['file']['type']; //gets file type
            
            $fileExt = explode('.', $filename); //split file name, gets atual file name and extension
            $fileActualExt = strtolower(end($fileExt)); //convert the file extension to lower case

            $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'txt', 'docx'); //allowed file types

            if(in_array($fileActualExt, $allowed)){ //if filetype is allowed
                if($fileError === 0){ //if there was no error
                    if( $fileSize < 5000000){ //if file size is less than 
                       $fileNameNew = $name."_".$date.".".$fileActualExt; //get unique name
                        $fileDestination = 'uploads/'. $fileNameNew; //set file destination
                        
                        $query = "SELECT `excuseLetter` FROM `attendance` WHERE lrn = $updateLrn AND dateandtime = '$updateDate'";
                        $result = $mysqli->query($query) or die($mysqli->error);
                        $studentinfo = $result->fetch_assoc();

                        if($studentinfo['excuseLetter'] == "NONE"){
                            move_uploaded_file( $fileTmpname, $fileDestination);
                            $fileNameToDb =   $fileNameNew;
                        }
                        else{
                            unlink("uploads/".$studentinfo['excuseLetter']); //delete current file
                            move_uploaded_file( $fileTmpname, $fileDestination);
                            $fileNameToDb =   $fileNameNew;
                        }

                       
                    }
                    else{
                        $updateKey =  $updateDate.",".$updateLrn;
                        echo "<script>
                        alert('File too large' );
                        window.location.href='admin_update.php?upkey=',$updateKey,'
                       </script>";
                    }
                }
                else{
                    $updateKey =  $updateDate.",".$updateLrn;
                    echo "<script>
                alert('Sorry, there was an Error' );
                window.location.href='admin_update.php?upkey=',$updateKey,'
               </script>";
                }
            } 
            else{
                $updateKey =  $updateDate.",".$updateLrn;
                echo "<script>
                alert('File type not allowed' );
                window.location.href='admin_update.php?upkey=',$updateKey,'
               </script>";
            }
    

        }
        else {
            $fileNameToDb = "NONE"; //no excuse letter
        }

       
                if( $selected_choice == "p"){
                    $query = "UPDATE `attendance` SET `astatus`= 'present',`excuseLetter`= '$fileNameToDb' WHERE `dateandtime` = '$updateDate' AND `lrn` = $updateLrn";
                    $run = $mysqli->query($query) or die($mysqli->error);
    
                }
                else if( $selected_choice == "ue"){
                    $query = "UPDATE `attendance` SET `astatus`= 'Uabsentee',`excuseLetter`= '$fileNameToDb' WHERE `dateandtime` = '$updateDate' AND `lrn` = $updateLrn";
                    $run = $mysqli->query($query) or die($mysqli->error);
 
                }
                else if( $selected_choice == "ea"){
                    $query = "UPDATE `attendance` SET `astatus`= 'Eabsentee',`excuseLetter`= '$fileNameToDb' WHERE `dateandtime` = '$updateDate' AND `lrn` = $updateLrn";
                    $run = $mysqli->query($query) or die($mysqli->error);
                 
                }
                else{
                    $query = "UPDATE `attendance` SET `astatus`= 'Tardy',`excuseLetter`= '$fileNameToDb' WHERE `dateandtime` = '$updateDate' AND `lrn` = $updateLrn";
                    $run = $mysqli->query($query) or die($mysqli->error);
                    
                }           
    }
    else header("Location: forbidden.php");

    switch ($_SESSION['glvl']){
        case 7:
            echo "<script>
            alert('Updated Successfully' );
            window.location.href='admin_viewG7.php'</script>";
            break;
        case 8:
            echo "<script>
            alert('Updated Successfully' );
            window.location.href='admin_viewG8.php'</script>";
            break;
        case 9:
            echo "<script>
            alert('Updated Successfully' );
            window.location.href='admin_viewG9.php'</script>";
            break;
        case 10:
            echo "<script>
            alert('Updated Successfully' );
            window.location.href='admin_viewG10.php'</script>";
            break;
    }
       

?>