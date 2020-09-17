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

    <title>Needed MCQS - Users</title>
</head>


<?php 

// require_once('inc/top.php');

?>
<?php


if(!isset($_SESSION['username'])){
    header('Location: login.php');

}
else if(isset($_SESSION['username']) && $_SESSION['role'] == 'author'){
    header('Location: index.php');
}

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_query = "DELETE FROM `users` WHERE `users`.`id` = $delete_id";
        if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
            if(mysqli_query($connection, $delete_query)){
                $msg = "User Has Been Deleted";
            }
            else{
                $error = "User Has Not Been Deleted";
            }
        }
    }

    if(isset($_POST['checkboxes'])){
        
        foreach($_POST['checkboxes'] as $user_id){

            $bulk_option = $_POST['bulk-options'];

            if($bulk_option == 'delete'){
                
                $bulk_delete_query = "DELETE FROM `users` WHERE `users`.`id` = $user_id";
                
                mysqli_query($connection, $bulk_delete_query);

            }else if($bulk_option == "author"){

                $bulk_author_query = "UPDATE `users` SET `role` = 'author' WHERE `users`.`id` = $user_id" ;

                mysqli_query($connection, $bulk_author_query);


            }else if($bulk_option == "admin"){

                $bulk_admin_query = "UPDATE `users` SET `role` = 'admin' WHERE `users`.`id` = $user_id" ;

                mysqli_query($connection, $bulk_admin_query);

            }
            
        }

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
                        <li class="fa fa-tachometer"></li> Users <small style="font-size:25px;" class="text-muted"> View All User</small>
                    </h2>
                    <hr>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </nav>

                    <?php

                    $query = "SELECT * FROM users";
                    $run = mysqli_query($connection, $query);
                    if(mysqli_num_rows($run) > 0){

                     ?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="form-group ml-3">
                                            <select name="bulk-options" id="" class="form-control">
                                                <option value="delete">Delete</option>
                                                <option value="author">Change to Author</option>
                                                <option value="admin">Change to Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-8 ml-3">
                                        <input type="submit" value="Apply" class="btn btn-success">
                                        <a href="add-user.php" class="btn btn-primary">Add New</a>
                                    </div>
                                </div>
                           
                        </div>
                    </div>
                    <?php  if(isset($error)){
                        echo "<span class = 'text-align-right text-danger'>$error</span>";
                    }
                    else if(isset($msg)){
                        echo "<span class = 'text-align-right text-success'>$msg</span>";
                    }
                    ?>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="" id="selectallboxes"></th>
                                <th>Sr #</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Password</th>
                                <th>Posts</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php 
                        while($row = mysqli_fetch_array($run)){
                            $id = $row['id'];
                            $date = $row['date'];
                            $first_name = $row['first_name'];
                            $last_name = $row['last_name'];
                            $username = $row['username'];
                            $email = $row['email'];
                            $password = $row['password'];
                            $role = $row['role'];

                            $view_query = "SELECT * FROM posts WHERE statuss = 'publish' and author_username = '$username'";
                            $view_run = mysqli_query($connection, $view_query);
                            $views = mysqli_num_rows($view_run);

                         ?>
                            <tr>
                                <td><input type="checkbox" class="checkboxes" name="checkboxes[]" id="" value="<?php echo $id; ?>"></td>
                                <td><?php echo $id?></td>
                                <td><?php echo $date?></td>
                                <td><?php echo $first_name." " .$last_name?></td>
                                <td><?php echo $username?></td>
                                <td><?php echo $email?></td>
                                <td><?php echo ucfirst($role)?></td>
                                <td>********</td>
                                <td><?php echo $views?></td>
                                <td><a href="edit-user.php?edit=<?php echo $id ?>"><li class="fa fa-pencil"></li></a> </td>
                                <td><a href="users.php?delete=<?php echo $id ?>"><li class="fa fa-times"></li></a> </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <?php
                }else{
                        echo "<center><h4>No Users<h4/><center/>";
                    }
                    
                    ?>

                </form>
                </div>
            </div>

           
        </div>
        <?php 
            require_once('inc/footer.php') 
            ?>
            <script>
            $(function(){

                $("#selectallboxes").click(function(event){

                    if(this.checked){
                    $('.checkboxes').each(function(){
                        this.checked = true;

                    });
                }
                else{
                    $('.checkboxes').each(function(){
                        this.checked = false;
                    });
                }


                });


                });

        </script>

</body>

</html>