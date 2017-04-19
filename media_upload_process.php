<?php
session_start();
include_once "function.php";

/******************************************************
*
* upload document from user
*
*******************************************************/

$username=$_SESSION['username'];
$account_id=get_account_id_from_username($username);

echo $account_id;

//Create Directory if doesn't exist
if(!file_exists('uploads/'))
    mkdir('uploads/', 0757);
    #create the uploads folder if it does not already exist

$dirfile = 'uploads/'.$username.'/';
if(!file_exists($dirfile))
    mkdir($dirfile,0755);
    chmod( $dirfile,0755);
    #make the individual user's upload folder
    if($_FILES["file"]["error"] > 0 )
    {     $result=$_FILES["file"]["error"];} //error from 1-4
    else
    {
        $upfile = $dirfile.urlencode($_FILES["file"]["name"]);

      if(file_exists($upfile))
      {
          $result="5"; //The file has been uploaded.
      }
      else{
            if(is_uploaded_file($_FILES["file"]["tmp_name"]))
            {
                if(!move_uploaded_file($_FILES["file"]["tmp_name"],$upfile))
                {
                    $result="6"; //Failed to move file from temporary directory
                }
                else /*Successfully upload file*/
                {
                    //insert into media table
                    $insert = "insert into media(name,type,path,account_id,upload_time)".
                              "values('".urlencode($_FILES["file"]["name"])."','".$_FILES["file"]["type"]."','./uploads/$username/".$_FILES["file"]["name"]."','$account_id',CURRENT_TIMESTAMP)";
                    $queryresult = mysql_query($insert)
                          or die("Insert into Media error in media_upload_process.php " .mysql_error());
                    $result="0";
                    chmod($upfile, 0644);

                    $query = "SELECT media_id FROM media ORDER BY upload_time DESC LIMIT 1;";
                    #get media_id of most recently uploaded file, hopefully this one
                    $result = mysql_query($query);
                    $id = mysql_fetch_row($result);

                    $words = explode(" ", $_POST['keywords']);
                    foreach ($words as &$oneword){
                        $query = "INSERT INTO media_metadata(media_id, keyword) VALUES(".$id[0].", \"".$oneword."\");";
                        echo $query."<br />";
                    }
                }
            }
            else
            {
                    $result="7"; //upload file failed
            }
        }
    }

    //You can process the error code of the $result here.
?>

<!--<meta http-equiv="refresh" content="0;url=browse.php?result=<?php echo $result;?>">
