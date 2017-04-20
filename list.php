<html>
<body>
    <?php
        session_start();
        include_once "function.php";

        if(!isset($_SESSION['username'])){
            echo "uh-oh, you aren't signed in!";
            ?>
            <meta http-equiv="refresh" content="0; url=http://webapp.cs.clemson.edu/~ndreed/metube/index.php" />
            <?php
        }

        if(isset($_POST['create'])){
            $query = "SELECT list_id FROM list ORDER BY list_id DESC LIMIT 1;";
            $result = mysql_query($query);
            if($result){
                $result_row = mysql_fetch_row($result);
                $new_list_id = $result_row[0];
                $new_list_id = $new_list_id + 1;
            }
            else{
                #no playlists exist yet
                $new_list_id = 0;
            }

            $query = "INSERT INTO list(list_id, account_id, name) VALUES(".$new_list_id.", ".$_SESSION['account_id'].", \"".$_POST['newname']."\");";
            $result = mysql_query($query);

            echo $query.": S-H-I-T<br />";
        }
    ?>


    <form action="list.php?id=<?php echo $_GET['id'] ?>" method="post">
        <textarea name="newname" rows="1" cols="40" maxlength="40"/>New playlist name...</textarea>
        <input name="create" type="submit" value="Create" />
    </form>

</body>
</html>
