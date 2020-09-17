
<?php require_once('inc/top.php'); ?>

<body>

<?php require_once('inc/header.php'); ?>






<div class="row">

<!-- Blog Entries Column -->
<div class="col-md-8">
<form action="check.php" method="post">
  <?php

  for ($i=1; $i < 6; $i++) { 
    # code...


    $query = "SELECT *FROM questions WHERE q_id = $i";
      $run = mysqli_query($connection, $query);
        mysqli_num_rows($run);
          while($row = mysqli_fetch_array($run))
        {
          $question = $row['question'];
?>

<div class='card my-4'>
      <h6 class='card-header'><?php echo $question; ?></h6>
      <?php
          $ansquery = "SELECT *FROM answers WHERE ans_id = $i";
          $ansrun = mysqli_query($connection, $ansquery);
            mysqli_num_rows($ansrun);
              while($ansrow = mysqli_fetch_array($ansrun))
            {
              $a_id = $ansrow['a_id'];
              $answers = $ansrow['answer'];
    ?>
            <div class="card-body py-0">
            <input class="my-2 " type="radio" name="quizcheck[]" value=" <?php echo $a_id; ?>">
           
            <?php echo $answers;  ?>
            </div>
       
         
      
<?php
        }
      }
      
    }

?>
  
  </div>
 

  </div>
  <input type="submit" name="submit" class="btn btn-primary m-auto">
  <br>
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

