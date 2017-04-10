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
        #this data is all correct

        $link = mysqli_connect($servername, $username, $password, $database);
        #connect to database
        if(!$link){
            #if link does not exist, connection failed.
            die("connection failed");
        }

    echo "<br><br>connected.";

    $query = "SELECT * FROM account";
    #a sample query

    $result = mysqli_query($link, $query) or die("query failed");
    echo "<br><br>queried successfully."

    mysqli_close($link)

    ?>

</body>
</html>
