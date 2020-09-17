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

    <title>Needed MCQS - Edit Profile</title>
</head>

<?php 
// require_once('inc/top.php');

if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

$session_username = $_SESSION['username'];


if(isset($_GET['edit'])){

    $edit_id = $_GET['edit'];
    $edit_query = "SELECT * FROM users WHERE id = $edit_id";

    $edit_query_run = mysqli_query($connection, $edit_query);
    if(mysqli_num_rows($edit_query_run) > 0){

        $edit_row = mysqli_fetch_array($edit_query_run);
        $e_username = $edit_row['username'];
        if($e_username == $session_username){
        $e_first_name = $edit_row['first_name'];
        $e_last_name = $edit_row['last_name'];
        $e_details = $edit_row['details'];
        $e_email = $edit_row['email'];
        }
        else{
            header('Location: index.php');
        }

    }
    else{
        header('Location: index.php');
    }

}
else{
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
                        <li class="fa fa-user"></li> Edit Profile <small style="font-size:25px;" class="text-muted"> Edit Profile Details</small>
                    </h2>
                    <hr>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                        </ol>
                    </nav>
<?php 
                    if(isset($_POST['submit'])){
                        $first_name = mysqli_real_escape_string($connection,$_POST['first-name']);
                        $last_name = mysqli_real_escape_string($connection,$_POST['last-name']);
                    
                        $password = mysqli_real_escape_string($connection,$_POST['password']);
                        $details = mysqli_real_escape_string($connection, $_POST['details']);
                        $salt_query = "SELECT * FROM users ORDER BY id DESC limit 1";
                        $salt_run = mysqli_query($connection, $salt_query);
                        $salt_row = mysqli_fetch_array($salt_run);

                        $salt = $salt_row['salt'];
                        
                        $insert_password = crypt($password, $salt);

                        if(empty($first_name) or empty($last_name)){

                            $error = "All (*) fields are Required";

                        }
                        else{
       
                            $update_query = "UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_name', `details` = '$details'";

                            if(isset($password)){
                                $update_query .= ", `password` = '$insert_password'";
                            }
                            $update_query .= " WHERE `users`.`id` = $edit_id";
                            if(mysqli_query($connection, $update_query)){
                                $msg = "Profile Has Been Updated";
                                // header("refresh:0; url=edit-user.php?eidt=$edit_id");
                            }
                            else{
                                $error = "Profile Has Not Been Updated";
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
                            <input type="text" name="first-name" class="form-control" placeholder="First Name" id="first-name" value="<?php echo $e_first_name ?>" required>
                            </div>
                            <div class="form-group">
                            <label for="last-name">Last Name:*</label>
                            <input type="text" name="last-name" class="form-control" placeholder="Last Name" id="last-name" value="<?php echo $e_last_name ?>" required>
                            </div>
                            <div class="form-group">
                            <label for="password">Password:*</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" id="password">
                            </div>

                            <div class="form-group">
                            <label for="details">Details</label>
                            <textarea name="details" id="details" cols="30" rows="10" class="form-control" placeholder="Enter your details here"><?php echo $e_details ?></textarea>
                            </div>

                            <input name="submit" type="submit" class="btn btn-primary" value="Update Profile">
                            
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