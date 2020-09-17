<?php

    $session_username = $_SESSION['username'];
    $session_rolel = $_SESSION['role'];

    $get_comment = "SELECT * FROM comments WHERE statuss = 'pending'";
    $get_comment_run = mysqli_query($connection, $get_comment);

    $num_of_rows = mysqli_num_rows($get_comment_run);

    if($session_rolel == 'admin'){
     $get_posts = "SELECT * FROM posts WHERE statuss = 'draft'";
     $get_posts_run = mysqli_query($connection, $get_posts);

     $num_of_rows_posts = mysqli_num_rows($get_posts_run);

    }
    else if($session_rolel == 'author'){
        $get_posts = "SELECT * FROM posts WHERE statuss = 'draft' and author_username = '$session_username'";
        $get_posts_run = mysqli_query($connection, $get_posts);

        $num_of_rows_posts = mysqli_num_rows($get_posts_run);
   
       }

    

?>

        <div class="list-group">

                        <a href="index.php" class="list-group-item active">
                            <li class="fa fa-tachometer"></li> Dashboard
                        </a>
                        <a href="posts.php" class="list-group-item">
                            <li class="fa fa-file-text mr-2"></li> All Posts
                            <?php if($num_of_rows_posts > 0){
                            echo "<span class='badge badge-dark badge-pill ml-5'>$num_of_rows_posts</span>";

                            }
                            else{
                                echo "<span class='badge badge-dark badge-pill ml-5'>0</span>";

                            }
                            
                            ?>
                        </a>

                        <?php

                            if($session_rolel == 'admin'){
                                

                            ?>

                        <a href="comments.php" class="list-group-item ">
                            <li class="fa fa-comment mr-2"></li> Comments

                            <?php if($num_of_rows > 0){
                            echo "<span class='badge badge-dark badge-pill ml-5'>$num_of_rows</span>";

                            }
                            else{
                                echo "<span class='badge badge-dark badge-pill ml-5'>0</span>";

                            }
                            
                            ?>
                        </a>
                        <a href="categories.php" class="list-group-item ">
                            <li class="fa fa-folder-open mr-2"></li> Categories
                        </a>
                        <a href="users.php" class="list-group-item ">
                            <li class="fa fa-users mr-2"></li> Users
                        </a>
                        <?php
                                
                            }

                            ?>
                    </div>