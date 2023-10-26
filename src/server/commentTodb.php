<?php session_start(); ?>
<html>
<?php
   if (!isset($_SESSION['loggedin'])) {
    echo "<p>You Are Not a Registered User. Please <a href='../client/login.html'>login</a> to vote!</p>";
      exit;
  }
  else{

// check if method is post, else terminate
if($_SERVER['REQUEST_METHOD'] === "POST"){
    if (isset($_POST["pollID"]) && isset($_POST["sessionUser"])&& isset($_POST["comment"])) {
        $pollID =  $_POST["pollID"];  
        $sessionUser = $_POST["sessionUser"];
        $comment = $_POST["comment"];

        $connection = mysqli_init();
        mysqli_real_connect($connection, "dilyar-db.mysql.database.azure.com", "DilyarArkin", "{Yulghun987*}", "{ogopogo}", 3306);
        if (mysqli_connect_errno($connection)) {
        die('Failed to connect to MySQL: '.mysqli_connect_error());
        }
        $error = mysqli_connect_error();
        if($error != null){
            $output = "<p>Unable to connect to database!</p>";
            exit($output);
        }
        else
        {
            include "randomIDgenerator.php";
            $commentid = generateRandomString();
            //good connection, so do you thing
            $sql = "INSERT INTO comments(commentid, pollID, author, description) VALUES("."'".$commentid."'".",'".$pollID."',"."'".$sessionUser."'".",'".$comment."'".");";
            if (mysqli_query($connection, $sql)) {
                echo 'Comment Submitted!';
             } else {
               echo "Error: " . $sql . "<br>" . mysqli_error($connection);
             }
            //$row = mysqli_fetch_assoc($results);   
            mysqli_close($connection);
        }
   
    }
    else{
        echo "<p class = 'warning'> fields are empty, try again </p>"; // if any of the user input values are empty, terminate
        exit;
    }
}
else {
    echo "error : unacceptable server request. access denied"; //anything other than post method are considered unacceptable, including GET
    echo "<p> BAD Connection Method! <a href='login.php'> register here</a></p>";
    die();
}
}

?>
