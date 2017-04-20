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
        echo "<a href=\"browse.php\">Back to browse</a><br />";

        if(isset($_POST['create'])){
            #create playlist
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
            if($_POST['newname'] != ""){
                $query = "INSERT INTO list(list_id, account_id, name) VALUES(".$new_list_id.", ".$_SESSION['account_id'].", \"".$_POST['newname']."\");";
                $result = mysql_query($query);
                echo "<b>list created.</b><br />";
            }
            else{
                echo "<b>name cannot be empty</b><br />";
            }
        }
        if(isset($_POST['addto'])){
            #add to list
            $query = "SELECT name FROM list WHERE list_id = ".$_POST['addname']." LIMIT 1";
            #get list name
            $result = mysql_query($query);
            $result_row = mysql_fetch_row($result);
            $list_name = $result_row[0];

            $query = "INSERT INTO list(list_id, account_id, media_id, name) VALUES(";
            $query = $query.$_POST['addname'].", ";
            $query = $query.$_SESSION['account_id'].", ";
            $query = $query.$_GET['id'].", ";
            $query = $query."\"".$list_name."\");";

            $result = mysql_query($query);
            echo "<b>added to list.</b><br />";
        }
        if(isset($_POST['fav'])){
            #add to faves
            $query = "SELECT list_id FROM list WHERE account_id = ".$_SESSION['account_id']." AND name = \"favorites\";";
            $result = mysql_query($query);
            if(!$result_row = mysql_fetch_row($result)){
                #create the table if it's not there

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

                $query = "INSERT INTO list(list_id, account_id, name) VALUES(".$new_list_id.", ".$_SESSION['account_id'].", \"favorites\");";
                $result = mysql_query($query);

                $query = "SELECT list_id FROM list WHERE account_id = ".$_SESSION['account_id']." AND name = \"favorites\";";
                $result = mysql_query($query);
                #get the new list ID
                $result_row = mysql_fetch_row($result);
                $list_id = $result_row[0];
            }
            else{

                $query = "SELECT list_id FROM list WHERE (account_id = ".$_SESSION['account_id']." AND name=\"favorites\") ORDER BY list_id DESC LIMIT 1;";
                $result = mysql_query($query);
                if($result){
                    $result_row = mysql_fetch_row($result);
                    $new_list_id = $result_row[0];
                }
                else{
                    #no playlists exist yet
                    $new_list_id = 0;
                }
            }
            $query = "INSERT INTO list(list_id, account_id, media_id, name) VALUES(";
            $query = $query.$new_list_id.", ";
            $query = $query.$_SESSION['account_id'].", ";
            $query = $query.$_GET['id'].", ";
            $query = $query."\"favorites\");";

            $result = mysql_query($query);
            echo "<b>Added to favorites.</b><br />";

        }
    ?>


    <form action="list.php?id=<?php echo $_GET['id'] ?>" method="post">
        New playlist name: <input type="text" name="newname" rows="1" cols="40" maxlength="40"/>
        <input name="create" type="submit" value="Create" />
    </form>

    <?php
        $query = "SELECT DISTINCT name, list_id FROM list WHERE account_id = ".$_SESSION['account_id'];
        $result = mysql_query($query);
    ?>

    <form action="list.php?id=<?php echo $_GET['id'] ?>" method="post">
        <select name="addname">
        <?php
            while($result_row = mysql_fetch_row($result)){
                echo "<option value=\"".$result_row[1]."\">".$result_row[0]."</option>";
            }
        ?>
        <input name="addto" type="submit" value="Add" />
        </select>
        <input name="fav" type="submit" value="Favorite" />
    </form>

</body>
</html>
