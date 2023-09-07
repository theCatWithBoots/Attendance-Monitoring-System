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
    if($_POST){
        $number = $_POST['number'];

        $selected_choice = $_POST['choice'];
        $next = $number + 1;

        $class = $_SESSION['class'];

        $query = "SELECT * FROM `student` WHERE section = '$class' AND classno = $number";
        $result = $mysqli->query($query) or die($mysqli->error);
        $studentinfo = $result->fetch_assoc();

        $file = $_FILES['file'];
        $filename = $_FILES['file']['name']; //get file name

        $month = date('m');
        $day =  date('d');
        $year =  date('y');

        $date = $year."-".$month."-".$day;
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
                        move_uploaded_file( $fileTmpname, $fileDestination);
                       $fileNameToDb =   $fileNameNew;
                    }
                    else{
                        echo "<script>
                        alert('File too large' );
                        window.location.href='attendance.php?n=',$number,'
                       </script>";
                    }
                }
                else{
                    echo "<script>
                alert('Sorry, there was an error' );
                window.location.href='attendance.php?n=',$number,'
               </script>";
                }
            } 
            else{
                echo "<script>
                alert('File type not allowed' );
                window.location.href='attendance.php?n=',$number,'
               </script>";
            }
    

        }
        else {
            $fileNameToDb = "NONE"; //no excuse letter
        }

       
 
        $temp = $_SESSION['id'];
                if( $selected_choice == "p"){
                    $query = "INSERT INTO `attendance` (lname,fname, mname, lrn, gradelvl,section, gender, dateandtime, checkedby,astatus, excuseLetter)
                    SELECT lname, fname, mname,lrn, gradelvl, section,gender, now(),  '$temp', 'present', '$fileNameToDb'
                    FROM `student` WHERE section = '$class' AND classno = $number " ;

                    $run = $mysqli->query($query) or die($mysqli->error);
    
                }
                else if( $selected_choice == "ue"){
                    $query = "INSERT INTO `attendance` (lname,fname, mname, lrn, gradelvl,section, gender, dateandtime, checkedby,astatus, excuseLetter)
                    SELECT lname, fname, mname,lrn, gradelvl, section,gender, now(),   '$temp','Uabsentee', '$fileNameToDb'
                    FROM `student` WHERE section = '$class' AND classno = $number" ;

                    $run = $mysqli->query($query) or die($mysqli->error);
 
                }
                else if( $selected_choice == "ea"){
                    $query = "INSERT INTO `attendance` (lname,fname, mname, lrn, gradelvl,section, gender, dateandtime,checkedby, astatus, excuseLetter)
                    SELECT lname, fname, mname,lrn, gradelvl, section,gender, now(),   '$temp','Eabsentee', '$fileNameToDb'
                    FROM `student` WHERE section = '$class' AND classno = $number" ;

                    $run = $mysqli->query($query) or die($mysqli->error);
                 
                }
                else{
                    $query = "INSERT INTO `attendance` (lname,fname, mname, lrn, gradelvl,section, gender, dateandtime, checkedby,astatus, excuseLetter)
                    SELECT lname, fname, mname,lrn, gradelvl, section,gender, now(),  '$temp','Tardy', '$fileNameToDb'
                    FROM `student` WHERE section = '$class' AND classno = $number" ;

                    $run = $mysqli->query($query) or die($mysqli->error);
                    
                }   
                
                //compute for total number of students
                $query="SELECT * FROM `student` WHERE section = '$class'";
                $result =  $mysqli->query($query) or die($mysqli->error);
                $total = $result->num_rows;


                if($number == $total){
                    header("Location: index.php");
                    exit();
                }
                else{
                    header("Location: attendance.php?n=".$next);
                }
    }
    else header("Location: forbidden.php");

?>