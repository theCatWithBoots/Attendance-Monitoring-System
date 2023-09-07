<?php 
    session_start();
     
    if( $_SESSION['id'] == NULL){
     header("Location: login.php");
    }
    if( $_SESSION['class'] != "ADMIN"){
        header("Location: index.php");
    }
    
    if(empty($_GET['n'])){
        header("Location: forbidden.php");
    }

    global $mysqli;
     //create connection credentials
     $db_host = 'localhost';
     $db_name = 'ams';
     $db_user = 'root';
     $db_pass = '';
 
     //create mysqli object
   
    $mysqli = new mysqli($db_host, $db_user, $db_pass);
 
     //Error handler
     if($mysqli->connect_error){
         printf("Connect failed: %s\n", $mysqli->connect_error);
         exit();
     }

    mysqli_select_db($mysqli, "rms");
    $rms_section = "SELECT DISTINCT `section` FROM `students`";
    $rms_section_result =  $mysqli->query($rms_section) or die($mysqli->error); //get array of sections
    

    while($rms_section_array = $rms_section_result->fetch_assoc()){ //array
        $count = 1;

        mysqli_select_db($mysqli, "rms");
        $rms_db_query = "SELECT * FROM `students`";
        $rms_result = $mysqli->query($rms_db_query) or die($mysqli->error);

        while($rms_result_array = $rms_result->fetch_assoc()){
                $gradelvl =  (int) filter_var($rms_result_array['gradelevel'], FILTER_SANITIZE_NUMBER_INT);
                if($rms_result_array['section'] == $rms_section_array['section'] && $gradelvl >= 7 && $gradelvl <= 10 ){
                   
                    $temp_lrn = $rms_result_array['lrn'];

                    mysqli_select_db($mysqli, "ams");
                    $query = "SELECT * FROM `student` WHERE lrn = $temp_lrn";
                    $result =  $mysqli->query($query) or die($mysqli->error);
                    $userinfo = $result->fetch_assoc(); //array

                        if(empty($userinfo['lrn'])){
                            $lname = strtoupper($rms_result_array['lastname']);
                            $fname = strtoupper($rms_result_array['firstname']);
                            $mname = strtoupper($rms_result_array['middlename']);
                            $lrn = $rms_result_array['lrn'];
                            $gender = $rms_result_array['gender'];
                            $gradelvl =  (int) filter_var($rms_result_array['gradelevel'], FILTER_SANITIZE_NUMBER_INT);
                            $section = $rms_result_array['section'];
                            //trim(str_replace(' ', '_', strtoupper($rms_result_array['section'])));
                            mysqli_select_db($mysqli, "ams");
                            $AMS_db_query = "INSERT INTO `student`(`classno`, `lname`, `fname`, `mname`, `lrn`, `gender`, `gradelvl`, `section`) 
                            VALUES ($count, '$lname','$fname','$mname',$lrn,'$gender',$gradelvl,'$section')";
                            $count++;

                            $AMS_result = $mysqli->query($AMS_db_query) or die($mysqli->error); 
                        }

                   
            
            }
        }

    }

    echo "<script>
    alert('Database has been updated successfully!' );
    window.location.href='admin_index.php'
    </script>";

?>