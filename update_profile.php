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

    $query = "SELECT * FROM account WHERE account_id='".$_SESSION['account_id']."'";
    $result = mysql_query($query);
    $result_row = mysql_fetch_row($result);
    /* account_id, type, username, password, email */

    $curr_username = $result_row[2];
    $curr_password = $result_row[3];
    $curr_email = $result_row[4];
?>
</body>
</html>
