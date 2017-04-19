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

        if(isset($_GET['id']) and $_GET['id'] != ""){
            $query = "SELECT account.account_id, account.username, media.media_id, media.name, media.path FROM account LEFT JOIN media ON account.account_id = media.account_id WHERE account.account_id = ".$_GET['id'];
            #get some data. use left join to still get profile info, even if that profile never uploaded anything.

            $result = mysql_query($query);
            $result_row = mysql_fetch_row($result);
            #account_id, username, media id, medianame, mediapath
            echo "account id: ".$result_row[0]."<br />username: ".$result_row[1]."<br /><br />";
            #echo user id and username
            if($_GET['id'] != $_SESSION['account_id']){
                echo "S-H-I-T<br />";
            }
            else{
                echo "(This is your page!)<br />";
            }


            echo "<b>uploaded media:<br /></b>";
            #print out all media by that user
            do{
                echo "<br /><a href=\"".str_replace(' ', '+', $result_row[4])."\" download>".$result_row[2]."</a> : <a href=\"media.php?id=$result_row[2]\" target=\"_blank\">".$result_row[3]."</a><br />";
            }while($result_row = mysql_fetch_row($result));
        }

        else{
            #they navigated here, but not by clicking a profile link
            header('Location: browse.php');
        }
    ?>
</body>
</html>
