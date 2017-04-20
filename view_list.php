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

        if(isset($_POST['view'])){
            #view list
            $query = "SELECT name FROM list WHERE list_id = ".$_POST['viewname']." LIMIT 1";
            #get list name
            $result = mysql_query($query);
            $result_row = mysql_fetch_row($result);
            $list_name = $result_row[0];

            $query = "SELECT DISTINCT media_id FROM list WHERE list_id = ".$_POST['viewname'];
            $result = mysql_query($query);
            $result_row = mysql_fetch_row($result);
            #skip the empty result

            while($result_row = mysql_fetch_row($result)){
                echo "<a href=\"media.php?id=".$result_row[0]."\" target=\"_blank\">$result_row[0]</a><br />";
            }
        }


            $query = "SELECT DISTINCT name, list_id FROM list WHERE account_id = ".$_SESSION['account_id'];
            $result = mysql_query($query);
        ?>

        <form action="view_list.php?id=<?php echo $_GET['id'] ?>" method="post">
            <select name="viewname">
            <?php

                while($result_row = mysql_fetch_row($result)){
                    echo "<option value=\"".$result_row[1]."\">".$result_row[0]."</option>";
                }
            ?>
            <input name="view" type="submit" value="View" />
            </select>
        </form>

</body>
</html>
