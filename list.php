<html>
<body>
    <?php
        session_start();
        include_once "function.php";

        if(!isset($_SESSION['username'])){
            echo "uh-oh, you aren't signed in!";
            ?>
            <meta http-equiv="refresh" content="0; url=http://webapp.cs.clemson.edu/~ndreed/metube/index.php" />
            <?php
        }

        if(isset($_POST['create'])){
            echo $_POST['newname'].": S-H-I-T<br />";
        }
    ?>


    <form action="list.php?id=<?php echo $_GET['id'] ?>" method="post">
        <textarea name="newname" rows="1" cols="40" maxlength="40"/>New playlist name...</textarea>
        <input name="create" type="submit" value="Create" />
    </form>

</body>
</html>
