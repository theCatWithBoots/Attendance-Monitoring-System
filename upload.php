<?php include 'db.php' ?>
<?php session_start() ?>
<?php if( $_SESSION['id'] == NULL){
     header("Location: login.php");
}

$_SESSION['last_login_timestamp'] = time();

if( $_SESSION['class'] == "ADMIN"){
    header("Location: admin_index.php");
}
?>

<?php
    $number = (int)$_GET['number'];

    if(isset($POST['fileUpload'])){
        $file = $_FILES['file'];

        $filename = $_FILES['file']['name']; //get file name
        $fileTmpname = $_FILES['file']['tmp_name']; //get temporary location of file
        $fileSize = $_FILES['file']['size']; //get file size
        $fileError = $_FILES['file']['error']; //if there's error
        $fileType = $_FILES['file']['type']; //gets file type
        
        $fileExt = explode('.', $filename); //split file name, gets atual file name and extension
        $fileActualExt = strtolower(end($fileExt)); //convert the file extension to lower case

        $allowed = array('jpg', 'jpeg', 'png', 'pdf'); //allowed file types

        if(in_array($fileActualExt, $allowed)){ //if filetype is allowed
            if($fileError === 0){ //if there was no error
                if( $fileSize < 50000){ //if file size is less than 50mb
                    $fileNameNew = uniqid('', true).".".$fileActualExt; //get unique name
                    $fileDestination = 'uploads/'. $fileNameNew; //set file destination

                    move_uploaded_file( $fileTmpname, $fileDestination);
                    header("Location: attendance.php?n=".$number);
                }
                else{
                    echo "<script>
                     alert('File too large!' );
                     window.location.href='logout.php?='.$number
                      </script>";
                }
            }
            else{
                echo "<script>
                 alert('Sorry there was an error. Please try again.' );
                 window.location.href='logout.php?='.$number
                 </script>";
            }
        } 
        else{
            echo "<script>
            alert('You cannot upload file of this type.' );
            window.location.href='logout.php?='.$number
           </script>";
            //header("Location: attendance.php?n=".$number);
        }




    }


?>