  <!-- Sidebar Widgets Column -->
  <div class="col-md-4">

<!-- Search Widget -->
<div class="card my-4">
  <h5 class="card-header">Search</h5>
  <div class="card-body">
    <form class="searchform" action="index.php" method="post">
    <div class="input-group">
      <input name="search-title" type="text" class="form-control" placeholder="Search for...">
      <span class="input-group-append">
        <input name="search" style="background-color: #455f7b!important;" class="btn btn-dark" type="submit" value="Go!">
      </span>
    </div>
    </form>
  </div>
</div>

<!-- Submit Mcqs Widget -->
<div class="card my-4">
  <h5 class="card-header">Submit Mcqs</h5>
  <div class="card-body">
  <a href="submit-mcqs.php" style="text-decoration:none; font-weight:bold; color: #455f7b!important; border:none;" >Submit a Mcqs</a>
  </div>
</div>

<!-- Categories Widget -->
<div class="card my-4">
  <h5 class="card-header">MCQS Categories</h5>
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12">
        <ul class=" mb-0">
        <?php

          $query = "SELECT *FROM categories";
          $run = mysqli_query($connection, $query);
            if(mysqli_num_rows($run) > 0){
              while($row = mysqli_fetch_array($run))
            {

              $category = $row['category'];
              $id  = $row['id'];
        ?>     

    <li>
            <a href='index.php?cat=<?php echo $id ?>' style="text-decoration:none;" ><?php echo ucfirst($category) ?></a>
          </li>
          <?php
  }
}
?>
      
          
         
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Side Widget -->
<!-- <div class="card my-4">
  <h5 class="card-header">Side Widget</h5>
  <div class="card-body">
    You can put anything you want inside of these side widgets. They are easy to use, and feature the new
    Bootstrap 4 card containers!
  </div>
</div> -->



</div>

</div>
<!-- /.row -->

</div>
<!-- /.container -->