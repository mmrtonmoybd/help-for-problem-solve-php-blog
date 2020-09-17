<?php

$session_role2 = $_SESSION['role'];
$session_name2 = $_SESSION['name'];

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary navbar-fixed-top">
            <a class="navbar-brand" href="#">Needed MCQS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" target="_blank"  href="../index.php"><i class="fa fa-home"></i> View Blog</a>
                    </li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item mr-3">
                        <a disabled class="nav-link" href="profile.php"><i class="fa fa-user mr-1"></i> <?php echo $session_name2 ?></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="add-post.php"><i class="fa fa-plus-square mr-1"></i>Add Post</a>
                    </li>

                    <?php

                    if($session_role2 == 'admin'){

                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./add-user.php"><i class="fa fa-user-plus mr-1"></i>Add User</a>
                    </li>
                    <?php
                }

                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./profile.php"><i class="fa fa-user mr-1"></i>Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./logout.php"><i class="fa fa-power-off mr-1"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </nav>