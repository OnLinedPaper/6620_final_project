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
        if(isset($_POST['submit'])){
            echo $_POST['category'];
        }
    ?>


<p>Welcome <?php echo $_SESSION['username'];?><br>
    Your account number is <?php echo $_SESSION['account_id'] ?><br>
<a href="update_profile.php">Update Profile</a>
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

<br/><br/>

<!-- This section displays the uploaded media -->
<?php

    $query = "SELECT media.media_id, media.name, media.path, account.account_id, account.username, media.type ";
    $query = $query."FROM media ";
    $query = $query."JOIN account ON media.account_id = account.account_id ";
    #$query = $query."LEFT JOIN interaction ON media.account_id = interaction.account_id ";
    $result = mysql_query( $query );
    #media_id, name, path, account_id, username
    if (!$result){
       die ("Could not query the media table in the database: <br />". mysql_error());
    }

?>

    <div style="background:#339900;color:#FFFFFF; width:150px;">Uploaded Media</div>
    <form action="media.php" method="post">
        <select name="category">
            <option value="all">
                (All media)
            </option>
            <option value="image">
                Images
            </option>
            <option value="video">
                Videos
            </option>
            <option value="other">
                Other
            </option> <br />
            <input name="submit" type="submit" value="Submit" />
        </select>

    </form>

    <!-- Display uploaded media as a table of links and IDs -->
    <table width="50%" cellpadding="0" cellspacing="0">
        <?php
            while ($result_row = mysql_fetch_row($result))
            #media_id, name, path, account_id, username
            {
                $mediaid = $result_row[0];
                $filename = $result_row[1];
                $filenpath = $result_row[2];
                $uploader_id = $result_row[3];
                $uploader_username = $result_row[4];
        ?>
             <tr valign="top">
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
                            <!--file download link-->
                            <a href="<?php echo str_replace(' ', '+', $filenpath);?>" download>Download</a>
                        </td>
                        <td>
                            <a href="profile.php?id=<?php echo $uploader_id ?>"><?php echo $uploader_username; ?></a>
                        </td>
        </tr>
            <?php
            }
        ?>
    </table>
   </div>
</body>
</html>
