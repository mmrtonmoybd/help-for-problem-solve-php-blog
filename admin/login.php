<?php
ob_start();
session_start();
require_once('../inc/db.php');

  if(isset($_POST['submit'])){
      $username = mysqli_real_escape_string($connection,strtolower($_POST['username']));
      $password = mysqli_real_escape_string($connection,$_POST['password']);

      $stmt = $dbconnection->prepare("SELECT * FROM users WHERE username = '$username'");
      $stmt ->bind_param('s', $username);
      $stmt ->bind_param('s', $password);
      $stmt ->execute();

      // $check_username_query = "SELECT * FROM users WHERE username = '$username'";
      // $check_username_run = mysqli_query($connection, $check_username_query);

      if(mysqli_num_rows($check_username_run) > 0){

        $row = mysqli_fetch_array($check_username_run);
        $check_username_run = $stmt ->get_result();
        $db_username = $row['username'];
        $db_password = $row['password'];
        $db_role = $row['role'];
        $db_first_name = $row['first_name'];
        $db_last_name = $row['last_name'];

        $password = crypt($password, $db_password);

        

        if($username == $db_username && $password == $db_password){
          header('Location: index.php');

          $_SESSION['username'] = $db_username;
          $_SESSION['role'] = $db_role;
          $_SESSION['name'] = $db_first_name .' '.$db_last_name;
          
        }
        else{
          $error = "Wrong Username or Password";
        }

      }
      else{
        $error = "Wrong Username or Password";
      }
  }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Needed MCQS - Log In</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/login.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" action="" method="post">
      <h1 class="h3 mb-5 font-weight-normal">Please sign in</h1>
      <label for="inputusername" class="sr-only">Username</label>
      <input name="username" type="userame" id="inputusername" class="form-control mb-3" placeholder="Username" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input name="password" type="password" id="inputPassword" class="form-control mb-4" placeholder="Password" required>
      <label>
        <?php 
        if(isset($error)){
          echo "<span class = 'text-align-right text-danger mb-3'>$error</span>";
        } 
        ?>
      </label>
     <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block">
      <p class="mt-5 mb-3 text-muted">&copy; 2020</p>
    </form>
  </body>
</html>
