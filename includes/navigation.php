<?php

?>

<nav>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-4">
                <p id="nav-info"></p>
            </div>

            <div class="col-md-2 nav-item">
                <p><a href="index.php?page=home">Home</a></p>
            </div>



            <?php
                if (isset($_SESSION['username'])) {
            ?>

            <div class="col-md-2 nav-item">
                <p><a href="index.php?page=chat">Chat</a></p>
            </div>

            <div class="col-md-2 nav-item">
                <p><a href="index.php?page=logout">Logout</a></p>
            </div>

            <?php
                } else {
            ?>

            <div class="col-md-2 nav-item">
                <p><a href="index.php?page=login">Login</a></p>
            </div>

            <?php
                }
            ?>
        </div>
        



    </div>
</nav>