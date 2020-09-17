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

    <title>Needed MCQS - All Posts</title>
</head>


<?php 

// require_once('inc/top.php');

?>
<?php 

if(!isset($_SESSION['username'])){
    header('Location: login.php');

}

$session_username = $_SESSION['username'];

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        if($_SESSION['role'] == 'admin'){

           $delete_check_query = "SELECT * FROM posts WHERE id = '$delete_id'";
           $delete_check_run = mysqli_query($connection, $delete_check_query);


        }else if($_SESSION['role'] == 'author'){
            $delete_check_query = "SELECT * FROM posts WHERE id = $delete_id and author_username = '$session_username'";
            $delete_check_run = mysqli_query($connection, $delete_check_query);
            
        }
            if(mysqli_num_rows($delete_check_run) > 0){
               $delete_query = "DELETE FROM `posts` WHERE `posts`.`id` = '$delete_id'";
                if(mysqli_query($connection, $delete_query)){

                    $msg = "Post Has Been Deleted";
                }
                else{
                    $error = "Post Has Not Been Deleted";
                }
        }
        else{
            header('Location: index.php');
        }
    }

    if(isset($_POST['checkboxes'])){
        
        foreach($_POST['checkboxes'] as $user_id){

            $bulk_option = $_POST['bulk-options'];

            if($bulk_option == "delete"){
                
                $bulk_delete_query = "DELETE FROM `posts` WHERE `posts`.`id` = $user_id";
                mysqli_query($connection, $bulk_delete_query);
                $msg = "Post Has Been Deleted";

            }else if($bulk_option == "publish"){

                $bulk_author_query = "UPDATE `posts` SET `statuss` = 'publish' WHERE `posts`.`id` = $user_id" ;

                mysqli_query($connection, $bulk_author_query);
                $msg = "Post Has Been Changed to Publish";


            }else if($bulk_option == "draft"){

                $bulk_admin_query = "UPDATE `posts` SET `statuss` = 'draft' WHERE `posts`.`id` = $user_id" ;

                mysqli_query($connection, $bulk_admin_query);
                $msg = "Post Has Been Changed to Draft";

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
                        <li class="fa fa-file"></li> Posts <small style="font-size:25px;" class="text-muted"> View All Posts</small>
                    </h2>
                    <hr>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Posts</li>
                        </ol>
                    </nav>

                 
                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="form-group ml-3">
                                            <select name="bulk-options" id="" class="form-control">
                                                <option value="delete">Delete</option>
                                                <option value="publish">Publish</option>
                                                <option value="draft">Draft</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-8 ml-3">
                                        <input type="submit" value="Apply" class="btn btn-success">
                                        <a href="add-post.php" class="btn btn-primary">Add New</a>
                                    </div>
                                </div>
                                <?php

                                    if($_SESSION['role'] == 'admin'){
                                    $query = "SELECT * FROM posts ORDER BY id DESC";
                                    $run = mysqli_query($connection, $query);
                                    }else if($_SESSION['role'] == 'author'){

                                    $query = "SELECT * FROM posts WHERE author_username = '$session_username' ORDER BY id DESC";
                                    $run = mysqli_query($connection, $query);
                                    }
                                    if(mysqli_num_rows($run) > 0){
                                        

                                    ?>
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
                                <th>Date</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Categories</th>
                                <th>Views</th>
                                <th>Status</th>
                                <!-- <th>Edit</th>
                                <th>Delete</th> -->
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>Posts</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php 
                        while($row = mysqli_fetch_array($run)){
                            $id = $row['id'];
                            $date = $row['date'];
                            $category = $row['category'];
                            $status = $row['statuss'];
                            $title = $row['title'];
                            $author = $row['author'];
                            $views = $row['views'];

                         ?>
                            <tr>
                                <td><input type="checkbox" class="checkboxes" name="checkboxes[]" id="" value="<?php echo $id; ?>"></td>
                                <td><?php echo $date?></td>
                                <td><?php echo $title?></td>
                                <td><?php echo ucfirst($author)?></td>
                                <td><?php echo $category?></td>
                                <td><?php echo $views?></td>
                                <td><span class="text-<?php if($status == 'publish'){echo 'success';} else if($status == 'draft'){echo 'danger';}  ?>"><?php echo ucfirst($status);?> </span></td>
                                <td><a href="edit-post.php?edit=<?php echo $id ?>"><li class="fa fa-pencil"></li></a> </td>
                                <td><a href="posts.php?delete=<?php echo $id ?>"><li class="fa fa-times"></li></a> </td>
                                <td><a target="_blank" href="../post.php?post_id=<?php echo $id ?>" style="text-decoration: none;" >View</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <?php
                }else{
                        echo "<center><h4>No Posts Available<h4/><center/>";
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