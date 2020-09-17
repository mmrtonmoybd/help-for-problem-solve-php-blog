 <!-- Navigation -->
 <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #455f7b!important;">
    <div class="container">
      <a class="navbar-brand" href="index.php">Needed MCQS</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
        aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact_us.php">Contact Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Privacy Policy</a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="submit-mcqs.php">Submit Mcqs</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">
    <br>
    <!-- Menu -->

    
  

              <nav class="navbar navbar-expand-lg navbar-dark"
              style="background-color: #455f7b!important; text-transform: uppercase;">
        
              <!-- Toggler/collapsibe Button -->
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
              </button>
        
              <!-- Links -->
              <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
        
                  <li class="nav-item">
                    <a class="nav-link" href="index.php">Home
                    </a>
                  </li>

                  <?php

                      $query = "SELECT *FROM categories";
                      $run = mysqli_query($connection, $query);
                        if(mysqli_num_rows($run) > 0){
                          while($row = mysqli_fetch_array($run))
                        {

                          $category = $row['category'];
                          $id  = $row['id'];

                          echo "  
                          <li class='nav-item'>
                          <a class='nav-link' href ='index.php?cat=".$id."'>$category</a>
                        </li>";
                        }
                      }
                  ?>
                 
                </ul>
              </div>
            </nav>  

   
