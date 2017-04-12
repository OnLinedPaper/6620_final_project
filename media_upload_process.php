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

echo "'$account_id'";

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
                    $insert = "insert into media(name,type,path,account_id)".
                              "values('".urlencode($_FILES["file"]["name"])."',0,'".$_FILES["file"]["type"]."', '$account_id')";
                    $queryresult = mysql_query($insert)
                          or die("Insert into Media error in media_upload_process.php " .mysql_error());
                    $result="0";
                    chmod($upfile, 0644);
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

<meta http-equiv="refresh" content="0;url=browse.php?result=<?php echo $result;?>">
