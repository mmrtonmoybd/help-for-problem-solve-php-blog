
  <?php require_once('inc/top.php'); ?>

<body>

<?php require_once('inc/header.php');


    $number_of_posts = 5;

    if(isset($_GET['page'])){
      $page_id = $_GET['page'];
    }
    else{
      $page_id = 1;
    }

    if(isset($_GET['cat'])){
      $cat_id = $_GET['cat'];
      $cat_query = "SELECT * FROM categories WHERE id = $cat_id";
      $cat_run  = mysqli_query($connection, $cat_query);
              if(mysqli_num_rows($cat_run) > 0){

                $cat_row = mysqli_fetch_array($cat_run);
              
            $cat_name = $cat_row['category'];
    
  }
}

// if(isset($_GET['author'])){
//   $auth = $_GET['author'];

//   // $auth_query = "SELECT *FROM posts WHERE author_username = $auth_posts";
//   // $auth_run  = mysqli_query($connection, $auth_query);

//   //         if(mysqli_num_rows($auth_run) > 0){

//   //           $auth_row = mysqli_fetch_array($auth_run);
          
//   //       $auth_name = $auth_row['author_username'];

// //}

// }



       if(isset($_POST['search'])){
         $search = mysqli_real_escape_string($connection,$_POST['search-title']);
         $all_posts_query = "SELECT * FROM posts WHERE statuss = 'publish'";
        $all_posts_query .= " and tags LIKE '%$search%'";
        $all_posts_run = mysqli_query($connection, $all_posts_query);
  
        $all_posts = mysqli_num_rows($all_posts_run);

        $total_pages = ceil($all_posts / $number_of_posts);

        $posts_start_from = ($page_id - 1) * $number_of_posts;
       }
       else{
        $all_posts_query = "SELECT * FROM posts WHERE statuss = 'publish'";

        if(isset($cat_name)){
          $all_posts_query .= " and category = '$cat_name'";
        }

        // else if(isset($auth_name)){
        //   $all_posts_query .= " and author_username = '$auth'";
        // }

        $all_posts_run = mysqli_query($connection, $all_posts_query);
        
        $all_posts = mysqli_num_rows($all_posts_run);

        $total_pages = ceil($all_posts / $number_of_posts);

        $posts_start_from = ($page_id - 1) * $number_of_posts;
       }
        
       

?>
 
    <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">

        <?php

            if(isset($_POST['search'])){
              $search = $_POST['search-title'];
              $query = "SELECT *FROM posts WHERE statuss = 'publish'";
              $query .= " and tags LIKE '%$search%'";
              $query .= " ORDER BY id DESC LIMIT $posts_start_from , $number_of_posts" ;
            }
            else{

              $query = "SELECT *FROM posts WHERE statuss = 'publish'";

            if(isset($cat_name)){
              $query .= " and category = '$cat_name'";
            }

            // else if(isset($auth_name)){
            //   $query .= " and author_username = '$auth'";
            // }

            $query .= " ORDER BY id DESC LIMIT $posts_start_from , $number_of_posts" ;
            }

            $run = mysqli_query($connection, $query);
              if(mysqli_num_rows($run) > 0){
                while($row = mysqli_fetch_array($run))
              {
                $id = $row['id'];
                $title  = $row['title'];
                $author  = $row['author'];
                $post_data = $row['post_data'];
            echo "
            <div class='card my-4'>
            <a href='post.php?post_id=$id' style='text-decoration: none;'>
            <h6 class='card-header'><strong>$title</strong></h6>
          </a>
                  <div class='card-body py-0'>
                    <p class='card-text'>$post_data</p>
                  </div>
                  <div class='card-footer text-muted'>
                  Submitted by: <strong style='color: #455f7b!important;'>$author</strong>
                  </div>
                </div>
            ";
   
              }

            }
            
     ?>
              
        
      

        <!-- Pagination -->
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item">
              <!-- <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a> -->
            </li>

            <?php
            
              for ($i=1; $i<=$total_pages; $i++) { 
                echo "
                
                <li class='".($page_id == $i ? 'page-item active' : '')."'> <a class='page-link' href='index.php?page=".$i.(isset($cat_name)?"&cat=$cat_id" : "")."'>$i</a></li>

                ";
              }  

            ?>
            <li class="page-item">
              <!-- <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a> -->
            </li>
          </ul>
        </nav>

      </div>

      <?php require_once('inc/sidebar.php'); ?>

      <?php require_once('inc/footer.php'); ?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>