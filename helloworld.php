<html>
<body>

    Entered username: <?php echo $_POST['uname']; ?><br>
    Entered email: <?php echo $_POST['email']; ?><br>
    Entered password: <?php echo $_POST['pword']; ?>&nbsp
    <i>(This will not be visible in the final implementation)</i>

    <?php
        $servername = "mysql1.cs.clemson.edu";
        $username = "metube_8ma5";
        $password = "metube6620";
        $database = "metube_w1bj";

        $link = mysqli_connect($servername, $username, $password, $database);
        if(!$link){
            die("connection failed");
        }

    echo "\n\nconnected.";



    mysqli_close($link)

    ?>

</body>
</html>
