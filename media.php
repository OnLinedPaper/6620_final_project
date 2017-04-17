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
if(isset($_GET['id'])) {
    $query = "SELECT * FROM media WHERE media_id='".$_GET['id']."'";
    $result = mysql_query( $query );
    #media_id, name, type, path, last_access_time, account_id, ip, upload_time
    $result_row = mysql_fetch_row($result);

    //updateMediaTime($_GET['id']);

    $filename=$result_row[1];   ////1, 3, 2
    $filepath=$result_row[3];
    $type=$result_row[2];
    #expects type to be a string
    if(substr($type,0,5)=="image") //view image
    {
        echo "Viewing Picture: ".$filename."<br>";
        echo "(uploaded on ".$result_row[4].")<br><br>";
        echo "<img src='".$filepath."'/>";
    }
    elseif(substr($type,0,5)=="video") //view movie
    {
?>
    <p>Viewing Video: <?php echo $filename;?></p>

    <video width="320" height="240" controls>
        <source src=<?php echo "'$filepath'";?> type=<?php echo "'$type'";?>>
            Video is not supported.
    </video>

<?php
    }
}
else
{
    echo "alert: unsupported file type";
?>
<meta http-equiv="refresh" content="0;url=browse.php">
<?php
}
?>
</body>
</html>
