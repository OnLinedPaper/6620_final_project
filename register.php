<html>
<body>

<?php
session_start();

include_once "function.php";

if(isset($_POST['submit'])) {
    if( $_POST['passowrd1'] != $_POST['passowrd2']) {
        $register_error = "Passwords don't match. Try again?";
    }
    else {
        $check = user_exist_check($_POST['username'], $_POST['passowrd1'], $_POST['email']);
        if($check == 1){
            //echo "Rigister succeeds";
            $_SESSION['username']=$_POST['username'];

            #set the $_SESSION['account_id']
            $query = "SELECT account_id FROM account WHERE username='".$_SESSION['username']."'";
            $result = mysql_query($query);
            $result_row = mysql_fetch_row($result);
            $_SESSION['account_id'] = $result_row[0];

            header('Location: browse.php');
        }
        else if($check == 2){
            $register_error = "Username already exists. Please user a different username.";
        }
    }
}

?>
<form action="register.php" method="post">
    Username: <input type="text" name="username" maxlength="40"> <br>
    Email: <input type="text" name="email" maxlength="40"> <br>
    Create Password: <input  type="password" name="passowrd1" maxlength="40"> <br>
    Repeat password: <input type="password" name="passowrd2" maxlength="40"> <br>
    <input name="submit" type="submit" value="Submit">
</form>

<?php
  if(isset($register_error))
   {  echo "<div id='passwd_result'> register_error:".$register_error."</div>";}
?>

</body>
</html>
