<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
session_start();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Favourites</title>
</head>
<body>


<!-- This section displays the favourite media -->
<?php

    $query = "SELECT favourite.media_id, media.name, account.account_id, account.username, media.type, interaction.media_blocked ";
    $query = $query."FROM Favourite ";
    $query = $query."JOIN account ON favourite.account_id = account.account_id ";
	$query = $query."JOIN media ON favourite.media_id = media.media_id ";
    $query = $query."LEFT JOIN interaction ON (favourite.account_id = interaction.account_id AND ".$_SESSION['account_id']." = interaction.target_id);";
    $result = mysql_query( $query );
    #favourite media_id, name, account_id, username, type
    if (!$result){
       die ("Could not query the favourites table in the database : <br />". mysql_error());
    }

?>


<form method="post" action="favourites_process.php">
	<p style="margin:0; padding:0">
		<h2>Your Favourites</h2>
	</p>
</form>


<!-- Display favourite media as a table of links and IDs -->
<table width="50%" cellpadding="0" cellspacing="0">
	<?php
		while ($result_row = mysql_fetch_row($result))
		#media_id, name, path, account_id, username
		{
			$mediaid = $result_row[0];
			$filename = $result_row[1];
			$uploader_id = $result_row[2];
			$uploader_username = $result_row[3];
			$type = $result_row[4];
			$blocked = $result_row[5];

			if(!$blocked and ($category=="all" or substr($type,0,5)==$category or ($category=="other" and substr($type,0,5) != "video" and substr($type,0,5) != "image")))
			{
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
						<a href="profile.php?id=<?php echo $uploader_id ?>"><?php echo $uploader_username; ?></a>
					</td>
				</tr>
				<?php
			}
		}
	?>
</table>

</body>
</html>
