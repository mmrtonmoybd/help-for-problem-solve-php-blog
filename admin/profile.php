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

    <title>Needed MCQS - Profile</title>
</head>


<?php 
// require_once('inc/top.php'); 

if(!isset($_SESSION['username'])){
    header('Location: login.php');
}
$session_username = $_SESSION['username'];

$query = "SELECT * FROM users WHERE username ='$session_username'";
$run = mysqli_query($connection, $query);
$row = mysqli_fetch_array($run);

$id = $row['id'];
$date = $row['date'];
$first_name = $row['first_name'];
$last_name = $row['last_name'];
$username = $row['username'];
$email = $row['email'];
$role = $row['role'];
$details = $row['details'];

?>

<body>

    <div id="wrapper">


    <?php require_once('inc/header.php'); ?>

       
        <br>
        <div class="container-fluid body-section">
            <div class="row">
                <div class="col-md-3">
                    <?php require_once('inc/sidebar.php') ?>
                </div>
                <div class="col-md-9">
                    <h2>
                        <li class="fa fa-user"></li> Profile <small style="font-size:25px;" class="text-muted"> Personal Details</small>
                    </h2>
                    <hr>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
            
            
            <div class="row">
                <div class="col-md-12">
                
             
                <img src="img_avatar.png" width="200px" class="rounded-circle img-thumbnail mx-auto d-block" alt="user profile">
                <br>
                <hr>
                            <a href="edit-profile.php?edit=<?php echo $id ?>" class="btn btn-primary float-center">Edit Profile</a>
                            <br>
                            <hr>
                           
                            <h3 class="text-center">Profile Details</h3>
                            <br>
                            <table class="table table-hover table-bordered">
                                <tr>
                                    <td width="20%"><b>User ID:</b></td>
                                    <td width="30%"><?php echo $id ?></td>
                                    <td width="20%"><b>Signup Date:</b></td>
                                    <td width="30%"><?php echo $date ?></td>
                                </tr>
                                <tr>
                                    <td width="20%"><b>First Name</b></td>
                                    <td width="30%"><?php echo $first_name ?></td>
                                    <td width="20%"><b>Last Name</b></td>
                                    <td width="30%"><?php echo $last_name ?></td>
                                </tr>
                                <tr>
                                    <td width="20%"><b>Username</b></td>
                                    <td width="30%"><?php echo $username ?></td>
                                    <td width="20%"><b>Email</b></td>
                                    <td width="30%"><?php echo $email ?></td>
                                </tr>
                                <tr>
                                    <td width="20%"><b>Role</b></td>
                                    <td width="30%"><?php echo ucfirst($role) ?></td>
                                    <td width="20%"><b>Password</b></td>
                                    <td width="30%"><a href="edit-profile.php?edit=<?php echo $id ?>" class="btn btn-primary float-center">Change Password</a></td>
                                </tr>
                            </table>

                            <div class="row">
                                <div class="col-lg-8 col-sm-12">
                                <b>Details:</b>
                                <div><?php echo $details ?></div>
                                </div>
                            </div>
                        </div>
                        

           </div>
                        </div>
       
        </div>

        <?php require_once('inc/footer.php') ?>

    </div>


</body>

</html>