<?php 
ob_start();
session_start();
require_once('../inc/db.php') ?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Needed MCQS - Add User</title>
</head>

<?php 
// require_once('inc/top.php');

if(!isset($_SESSION['username'])){
    header('Location: login.php');
}
else if(isset($_SESSION['username']) && $_SESSION['role'] == 'author'){
    header('Location: index.php');
}

?>
<body>

    <div id="wrapper">

    <?php require_once('inc/header.php') ?>
        <br>
        <div class="container-fluid body-section">
            <div class="row">
                <div class="col-md-3">
                <?php require_once('inc/sidebar.php') ?>
                </div>
                <div class="col-md-9">
                    <h2>
                        <li class="fa fa-user-plus"></li> Add User <small style="font-size:25px;" class="text-muted"> Add New User</small>
                    </h2>
                    <hr>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add New User</li>
                        </ol>
                    </nav>
<?php 
                    if(isset($_POST['submit'])){
                        $first_name = mysqli_real_escape_string($connection,$_POST['first-name']);
                        $last_name = mysqli_real_escape_string($connection,$_POST['last-name']);
                        $email = mysqli_real_escape_string($connection,strtolower($_POST['email']));
                        $username = mysqli_real_escape_string($connection,strtolower($_POST['username']));

                        $username_trim = preg_replace('/\s+/', '', $username);
                        $password = mysqli_real_escape_string($connection,$_POST['password']);
                        $role = $_POST['role'];
                        $details = mysqli_real_escape_string($connection,$_POST['details']);
                   
                        $check_query = "SELECT *FROM users WHERE username = '$username'";
                        $check_query .= " or email = '$email'";
                        $check_run = mysqli_query($connection, $check_query);

                        $salt_query = "SELECT * FROM users ORDER BY id DESC limit 1";
                        $salt_run = mysqli_query($connection, $salt_query);
                        $salt_row = mysqli_fetch_array($salt_run);

                        $salt = $salt_row['salt'];
                        
                        $password = crypt($password, $salt);

                        if(empty($first_name) or empty($last_name) or empty($email) or empty($username) or empty($password) or empty($role)){

                            $error = "All (*) fields are Required";

                        }
                        else if($username != $username_trim){
                            $usererror = "Don't Use space in Username";

                        }
                        else if(mysqli_num_rows($check_run) > 0){
                            $error = "Username or Email Already Exist";
                        }
                        else{
                            $insert_query = "INSERT INTO `users` (`id`, `date`, `first_name`, `last_name`, `email`, `password`, `role`, `details`, `salt`, `username`) VALUES (NULL, current_timestamp(), '$first_name', '$last_name', '$email', '$password', '$role', '$details', '', '$username')";

                            if(mysqli_query($connection, $insert_query)){
                                $msg = "User Has Been Added";
                            }
                            else{
                                $msg = "User Has Not Been Added";
                            }
                        }
                   
                   
                    

                    }
?>
                   <div class="row">
                   <div class="col-md-8">
                   <?php
                    if(isset($error)){
                        echo "<span class = 'text-align-right text-danger'>$error</span>";
                    }
                    else if(isset($msg)){
                            echo "<span class = 'text-align-right text-success'>$msg</span>";
                        }

                        ?>
                        <br>
                        <br>
                    <form action="" method="post">
                            <div class="form-group">
                            <label for="first-name">First Name:*</label>
                            <input type="text" name="first-name" class="form-control" placeholder="First Name" id="first-name" required>
                            </div>
                            <div class="form-group">
                            <label for="last-name">Last Name:*</label>
                            <input type="text" name="last-name" class="form-control" placeholder="Last Name" id="last-name" required>
                            </div>
                            <div class="form-group">
                            <label for="username">Username:*</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" id="username" required>
                          <?php  if(isset($usererror)){
                        echo "<span class = 'text-align-right text-danger'>$usererror</span>";
                    }
                    ?>
                            </div>
                            <div class="form-group">
                            <label for="email">Email:*</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" id="email" required>
                            </div>
                            <div class="form-group">
                            <label for="password">Password:*</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" id="password" required>
                            </div>
                            <div class="form-group">
                            <label for="role">Role:*</label>
                            <select name="role" id="role" class="form-control" required>
                            <option value="author">Author</option>
                            <option value="admin">Admin</option>
                            </select>
                            </div>
                            <div class="form-group">
                            <label for="detials">Details</label>
                            <textarea name="details" id="details" cols="30" rows="10" class="form-control" placeholder="Enter your details here" required></textarea>
                            </div>

                            <input name="submit" type="submit" class="btn btn-primary" value="Add User">
                           
                        </form>
                   </div>
                   <div class="col-md-8">
                   </div>
                   </div>

                  

                </div>
            </div>

            <?php 
            // require_once('inc/users.php') 
            ?>

        </div>


</body>

</html>