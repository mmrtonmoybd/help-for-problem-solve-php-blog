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

    <title>Needed MCQS - Dashboard</title>
</head>



<?php 
// require_once('inc/top.php'); 

    if(!isset($_SESSION['username'])){
        header('Location: login.php');
    }

    $session_rolel = $_SESSION['role'];
    $session_username = $_SESSION['username'];

    $comment_tag_query = "SELECT * FROM comments WHERE statuss = 'pending'";
    $category_tag_query = "SELECT * FROM categories";
    $users_tag_query = "SELECT * FROM users";
    

    $c_tag_run = mysqli_query($connection, $comment_tag_query);
    $cat_tag_run = mysqli_query($connection, $category_tag_query);
    $user_tag_run = mysqli_query($connection, $users_tag_query);
    

    $c_rows = mysqli_num_rows($c_tag_run);
    $cat_rows = mysqli_num_rows($cat_tag_run);
    $user_rows = mysqli_num_rows($user_tag_run);
    

    if($session_rolel == 'admin'){
        $posts_tag_query = "SELECT * FROM posts WHERE statuss = 'publish'";
        $post_tag_run = mysqli_query($connection, $posts_tag_query);
          $post_rows = mysqli_num_rows($post_tag_run);
    }
    if($session_rolel == 'author'){
        $posts_tag_query = "SELECT * FROM posts WHERE statuss = 'publish' and author_username = '$session_username'";
        $post_tag_run = mysqli_query($connection, $posts_tag_query);
         $post_rows = mysqli_num_rows($post_tag_run);
    }
    
   
    

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
                        <li class="fa fa-tachometer"></li> Dashboard <small style="font-size:25px;" class="text-muted"> Statistics Overview</small>
                    </h2>
                    <hr>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                        <li class="fa fa-tachometer"></li> Dashboard</li>
                    </ol>

                    <div class="row tag-boxes">

                    <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card bg-danger">
                                <div class="panel-heading">
                                    <div class="row cm-row">
                                        <div class="col-xs-3">
                                            <li class="fa fa-file-text fa-5x"></li>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="text-right huge"><?php if(!empty($post_rows)){ echo $post_rows;} else{ echo "0";} ?></div>
                                            <div class="text-right">All Posts</div>

                                        </div>
                                    </div>
                                </div>

                                <a href="posts.php">
                                    <div class="card-footer bg-light text-danger">
                                        <span class="pull-left">View All Posts</span>
                                        <span class="pull-right">
                                            <li class="fa fa-arrow-circle-right"></li>
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        
                        <?php

                            if($session_rolel == 'admin'){
                                

                            ?>

                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card bg-primary">
                                <div class="panel-heading">
                                    <div class="row cm-row">
                                        <div class="col-xs-3">
                                            <li class="fa fa-comments fa-5x"></li>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="text-right huge"><?php echo $c_rows; ?></div>
                                            <div class="text-right">New comments</div>

                                        </div>
                                    </div>
                                </div>

                                <a href="comments.php">
                                    <div class="card-footer bg-light text-primary">
                                        <span class="pull-left">View All Comments</span>
                                        <span class="pull-right">
                                            <li class="fa fa-arrow-circle-right"></li>
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        

                        <div class="col-md-6 col-lg-3">
                            <div class="card bg-warning mb-3">
                                <div class="panel-heading">
                                    <div class="row cm-row">
                                        <div class="col-xs-3">
                                            <li class="fa fa-users fa-5x"></li>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="text-right huge"><?php echo $user_rows; ?></div>
                                            <div class="text-right">All Users</div>

                                        </div>
                                    </div>
                                </div>

                                <a href="users.php">
                                    <div class="card-footer bg-light text-warning">
                                        <span class="pull-left">View All Users</span>
                                        <span class="pull-right">
                                            <li class="fa fa-arrow-circle-right"></li>
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card bg-success">
                                <div class="panel-heading">
                                    <div class="row cm-row">
                                        <div class="col-xs-3">
                                            <li class="fa fa-folder-open fa-5x"></li>
                                        </div>
                                        <div class="col-xs-9">
                                            <div class="text-right huge"><?php echo $cat_rows; ?></div>
                                            <div class="text-right">All Categories</div>

                                        </div>
                                    </div>
                                </div>

                                <a href="categories.php">
                                    <div class="card-footer bg-light text-success">
                                        <span class="pull-left">View All Categories</span>
                                        <span class="pull-right">
                                            <li class="fa fa-arrow-circle-right"></li>
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <?php
                                
                            }

                            ?>


                    </div>
                    <hr>
                    <?php


                        if($_SESSION['role'] == 'admin'){
                            $get_posts_query = "SELECT * FROM posts WHERE statuss = 'publish' ORDER BY id DESC LIMIT 5";
                            $get_posts_run = mysqli_query($connection, $get_posts_query);
                        }
                       
                        else if($_SESSION['role'] == 'author'){

                            $get_posts_query = "SELECT * FROM posts WHERE statuss = 'publish' and author_username = '$session_username' ORDER BY id DESC";
                            $get_posts_run = mysqli_query($connection, $get_posts_query);
                            }

                        if(mysqli_num_rows($get_posts_run) > 0){

                        ?>
                    <h3>New Posts</h3>
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Post Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Views</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        while($get_posts_row = mysqli_fetch_array($get_posts_run)){
                            $post_id = $get_posts_row['id'];
                            $post_date = $get_posts_row['date'];
                            $post_title = $get_posts_row['title'];
                            $post_author = $get_posts_row['author'];
                            $post_category = $get_posts_row['category'];
                            $post_views = $get_posts_row['views'];
                            

                         ?>
                            <tr>
                                <td><?php echo $post_date; ?></td>
                                <td><?php echo $post_title; ?></td>
                                <td><?php echo $post_author; ?></td>
                                <td><?php echo $post_category; ?></td>
                                <td><i class="fa fa-eye"></i> <?php echo $post_views; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <a href="posts.php" class="btn btn-primary">View All Posts</a>
                    <hr>
                    <?php } ?>
                    <br>
                    <br>
                    <?php

                            if($session_rolel == 'admin'){
                                

                            ?>
                    <?php

                    $get_users_query = "SELECT * FROM users ORDER BY id DESC LIMIT 5";
                    $get_users_run = mysqli_query($connection, $get_users_query);
                    if(mysqli_num_rows($get_users_run) > 0){

                    ?>
                    <h3>New Users</h3>
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Sr #</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        while($get_users_row = mysqli_fetch_array($get_users_run)){
                            $user_id = $get_users_row['id'];
                            $user_date = $get_users_row['date'];
                            $user_first_name = $get_users_row['first_name'];
                            $user_last_name = $get_users_row['last_name'];
                            $user_username = $get_users_row['username'];
                            $user_role = $get_users_row['role'];
                            $user_full_name = "$user_first_name $user_last_name";

                         ?>
                            <tr>
                                <td><?php echo $user_id; ?></td>
                                <td><?php echo $user_date; ?></td>
                                <td><?php echo $user_full_name; ?></td>
                                <td><?php echo $user_username; ?></td>
                                <td><?php echo ucfirst($user_role); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <a href="users.php" class="btn btn-primary">View All Users</a>
                 
                    <hr>
                    <?php } ?>
                        <?php } ?>
                </div>

            </div>
        </div>

        <?php require_once('inc/footer.php') ?>

    </div>


</body>

</html>