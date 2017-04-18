<html>
<body>
    <?php
        session_start();
        include_once "function.php";

        #this redirects the user if they are not signed in
        if(!isset($_SESSION['username'])){
            echo "uh-oh, you aren't signed in!";
            ?>
            <meta http-equiv="refresh" content="0; url=http://webapp.cs.clemson.edu/~ndreed/metube/index.php" />
            <?php
        }

        if(isset($_GET['id'])){
            $query = "SELECT account.account_id, account.username, media.media_id, media.name FROM account JOIN media ON account.account_id = media.account_id WHERE account.account_id = ".$_GET['id'];
            $result = mysql_query($query);
            $result_row = mysql_fetch_row($result);
            echo $result_row[1];
        }

        else{
            #they navigated here, but not by clicking a profile link
            header('Location: browse.php');
        }
    ?>
</body>
</html>
