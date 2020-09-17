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

    <title>Needed MCQS - Comments</title>
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

$session_username = $_SESSION['username'];

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_query = "DELETE FROM `comments` WHERE `comments`.`id` = $delete_id";
        if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
            if(mysqli_query($connection, $delete_query)){
                $msg = "Comment Has Been Deleted";
            }
            else{
                $error = "Comment Has Not Been Deleted";
            }
        }
    }

    if(isset($_GET['approve'])){
        $approve_id = $_GET['approve'];
        $approve_query = "UPDATE `comments` SET `statuss` = 'approve' WHERE `comments`.`id` = $approve_id" ;
        if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
            if(mysqli_query($connection, $approve_query)){
                $msg = "Comment Has Been Approved";
            }
            else{
                $error = "Comment Has Not Been approved";
            }
        }
    }

    if(isset($_GET['unapprove'])){
        $approve_id = $_GET['unapprove'];
        $approve_query = "UPDATE `comments` SET `statuss` = 'pending' WHERE `comments`.`id` = $approve_id" ;
        if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
            if(mysqli_query($connection, $approve_query)){
                $msg = "Comment Has Been Unapproved";
            }
            else{
                $error = "Comment Has Not Been Unapproved";
            }
        }
    }

    if(isset($_POST['checkboxes'])){
        
        foreach($_POST['checkboxes'] as $user_id){

            $bulk_option = $_POST['bulk-options'];

            if($bulk_option == 'delete'){
                
                $bulk_delete_query = "DELETE FROM `comments` WHERE `comments`.`id` = $user_id";

                mysqli_query($connection, $bulk_delete_query);

            }else if($bulk_option == "approve"){

                $bulk_author_query = "UPDATE `comments` SET `statuss` = 'approve' WHERE `comments`.`id` = $user_id" ;

                mysqli_query($connection, $bulk_author_query);


            }else if($bulk_option == "pending"){

                $bulk_admin_query = "UPDATE `comments` SET `statuss` = 'pending' WHERE `comments`.`id` = $user_id" ;

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
                        <li class="fa fa-comments"></li> Comments <small style="font-size:25px;" class="text-muted"> View All Comments</small>
                    </h2>
                    <hr>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Comments</li>
                        </ol>
                    </nav>

                    <?php
                    if(isset($_GET['reply'])){
                        $reply_id = $_GET['reply'];
                        $reply_check = "SELECT * FROM comments WHERE post_id = '$reply_id'";
                        $reply_check_run = mysqli_query($connection, $reply_check);
                        if(mysqli_num_rows($reply_check_run) > 0){

                            if(isset($_POST['reply'])){
                                $comment_data = $_POST['comment'];
                                if(empty($comment_data)){
                                    $c_error = "Must fill in this field";
                                }
                                else{
                                    $get_user_data = "SELECT * FROM users WHERE username = '$session_username'";
                                    $get_user_run = mysqli_query($connection, $get_user_data);
                                    $get_user_row = mysqli_fetch_array($get_user_run);

                                    $date = $get_user_row['date'];
                                    $first_name = $get_user_row['first_name'];
                                    $last_name = $get_user_row['last_name'];
                                    $full_name = "$first_name $last_name";
                                    $email = $get_user_row['email'];

                                    $insert_comment_query = "INSERT INTO comments (`name`, `post_id`, `email`, `comment`, `statuss`) VALUES ('$full_name', '$reply_id', '$email', '$comment_data', 'approve')";

                                    if(mysqli_query($connection, $insert_comment_query)){
                                        $c_msg = "Comment Has Been Submitted";
                                        header('Location: comments.php');
                                    }
                                    else{
                                        $c_error = "Comment Has Not Been Submitted";
                                    }
                                }
                            }


                    ?>

                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                    <form action="" method="post">

                    <div class="form-group">
                    <label for="comment">Comment:*</label>
                    <?php  if(isset($c_error)){
                        echo "<span class = 'text-align-right text-danger'>$c_error</span>";
                    }
                    else if(isset($c_msg)){
                        echo "<span class = 'text-align-right text-success'>$c_msg</span>";
                    }
                    ?>
                    <textarea class="form-control" name="comment" id="comment" placeholder="Type repy here...." cols="30" rows="7"></textarea>
                    
                    </div>
                    <input type="submit" name="reply" id="reply" class="btn btn-primary" value="Reply">
                    </form>
                    </div>
                </div>

                <hr>

                    <?php
    }
                    }
                    $query = "SELECT * FROM comments ORDER BY id DESC";
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
                                                <option value="approve">Change to Approve</option>
                                                <option value="pending">Change to Unapprove</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-8 ml-3">
                                        <input type="submit" value="Apply" class="btn btn-success">
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
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Approve</th>
                                <th>Unapprove</th>
                                <th>Reply</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php 
                        while($row = mysqli_fetch_array($run)){
                            $id = $row['id'];
                            $post_id = $row['post_id'];
                            $date = $row['date'];
                            $name = $row['name'];
                            $email = $row['email'];
                            $comment = $row['comment'];
                            $status = $row['statuss'];

                         ?>
                            <tr>
                                <td><input type="checkbox" class="checkboxes" name="checkboxes[]" id="" value="<?php echo $id; ?>"></td>
                                <td><?php echo $date;?></td>
                                <td><?php echo $name;?></td>
                                <td><?php echo $email;?></td>
                                <td><?php echo $comment;?></td>
                                <td><span class="text-<?php if($status == 'approve'){echo 'success';} else if($status == 'pending'){echo 'danger';}  ?>"><?php echo ucfirst($status);?> </span></td>
                                <td><a href="comments.php?approve=<?php echo $id ?>"><li class="fa fa-check"></li></a></td>
                                <td><a href="comments.php?unapprove=<?php echo $id ?>"><li class="fa fa-close"></li></a></td>
                                <td><a href="comments.php?reply=<?php echo $post_id ?>"><li class="fa fa-reply"></li></a> </td>
                                <td><a href="comments.php?delete=<?php echo $id ?>"><li class="fa fa-times"></li></a> </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <?php
                }else{
                        echo "<center><h4>No Comments Available<h4/><center/>";
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