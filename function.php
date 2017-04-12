<?php
include "mysqlClass.inc.php";


function user_exist_check ($username, $password, $email){
    $query = "select * from account where username='$username'";
    $result = mysql_query( $query );
    if (!$result){
        die ("user_exist_check() failed. Could not query the database: <br />". mysql_error());
    }
    else {
        $row = mysql_fetch_assoc($result);
        if($row == 0){
            $query = "insert into account (type, username, password, email) values (1,'$username','$password','$email')";
            #account_id is automatically assigned and incremented
            #type is type 1 by default
            #username, password, and email are all set

            echo "insert query:" . $query;
            $insert = mysql_query( $query );
            if($insert)
            #success!
                return 1;
            else
                die ("<br><br>Could not insert into the database: <br />". mysql_error());
        }
        else{
            #uname already exists
            return 2;
        }
    }
}


function user_pass_check($username, $password)
{

    $query = "select * from account where username='$username'";
    echo  $query;
    $result = mysql_query( $query );

    if (!$result)
    {
       die ("user_pass_check() failed. Could not query the database: <br />". mysql_error());
    }
    else{
        $row = mysql_fetch_row($result);
        if(!$row[2])
            return 1; #username doesn't exist
        else if(strcmp($row[3],$password))
            return 2; //wrong password
        else
            return 0; //Checked.
    }
}

function updateMediaTime($mediaid)
{
    $query = "    update  media set lastaccesstime=NOW()
                           WHERE '$mediaid' = mediaid
                    ";
                     // Run the query created above on the database through the connection
    $result = mysql_query( $query );
    if (!$result)
    {
       die ("updateMediaTime() failed. Could not query the database: <br />". mysql_error());
    }
}

function upload_error($result)
{
    //view erorr description in http://us2.php.net/manual/en/features.file-upload.errors.php
    switch ($result){
    case 1:
        return "UPLOAD_ERR_INI_SIZE";
    case 2:
        return "UPLOAD_ERR_FORM_SIZE";
    case 3:
        return "UPLOAD_ERR_PARTIAL";
    case 4:
        return "UPLOAD_ERR_NO_FILE";
    case 5:
        return "File has already been uploaded";
    case 6:
        return  "Failed to move file from temporary directory";
    case 7:
        return  "Upload file failed";
    }
}

function get_account_id_from_username($username)
{
    #takes a username, queries the database, and returns the account_id of that
    #username as a string

    $query = "select * from account where username='$username'";
    #echo $query."<br>";
    $result = mysql_query($query);
    #send the query
    #echo $result."<br>";

    if (!$result){
        die ("get_account_id_from_username() failed. Could not query the database: <br />". mysql_error());
    }

    $row = mysql_fetch_assoc($result);
    #get result
    #echo $row['account_id']."<br>";

    return (string)$row['account_id'];
    #return account_id, which should be the first part of the string
}

function other()
{
    //You can write your own functions here.
}

?>
