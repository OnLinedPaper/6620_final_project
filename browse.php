<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
    include_once "function.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media browse</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<script type="text/javascript" src="js/jquery-latest.pack.js"></script>
<script type="text/javascript">
function saveDownload(id)
{
    $.post("media_download_process.php",
    {
       id: id,
    },
    function(message)
    { }
     );
}
</script>
<style>
    td{
        padding: 4px;
    }
</style>
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
    #for viewing specific media
    #(defaults to "all")
        if(isset($_POST['submit'])){
            $category = $_POST['category'];
        }
        else{
            $category = "all";
        }
    ?>


<p>Welcome <?php echo $_SESSION['username'];?><br>
    Your account number is <?php echo $_SESSION['account_id'] ?><br>
    <a href="<?php echo "profile.php?id=".$_SESSION['account_id'] ?>">Your profile</a>
    <a href="update_profile.php">Update Profile</a>
    <a href="view_list.php">View lists</a>
</p>

<!--This section is the "Upload File" link-->
<a href='media_upload.php'  style="color:#FF9900;">Upload File</a>
<div id='upload_result'>
<?php
    if(isset($_REQUEST['result']) && $_REQUEST['result']!=0)
    {
        echo upload_error($_REQUEST['result']);
    }
?>
</div>

<br/>

<!-- This section displays the uploaded media -->
<?php

    $query = "SELECT media.media_id, media.name, media.path, account.account_id, account.username, media.type, interaction.media_blocked, media.upload_time, media.views ";
    $query = $query."FROM media ";
    $query = $query."JOIN account ON media.account_id = account.account_id ";
    $query = $query."LEFT JOIN interaction ON (media.account_id = interaction.account_id AND ".$_SESSION['account_id']." = interaction.target_id) ";

    if(isset($_POST['submit2'])){
        if($_POST["order"] == "recent"){
            $query = $query."ORDER BY media.upload_time DESC";
            echo "<b>Sorting most recent first</b><br />";
        }
        else if($_POST["order"] == "views"){
            $query = $query."ORDER BY media.views DESC";
            echo "<b>Sorting most viewed first</b><br />";
        }
        else{
            echo "<br />";
        }
    }
    if(isset($_POST['search'])){
        #search by keywords
        $query = $query."JOIN media_metadata ON media.media_id = media_metadata.media_id WHERE (";
        $words = explode(" ", $_POST['searchbar']);
        foreach($words as &$oneword){
            $query = $query."media_metadata.keyword = \"".$oneword."\" OR ";
        }
        $query = $query."media_metadata.keyword = \" \");";
    }
    $query = $query.";";

    $result = mysql_query( $query );
    #media_id, name, path, account_id, username, type
    if (!$result){
       die ("Could not query the media table in the database: <br />". mysql_error());
    }

?>

    <div style="background:#339900;color:#FFFFFF; width:150px;">Uploaded Media</div>
    <form action="browse.php" method="post">
        <input type="text" name="searchbar" rows="1" cols="40"/>Keyword search...</textarea>
        <input name="search" type="submit" value="Search" />
    </form>
    <form action="browse.php" method="post">
        <select name="category">
            <option value="all">(All media)</option>
            <option value="image">Images</option>
            <option value="video">Videos</option>
            <option value="other">Other</option> <br />
            <input name="submit" type="submit" value="Submit" />
        </select>
    </form>

    <form action="browse.php" method="post">
        <select name="order">
            <option value="all">(Unordered)</option>
            <option value="recent">Most Recent</option>
            <option value="views">Most Viewed</option>
            <input name="submit2" type="submit" value="Submit" />
        </select>
    </form>

    <!-- Display uploaded media as a table of links and IDs -->
    <table width="100%">
        <?php
            while ($result_row = mysql_fetch_row($result))
            #media_id, name, path, account_id, username
            {
                $mediaid = $result_row[0];
                $filename = $result_row[1];
                $filenpath = $result_row[2];
                $uploader_id = $result_row[3];
                $uploader_username = $result_row[4];
                $type = $result_row[5];
                $blocked = $result_row[6];
                $upload_time = $result_row[7];
                $views = $result_row[8];

                if(!$blocked and ($category=="all" or substr($type,0,5)==$category or ($category=="other" and substr($type,0,5) != "video" and substr($type,0,5) != "image"))){
        ?>
        <tr>
            <td>
                    <?php
                        echo $mediaid;  //mediaid
                    ?>
            </td>
            <td>
                <!--display file name-->
                <!--this link takes us to media.php, with the media id sent via GET for media.php to use-->
                <a href="media.php?id=<?php echo $mediaid;?>" target="_blank"><?php echo $filename;?></a>
            </td>
            <td>
                <!--upload time-->
                Uploaded on <?php echo $upload_time ?> by <a href="profile.php?id=<?php echo $uploader_id ?>"><?php echo $uploader_username; ?></a>
            </td>
            <td>
                <!--views-->
                Views: <?php echo $views ?>
            </td>
            <td>
                <!--file download link-->
                <a href="<?php echo str_replace(' ', '+', $filenpath);?>" download>Download</a>
            </td>
            <td>
                <!--list add link-->
                <a href="list.php?id=<?php echo $mediaid ?>" target="_blank">Add to list</a>
            </td>
        </tr>
            <?php
                }
            }
        ?>
    </table>
   </div>
</body>
</html>
