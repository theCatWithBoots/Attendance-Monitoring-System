<?php include 'db.php' ?>
<?php session_start() ?>
<?php if( $_SESSION['id'] == NULL){
     header("Location: login.php");
}
if( $_SESSION['class'] == "ADMIN"){
    header("Location: admin_index.php");
}

$_SESSION['last_login_timestamp'] = time();

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
            echo "<script>
            alert('File does not exist' );
            window.location.href='view.php'
           </script>";
        }
    }


?>