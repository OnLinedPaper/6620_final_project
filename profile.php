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

        echo "<a href=\"browse.php\">Back to browse</a></br>";

        if(isset($_GET['id'])){
            $query = "SELECT account.account_id, account.username, media.media_id, media.name FROM account LEFT JOIN media ON account.account_id = media.account_id WHERE account.account_id = ".$_GET['id'];
            #get some data. use left join to still get profile info, even if that profile never uploaded anything.

            $result = mysql_query($query);
            $result_row = mysql_fetch_row($result);
            #account_id, username, media id, medianame
            echo $result_row[0]." : ".$result_row[1]."<br /><br />";
            #echo user id and username

            echo "<br />".$result_row[2]."<br />".$result_row[3]."<br />";
            #print out all media by that user
            while($result_row = mysql_fetch_row($result))
            {
                echo "<br />".$result_row[2]."<br />".$result_row[3]."<br />";
            }
        }

        else{
            #they navigated here, but not by clicking a profile link
            header('Location: browse.php');
        }
    ?>
</body>
</html>
