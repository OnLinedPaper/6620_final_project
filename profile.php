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


        #this part deals with contact, friend/for, blocking
        if(isset($_POST['submit'])){
            $testquery = "SELECT * FROM interaction WHERE account_id = ".$_SESSION['account_id']." AND target_id = ".$_GET['id'];

            $testresult = mysql_query($testquery);
            if(mysql_num_rows($testresult) == 0)
            {
                echo "S-H-I-T";
            }
            else {
                echo "B-I-T-C-H";
            }


            $query = "INSERT INTO interaction (account_id, target_id, contact, friend, foe, blocked) VALUES (";
            #initial statement
            $query = $query.$_SESSION['account_id'].", ";
            #add the account id
            $query = $query.$_GET['id'].", ";
            #add the target id
            $query = $query.(isset($_POST['contact']) ? "true" : "false").", ";
            #contact is true if it's checked, otherwise false
            $query = $query.(isset($_POST['friendfoe']) ? (($_POST['friendfoe'] == "friend") ? "true" : "false") : "false").", ";
            #friend is true if that's the radio selected; else it's false
            $query = $query.(isset($_POST['friendfoe']) ? (($_POST['friendfoe'] == "foe") ? "true" : "false") : "false").", ";
            #foe is true if that's the radio selected; else it's false
            $query = $query.(isset($_POST['block']) ? "true" : "false").");";
            #block is true if set; else it's false
            #...mother of all queries

            echo "<br /><br />".$query."<br /><br />";

            $result = mysql_query($query);
        }


        if(isset($_GET['id']) and $_GET['id'] != ""){
            $query = "SELECT account.account_id, account.username, media.media_id, media.name, media.path FROM account LEFT JOIN media ON account.account_id = media.account_id WHERE account.account_id = ".$_GET['id'];
            #get some data. use left join to still get profile info, even if that profile never uploaded anything.

            $result = mysql_query($query);
            $result_row = mysql_fetch_row($result);
            #account_id, username, media id, medianame, mediapath
            echo "account id: ".$result_row[0]."<br />username: ".$result_row[1]."<br />";
            #echo user id and username
            if($_GET['id'] != $_SESSION['account_id']){
                #this is someone else's page.
                ?>
                <form action="profile.php?id=<?php echo $_GET['id'] ?>" method="post">
                    <input type="checkbox" name="contact" value="add" />Add contact<br />
                    <input type="radio" name="friendfoe" value="friend" />Set friend<br />
                    <input type="radio" name="friendfoe" value="foe" />Set foe<br />
                    <input type="checkbox" name="block" value="block" />Block user<br />
                    <input name="submit" type="submit" value="Submit" />
                    <input type="reset" value = "Reset" /><br />
                </form>
                <?php
            }
            else{
                #this is their page!
                echo "(This is your page!)<br /><br />";
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
