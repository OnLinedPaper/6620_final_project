<?php
session_start();

//insert into favourite table
$insert = "INSERT INTO favourite(account_id, media_id)";
$insert = $insert."VALUES('$account_id', '$media_id')";
$queryresult = mysql_query($insert)
or die("Insert into Favourites error in favourites_process.php " .mysql_error());

?>
