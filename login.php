<?php include 'db.php' ?>
<?php session_start()  ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Attendance Monitoring System</title>
    <link rel="stylesheet" href="css/login.css">
  </head>
  <body>
  
    <div class="center">
      <h1>Login</h1>
      <?php 
                if( !empty($_SESSION['flag']) && $_SESSION['flag'] == 1){
                    echo '<center><p style="color:red">Wrong username or password!</p></center>';
                    $_SESSION['flag'] = 0;
                  }
               
        ?>
      <form method="POST" action="loginprocess.php" >
            <div class="txt_field">
            <input type="text" name="user" required>
            <span></span>
            <label>Username</label>
            </div>
            <div class="txt_field">
            <input type="password" name ="pass" required>
            <span></span>
            <label>Password</label>
            </div>
            <input type="submit" value="Login">
            <div class="signup_link">
            Copyright &copy 2021
            </div>
      </form>
    </div>
  
  </body>
</html>
