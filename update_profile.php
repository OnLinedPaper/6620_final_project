<html>
<body>
Under construction
<script>window.stop()</script>

<?php
    session_start();
    include_once "function.php";

    #this redirects the user if they are not signed in
    if(!isset($_SESSION['username']))
    {
        echo "uh-oh, you aren't signed in!";
        ?>
        <meta http-equiv="refresh" content="0; url=http://webapp.cs.clemson.edu/~ndreed/metube/index.php" />
        <?php
    }

    

?>
</body>
</html>
