<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
    include_once "function.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media</title>
<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body>
    <?php
    #this redirects the user if they are not signed in
        if(!isset($_SESSION['username']))
        {
            echo "uh-oh, you aren't signed in!";
            ?>
            <meta http-equiv="refresh" content="0; url=http://webapp.cs.clemson.edu/~ndreed/metube/index.php" />
            <?php
        }
    ?>

<?php
if(isset($_GET['id'])) {

    if(isset($_POST['submit'])){
        #insert a comment.
        $query = "INSERT INTO comments (media_id, account_id, comment) VALUES (";
        $query = $query.$_GET['id'].", ";
        $query = $query.$_SESSION['account_id'].", ";
        $query = $query."\"".$_POST['comment']."\");";
        echo "<b>Comment added.<br /></b>";

        $result = mysql_query($query);
    }
    else{
        #increment view by one (don't increment view after every comment)
        $query = "UPDATE TABLE media SET views = views + 1;";
        $result = mysql_query($query);
    }


    $query = "SELECT name, path, type, upload_time, account_id FROM media WHERE media_id='".$_GET['id']."'";
    $result = mysql_query( $query );
    #name, path, type, upload_time
    $result_row = mysql_fetch_row($result);

    //updateMediaTime($_GET['id']);

    $filename=$result_row[0];
    $filepath=$result_row[1];
    $type=$result_row[2];
    $date=$result_row[3];
    $uploader_id=$result_row[4];
    #expects type to be a string
    if(substr($type,0,5)=="image") //view image
    {
        echo "Viewing Picture: ".$filename."<br>";
        echo "(uploaded on ".$date.")<br><br>";
        echo "<img src='".str_replace(' ', '+', $filepath)."' alt='".$filename."'/>";
    }
    elseif(substr($type,0,5)=="video") //view video
    {
?>
    <p>Viewing Video: <?php echo $filename;?></p>

    <video width="320" height="240" controls>
        <source src=<?php echo "'$filepath'";?> type=<?php echo "'$type'";?>>
            Video is not supported.
    </video>

<?php
    }
    else //unsupported
    {
        echo "alert! unsupported file type: ".$type;
    }

    #insert comment form
    $allowed_query = "SELECT blocked FROM interaction WHERE account_id=";
    $allowed_query = $allowed_query.$uploader_id." AND target_id=";
    $allowed_query = $allowed_query.$_SESSION['account_id'].";";

    $allowed_result = mysql_query($allowed_query);
    $allowed_row = mysql_fetch_row($allowed_result);

    if(!$allowed_row[0]){
        #if not comment blocked
    ?>
        <form action="media.php?id=<?php echo $_GET['id'] ?>" method="post">
            <input type="textarea" name="comment" rows="4" cols="40" />
            <input type="submit" name="submit" value="Submit comment" />
        </form>

    <?php
    }
    #comments section
    $comment_query = "SELECT comments.account_id, comments.comment, account.username FROM comments JOIN account ON comments.account_id = account.account_id WHERE comments.media_id = ".$_GET['id'];
    #get all comments whose media id is the currently viewed media
    $comment_result = mysql_query($comment_query);
    while ($comment_row = mysql_fetch_row($comment_result)){
        #for each comment
        $account_id = $comment_row[0];
        $comment_str = $comment_row[1];
        $username = $comment_row[2];
        echo "<br />Account: ".$account_id."<br />User: ".$username."<br />\"".$comment_str."\"<br />";
    }


}
else
{
?>
<meta http-equiv="refresh" content="0;url=browse.php">
<?php
}
?>
</body>
</html>
