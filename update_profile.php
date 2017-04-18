<html>
<body>

<?php
    session_start();
    include_once "function.php";

    #this redirects the user if they are not signed in
    if(!isset($_SESSION['username']))
    {
        echo "uh-oh, you aren't signed in!";
        ?>
        <meta http-equiv="refresh" content="0; url=http://webapp.cs.clemson.edu/~ndreed/metube/index.php" />
        <?php
    }

    $query = "SELECT * FROM account WHERE account_id='".$_SESSION['account_id']."'";
    $result = mysql_query($query);
    $result_row = mysql_fetch_row($result);
    /* account_id, type, username, password, email */

    $curr_username = $result_row[2];
    $curr_password = $result_row[3];
    $curr_email = $result_row[4];

    if(isset($_POST['submit']))
    {
        #update time
        if($_POST['password_old'] != $curr_password)
        {
            #password mismatch
            echo "<br><b>Old password is incorrect.</b><br>";
        }
        else if($_POST['password1'] != $_POST['password2'])
        {
            #password match fail
            echo "<br><b>New passwords don't match.</b><br>";
        }
        else if($curr_username != $_POST['username'] and get_account_id_from_username($_POST['username']) != "")
        {
            echo "That username is taken already.";
        }
        else{
            if($_POST['password1'] == "") {
                #they didn't want to change their password
                $new_password = $curr_password;
            }
            else {
                $new_password = $_POST['password1'];
            }

            if($_POST['username'] == "") {
                #they didn't want to change their username
                $new_username = $curr_username;
            }
            else {
                $new_username = $_POST['username'];
            }

            if($_POST['email'] == "") {
                #they didn't want to change their email
                $new_email = $curr_email;
            }
            else {
                $new_email = $_POST['email'];
            }

            $query = "UPDATE account SET username='".$new_username."', password='".$new_password."', email='".$new_email."' WHERE account_id=".$_SESSION['account_id']."";
            $result = mysql_query($query);

            $_SESSION['username'] = $new_username;

            header('Location: browse.php');
        }
    }

?>

<a href="browse.php">Back to browse</a>

<form action="update_profile.php" method="post">
    Username: <input type="text" name="username" value=<?php echo "\"".$curr_username."\""?>> <br>
    Email: <input type="text" name="email" value=<?php echo "\"".$curr_email."\""?>> <br>
    New Password: <input  type="password" name="password1"> <br>
    Repeat New password: <input type="password" name="password2"> <br>
    Old Password: <input type="password" name="password_old"> (REQUIRED)<br>
    <input name="submit" type="submit" value="Submit">
</form>


</body>
</html>
