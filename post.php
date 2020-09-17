<?php require_once('inc/top.php') ?>

<body>

<?php require_once('inc/header.php') ?>

<?php

    if(isset($_GET['post_id'])){
      $post_id = $_GET['post_id'];

      $views_query = "UPDATE `posts` SET `views` = views + 1 WHERE `posts`.`id` = $post_id";

      mysqli_query($connection, $views_query);



      $query = "SELECT * FROM posts WHERE statuss = 'publish' and id = $post_id";
      $run = mysqli_query($connection, $query);
      if(mysqli_num_rows($run) > 0){
        $row = mysqli_fetch_array($run);
        $title = $row['title'];
        $author = $row['author'];
        $category = $row['category'];
        $post_data = $row['post_data'];
        $author_username = $row['author_username'];

      }
      else{
        header('Location: index.php');
      }
    }

?>

<?php

          $cat_query = "SELECT * FROM categories WHERE category = '$category'";
          $cat_run = mysqli_query($connection, $cat_query);
            if(mysqli_num_rows($cat_run) > 0){
              while($cat_row = mysqli_fetch_array($cat_run))
            {

              $category = $cat_row['category'];
              $cat_id  = $cat_row['id'];
  
          }
        }


        $author_query = "SELECT * FROM posts WHERE author_username = '$author_username'";
        $author_run = mysqli_query($connection, $author_query);
          if(mysqli_num_rows($author_run) > 0){
            while($author_row = mysqli_fetch_array($author_run))
          {

            $author_id  = $author_row['id'];
            $author_posts = $author_row['author_username'];

        }
      }
?>


    <div class="row">

      <!-- Post Content Column -->
      <div class="col-md-8">
        <br>
        <div class="card mb-2">
        <a href="post.php?post_id=<?php echo $post_id?>"style="text-decoration: none;">
              <h5  class="card-header" ><?php echo $title ?></h5>
            </a>
          <!-- Title -->
          <div class="card-body my-2 py-0">
            
            <p class="card-text"><?php echo $post_data ?></p>
          </div>

          <!-- Author -->
          <div class="card-footer text-muted">
          Category: <a href="index.php?cat=<?php echo $cat_id ?>" style="text-decoration: none;"><?php echo ucfirst($category) ?></a>
            <br>
            Submitted by: <strong style="color: #455f7b!important;"><?php echo ucfirst($author) ?></strong>

          </div>
        </div>

      <!-- author details -->
        <?php $bio_query = "SELECT * FROM users WHERE username = '$author_username'";

        $bio_run = mysqli_query($connection, $bio_query);

        if(mysqli_num_rows($bio_run) > 0){

          $bio_row = mysqli_fetch_array($bio_run);

          $author_bio = $bio_row['details'];  
          if(!empty($author_bio)){

          
  ?>

<br>
<div class="card my-3">
          <h5 class="card-header">About Author:</h5>
          <div class="card-body">
            <h4><?php echo ucfirst($author); ?></h4>
           

            <p><?php echo $author_bio; ?></p>
            <?php 
              
            }
            
            ?>
          </div>
         
        </div>

<br>

<?php 
     }       
?>
       
        <?php 
            $c_query = "SELECT * FROM comments WHERE statuss = 'approve' and post_id = $post_id ORDER BY id DESC";
            $c_run = mysqli_query($connection, $c_query);
            if(mysqli_num_rows($c_run) > 0){
              ?>
           
        
          
        <!-- Single Comment -->
        <h5 class="card-header mb-4">Commments:</h5>
        
        <?php 
          while($c_row = mysqli_fetch_array($c_run)){
            $c_id = $c_row['id'];
            $c_name = $c_row['name'];
            $c_comment = $c_row['comment'];
          
        ?>
        <div class="media mb-4">
        <img class="d-flex mr-3 ml-3 rounded-circle" src="img_avatar.png" style="width:50px;" alt="user pic">
          <div class="media-body">
            <h5 class="mt-0"><?php echo ucfirst($c_name) ?></h5>
            <p><?php echo $c_comment ?></p>
          </div>
        </div>
        <?php } ?>
        <?php } ?>

        

       

        <!-- Comment with nested comments -->
        <!-- <div class="media mb-4">
            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
            <div class="media-body">
              <h5 class="mt-0">Commenter Name</h5>
              Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus
              odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
              fringilla. Donec lacinia congue felis in faucibus.

              <div class="media mt-4">
                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                <div class="media-body">
                  <h5 class="mt-0">Commenter Name</h5>
                  Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus
                  odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
                  fringilla. Donec lacinia congue felis in faucibus.
                </div>
              </div>

              <div class="media mt-4">
                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                <div class="media-body">
                  <h5 class="mt-0">Commenter Name</h5>
                  Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus
                  odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
                  fringilla. Donec lacinia congue felis in faucibus.
                </div>
              </div>

            </div>
          </div> -->

          <?php 
            if(isset($_POST['submit'])){
              $cs_name = mysqli_real_escape_string($connection,$_POST['name']);
              $cs_email = mysqli_real_escape_string($connection,$_POST['email']);
              $cs_comment = mysqli_real_escape_string($connection,$_POST['comment']);
              if(empty($cs_name) or empty($cs_email) or empty($cs_comment)){
                $error_msg = "All (*) fields are Required";
              }else{
                $cs_query = "INSERT INTO `comments` (`id`, `name`, `post_id`, `email`, `comment`, `statuss`) VALUES (NULL, '$cs_name', '$post_id', '$cs_email', '$cs_comment', 'pending')";

                if(mysqli_query($connection, $cs_query)){
                  $msg = "Commment Has Been Submitted and waiting for approval";
                }
                else{
                  $error_msg = "Comment has not been submitted";
                }
              }
            }
          ?>

        <!-- Comments Form -->
        <div class="card my-4">
          <h5 class="card-header">Leave a Comment:</h5>
          <div class="card-body">
            <form action="" method="post">
              <div class="form-group">
                <label class="font-weight-bold" for="full-name">Full Name*:</label>
                <input type="text" class="form-control" name="name" id="full-name" placeholder="Full Name" required>
              </div>
              <div class="form-group">
                <label class="font-weight-bold" for="email">Email*:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
              </div>
              <div class="form-group">
                <label class="font-weight-bold" for="comment">Comment*:</label>
                <textarea class="form-control" name="comment" id="comment" cols="30" rows="10"
                  placeholder="Write comment here..." required></textarea>
              </div>
            
            <input type="submit" style="background-color: #455f7b!important; border:none" name="submit" value="Submit Comment" class="btn btn-primary">
            </form>
          <?php 
          if(isset($error_msg)){
            echo "<span  class='pull-right text-danger'>$error_msg</span>";
          }
          else if(isset($msg)){
            echo "<span class='pull-right text-success'>$msg</span>";
          }
          ?>
          </div>
         
        </div>

      </div>

      <?php require_once('inc/sidebar.php') ?>

      <?php require_once('inc/footer.php') ?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>