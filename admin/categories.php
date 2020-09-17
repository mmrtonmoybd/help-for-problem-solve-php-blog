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

    <title>Needed MCQS - Categories</title>
</head>


<?php 
// require_once('inc/top.php'); 

if(!isset($_SESSION['username'])){
    header('Location: login.php');
}
else if(isset($_SESSION['username']) && $_SESSION['role'] == 'author'){
    header('Location: index.php');
}

if(isset($_GET['edit'])){
    $edit_id = $_GET['edit'];
}

if(isset($_GET['del'])){
    $del_id = $_GET['del'];
if(isset($_SESSION['username']) and $_SESSION['role'] == 'admin'){
    
    $del_query = "DELETE FROM categories WHERE id = '$del_id'";
    if(mysqli_query($connection, $del_query)){
        $del_msg = "Category Has Been Deleted";
    }else{
        $del_error = "Category Has Been Deleted";
    }
}
}

if(isset($_POST['submit'])){
    $cat_name = mysqli_real_escape_string($connection, strtolower($_POST['cat-name']));

    if(empty($cat_name)){
        $error = "Must fill in this field";
    }else{
        $check_query = "SELECT * FROM categories WHERE category = '$cat_name'";
    $check_run = mysqli_query($connection, $check_query);
    if(mysqli_num_rows($check_run) > 0){
        $error = "Category Already Exist";

    }
    else{
        $insert_query = "INSERT INTO categories (category) VALUES ('$cat_name')";
        if(mysqli_query($connection, $insert_query)){
            $msg = "Category Has Been Added";
        }
        else{
            $error = "Category Has NOT Been Added";
        }
    }
    }
}

if(isset($_POST['update'])){
    $cat_name = mysqli_real_escape_string($connection, strtolower($_POST['cat-name']));

    if(empty($cat_name)){
        $up_error = "Must fill in this field";
    }else{
        $check_query = "SELECT * FROM categories WHERE category = '$cat_name'";
    $check_run = mysqli_query($connection, $check_query);
    if(mysqli_num_rows($check_run) > 0){
        $up_error = "Category Already Exist";

    }
    else{
        $update_query = "UPDATE `categories` SET `category` = '$cat_name' WHERE `categories`.`id` = $edit_id";
        if(mysqli_query($connection, $update_query)){
            $up_msg = "Category Has Been Updated";
        }
        else{
            $up_error = "Category Has NOT Been Updated";
        }
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
                        <li class="fa fa-folder-open"></li> Categories <small style="font-size:25px;" class="text-muted"> Different Categories</small>
                    </h2>
                    <hr>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Categories</li>
                        </ol>
                    </nav>
                    
                       
                    <div class="row">
                        <div class="col-md-6">

                            <form action="" method="post">
                            
                                <div class="form-group">
                                <?php
                                        if(isset($error)){
                                            echo "<h6 class = 'text-right text-danger'>$error</h6>";
                                        }
                                        else if(isset($msg)){
                                                echo "<h6 class = 'text-right text-success'>$msg</h6>";
                                            }

                                         ?>
                                    <label for="category" >Category Name:</label>
                                    
                                    <input type="text" class="form-control" name="cat-name" id=""
                                        placeholder="Enter Category Name: ">
                                </div>
                                <input type="submit" value="Add Category" name="submit" class="btn btn-primary">
                            </form>
                        <?php
                        if(isset($_GET['edit'])){
                            $edit_check_query = "SELECT * FROM categories WHERE id = '$edit_id'";
                            $edit_check_run = mysqli_query($connection, $edit_check_query);

                            if(mysqli_num_rows($edit_check_run) > 0){

                                $edit_row = mysqli_fetch_array($edit_check_run);
                                $up_category = $edit_row['category'];
                        
                        ?>
                            <hr>
                            <form action="" method="post">
                           
                                <div class="form-group">
                                <?php
                                        if(isset($up_error)){
                                            echo "<h6 class = 'text-right text-danger'>$up_error</h6>";
                                        }
                                        else if(isset($up_msg)){
                                                echo "<h6 class = 'text-right text-success'>$up_msg</h6>";
                                            }

                                         ?>
                                    <label for="category">Update Category Name:</label>
                                    <input type="text" value="<?php echo $up_category; ?>" class="form-control" name="cat-name" id=""
                                        placeholder="Enter Category Name: ">
                                </div>
                                <input type="submit" value="Update Category" name="update" class="btn btn-primary">
                            </form>

                            <?php         
                            }
                        } 
                        ?>
                        </div>
                        <div class="col-md-6">


                        <?php 

                        $get_query = "SELECT * FROM categories ORDER BY id DESC";

                    $get_run = mysqli_query($connection, $get_query);
                    if(mysqli_num_rows($get_run) > 0){
                        
                   

                            ?>
                            <?php
                                        if(isset($del_error)){
                                            echo "<h6 class = 'text-right text-danger'>$del_error</h6>";
                                        }
                                        else if(isset($del_msg)){
                                                echo "<h6 class = 'text-right text-success'>$del_msg</h6>";
                                            }

                                         ?>
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Posts</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                
                                while($get_row = mysqli_fetch_array($get_run)){
                                    $category_id = $get_row['id'];
                                    $category_name = $get_row['category'];

                                    $views_query = "SELECT * FROM posts WHERE category = '$category_name'";
                                    $views_run = mysqli_query($connection, $views_query);
                                    $views = mysqli_num_rows($views_run);
                                    
                                
                                
                                ?>
                                    <tr>
                                        <td><?php echo ucfirst($category_name); ?></td>
                                        <td><?php echo $views; ?></td>
                                        <td><a href="categories.php?edit=<?php echo $category_id; ?>">
                                                <li class="fa fa-pencil"></li>
                                            </a> </td>
                                        <td><a href="categories.php?del=<?php echo $category_id; ?>">
                                                <li class="fa fa-times"></li>
                                            </a> </td>
                                    </tr>

                                    <?php } ?>

                                </tbody>
                            </table>
                  <?php     }
                    else{
                        echo "<h3 class='text-center' >No Categories Found </h3>" ;
                    }

                    ?>
                        </div>
                    </div>

                </div>
            </div>

            <?php require_once('inc/footer.php') ?>

        </div>


</body>

</html>