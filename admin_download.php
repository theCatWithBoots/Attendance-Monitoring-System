<?php include 'db.php' ?>
<?php session_start() ?>
<?php if( $_SESSION['id'] == NULL){
     header("Location: login.php");
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
    if(!empty($_GET['File'])){
        $filename = basename($_GET['File']);
        $filepath = 'uploads/'.$filename;

        if(!empty($filename) && file_exists($filepath)){

            //Define headers

            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename = $filename");
            header("Content-Type: application/zip");
            header("Content-Transfer-Emcoding: binary");

            readfile($filepath);
            exit;
        }
        else{
            switch ($_SESSION['glvl']){
                case 7:
                    echo "<script>
                    alert('File does not exist' );
                    window.location.href='admin_viewG7.php'</script>";
                    break;
                case 8:
                    echo "<script>
                    alert('File does not exist' );
                    window.location.href='admin_viewG8.php'</script>";
                    break;
                case 9:
                    echo "<script>
                    alert('File does not exist' );
                    window.location.href='admin_viewG9.php'</script>";
                    break;
                case 10:
                    echo "<script>
                    alert('File does not exist' );
                    window.location.href='admin_viewG10.php'</script>";
                    break;
            }
        }
    }
    else{
        header("Location: forbidden.php");
    }


?>