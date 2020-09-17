
  <?php require_once('inc/top.php'); ?>

<body>

<?php require_once('inc/header.php');

?>
<?php

            if(isset($_POST['submit'])){
                    $title = mysqli_real_escape_string($connection,$_POST['title']);
                    $post_data = mysqli_real_escape_string($connection,$_POST['post-data']);
                    $category = mysqli_real_escape_string($connection,$_POST['cat']);
                    $name = mysqli_real_escape_string($connection,$_POST['name']);
                    $email = mysqli_real_escape_string($connection,$_POST['email']);

                    if(empty($title) or empty($post_data) or empty($category) or empty($name)){
                        $error = "All (*) fields are required";
                    }
                    else{
                        $insert_query = "INSERT INTO `posts` (`title`, `author`, `author_username`, `category`, `post_data`, `views`, `statuss`) VALUES ('$title', '$name', '$email', '$category', '$post_data', '0', 'draft')";

                        if(mysqli_query($connection, $insert_query)){

                            $msg = "Mcqs has been submitted and waiting for Admin Approval";

                            $title = "";
                            $post_data = "";
                            $category = "";
                            $name = "";
                            $email = "";
                        }
                        else{
                            $error = "Mcqs has not been submitted, please try again";
                        }
                    }
                }

                    ?>
 
    <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">
      <?php
                    if(isset($error)){
                        echo "<span class = 'text-right text-danger'>$error</span>";
                    }
                    else if(isset($msg)){
                            echo "<span class = 'text-align-right text-success'>$msg</span>";
                        }

                        ?>
      <div class="card my-4">
          <h4 class="card-header">Submit a Mcqs</h4>
          <div class="card-body">
          <p class="text-danger">Please Read Below Instructions Before Submitting Any MCQS</p>
          <p>(1) Before submitting any mcqs please check if that mcqs is not already available in this site (seach that mcqs in search bar), if that mcqs is already available in our site then your mcqs will not be approved</p>
          <p>(2) Please fill all fields, and also your Name for your credit, (your Email is optional)</p>
          <p>(3) Must submit a valid and correct mcqs with correct option, so that it can be helpful for others.</p>
          <p>(4) Invalid or Incorrect mcqs will not be approved by the Admin</p>
          <p>(5) If you want to be Author of our site then Please <a href="contact_us.php"> Contact Us</a> with your details</p>
          <hr>
          <br>
            <form action="" method="post">

            <div class="form-group">
                <label class="font-weight-bold" for="title">Title:<p class="d-inline text-danger">*</p></label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Largest university of Pakistan is?" required>
              </div>

              <div class="form-group">
                <label class="font-weight-bold" for="post-data">Mcqs Options:<p class="d-inline text-danger">*</p></label>
                <textarea class="form-control" name="post-data" id="post-data" cols="30" rows="10"
                  placeholder="A. Sindh     B. Karachi      C. Punjab correct answer       D. Fast" required></textarea>
              </div>

              <div class="form-group">
                <label class="font-weight-bold" for="cat">Category:<p class="d-inline text-danger">*</p></label>
                <input type="text" class="form-control" name="cat" id="cat" placeholder="e.g; general knowledge" required>
              </div>

              <div class="form-group">
                <label class="font-weight-bold" for="name">Name:<p class="d-inline text-danger">*</p></label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name" required>
              </div>

              <div class="form-group">
                <label class="font-weight-bold" for="email">Email: (optional)</label>
                <input type="email" class="form-control mb-5" name="email" id="email" placeholder="Enter Your Email">
              </div>
              
            
            <input type="submit" style="background-color: #455f7b!important; border:none" name="submit" value="Submit MCQS" class="btn btn-primary">
          </div>
          </form>
         
        </div>

        
      </div>

      <?php require_once('inc/sidebar.php'); ?>

      <?php require_once('inc/footer.php'); ?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>