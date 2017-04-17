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
            echo "S-H-I-T";
        }
        else if($_POST['password1'] != $_POST['password2'])
        {
            #password match fail
            echo "<br><b>Passwords don't match.</b><br>";
        }
        else{
            $query = "UPDATE accounts SET username='".$_POST['username']."' password='".$_POST['password1']."' email='".$_POST['email']."' WHERE account_id = '".$_SESSION['account_id']."'";
            $result = mysql_query($query);
        }
    }

?>

<form action="register.php" method="post">
    Username: <input type="text" name="username" value=<?php echo "\"".$curr_username."\""?>> <br>
    Email: <input type="text" name="email" value=<?php echo "\"".$curr_email."\""?>> <br>
    Old Password: <input type="password" name="password_old"> <br>
    New Password: <input  type="password" name="password1"> <br>
    Repeat New password: <input type="password" name="password2"> <br>
    <input name="submit" type="submit" value="Submit">
</form>


</body>
</html>
