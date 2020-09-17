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

    <title>Needed MCQS - Add Post</title>
</head>


<?php 
// require_once('inc/top.php'); 

if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

if(isset($_SESSION['username'])){
    $session_username = $_SESSION['username'];
}

if(isset($_SESSION['name'])){
    $session_name = $_SESSION['name'];
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
                        <li class="fa fa-plus-square"></li> Add Post <small style="font-size:25px;" class="text-muted"> Add New Post</small>
                    </h2>
                    <hr>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Post</li>
                        </ol>
                    </nav>

                    <?php

                if(isset($_POST['submit'])){
                    $title = mysqli_real_escape_string($connection,$_POST['title']);
                    $post_data = mysqli_real_escape_string($connection,$_POST['post-data']);
                    $tags = mysqli_real_escape_string($connection,$_POST['tags']);
                    $category = $_POST['categories'];
                    $status = $_POST['status'];

                    if(empty($title) or empty($post_data) or empty($tags)){
                        $error = "All (*) fields are required";
                    }
                    else{
                        $insert_query = "INSERT INTO `posts` (`title`, `author`, `author_username`, `category`, `tags`, `post_data`, `views`, `statuss`) VALUES ('$title', '$session_name', '$session_username', '$category', '$tags', '$post_data', '0', '$status')";

                        if(mysqli_query($connection, $insert_query)){

                            $msg = "Post Has Been Added";
                            $title = "";
                            $post_data = "";
                            $tags = "";
                            $status = "";
                            $category = "";
                        }
                        else{
                            $error = "Post Has Not Been Added";
                        }
                    }
                }

                    ?>

                    <div class="row">
                   <div class="col-md-9">
            
                    
                    <form action="" method="post">
                    <?php
                    if(isset($error)){
                        echo "<span class = 'text-right text-danger'>$error</span>";
                    }
                    else if(isset($msg)){
                            echo "<span class = 'text-align-right text-success'>$msg</span>";
                        }

                        ?>
                            <div class="form-group">
                        
                            <label for="title">Title:*</label>
                            <input type="text" name="title" class="form-control" placeholder="Type here title..." value="<?php if(isset($title)){echo $title; } ?>" id="title" required>
                            </div>

                            
                            <div class="form-group">
                            <label for="post-data">Post Content:*</label>
                            <textarea name="post-data" id="post-data" cols="30" rows="10" value="" class="form-control" ></textarea>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                <div class="form-group">
                            <label for="tags">Keywords:*</label>
                            <textarea name="tags" id="tags" cols="30" rows="10" class="form-control" value=""><?php if(isset($tags)){echo $tags; } ?></textarea>
                            </div>
                                </div>
                                <div class="col-sm-6">
                                <div class="form-group">
                                <label for="categories">Select Category:*</label>
                                <select name="categories" id="categories" class="form-control">
                                   <?php

                                   $cat_query = "SELECT * FROM categories ORDER BY id DESC";
                                   $cat_run = mysqli_query($connection, $cat_query);

                                   if(mysqli_num_rows($cat_run) > 0){

                                    while($cat_row = mysqli_fetch_array($cat_run)){
                                        $cat_name = $cat_row['category'];
                                        echo "<option value='".$cat_name."'".((isset($category) and $category == $cat_name)? "selected":"").">".ucfirst($cat_name)."</option>";
                                    }

                                   }
                                   else{
                                       echo "<h6 class='text-center'>No Category Available </h6>";
                                   }


                                   ?>
                                    </select>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="form-group">
                            <label for="status">Status:*</label>
                            <select name="status" id="status" class="form-control">
                                    <option value="publish" <?php if(isset($status) && $status == 'publish') {echo "selected";} ?>>Publish</option>
                                    <option value="draft" <?php if(isset($status) && $status == 'draft') {echo "selected";} ?>>Draft</option>
                                    </select>                            
                                    </div>
                                </div>
                            </div>
                           
                            <input type="submit" name="submit" value="Add Post" class="btn btn-primary">
                        </form>
                        
                   </div>
                   </div>

                  

                </div>
            </div>

        <?php require_once('inc/footer.php') ?>

    </div>


</body>

</html>