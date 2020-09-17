<?php require_once('inc/top.php') ?>

<body>

<?php require_once('inc/header.php') ?>



    <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">
<div class="card my-4">
        <h4 class="card-header">Contact Us Form</h4>
        <!-- Blog Post -->
        <div class="card-body my-4">
          <form action="">
            <div class="form-group">
              <label class="font-weight-bold" for="full-name">Full Name*:</label>
              <input type="text" class="form-control" name="" id="full-name" placeholder="Full Name">
            </div>
            <div class="form-group">
              <label class="font-weight-bold" for="email">Email*:</label>
              <input type="email" class="form-control" name="" id="email" placeholder="Email Address">
            </div>
            <div class="form-group">
              <label class="font-weight-bold" for="website">Website:</label>
              <input type="url" class="form-control" name="" id="website" placeholder="Website">
            </div>

            <div class="form-group">
              <label class="font-weight-bold" for="message">Message*:</label>
              <textarea class="form-control" name="" id="message" cols="30" rows="10"
                placeholder="Write message here..."></textarea>
            </div>
          </form>
          <input type="submit" style="background-color: #455f7b!important; border:none" name="submit" value="Submit" class="btn btn-primary">
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