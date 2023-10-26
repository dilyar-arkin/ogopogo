<?php 
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        exit("<p style = 'color:red font-style : bold'>Access Denied</p>");
        header('refresh:3','Location: ../client/index.html');
    }
?>
<html>
<?php
// check if method is post, else terminate
if($_SERVER['REQUEST_METHOD'] === "POST"){
    if ( isset($_POST["title"]) && isset($_POST["closedate"]) && isset($_POST["option1"]) && isset($_POST["option2"])) {
        $title =  $_POST["title"];
        $closingdate =  $_POST["closedate"];
        $description = $_POST["description"];
        $option1 = $_POST["option1"];   
        $option2 = $_POST["option2"];
        $option3 = $_POST["option3"];
        $option4 = $_POST["option4"];
        $option5 = $_POST["option5"];
        $option6 = $_POST["option6"];
        SQLconnection($title,$description,$closingdate,$option1,$option2,$option3,$option4,$option5,$option6);  // send user input values to sql processing function
    }
    else{
        echo "<p class = 'warning'> fields are either empty, or not enough information (must have at least two options) </p>"; // if any of the user input values are empty, terminate
    }
}
else {
    echo "error : unacceptable server request. access denied"; //anything other than post method are considered unacceptable, including GET
    echo "<p> BAD Connection Method! <a href='lab9-1.html'> register here</a></p>";
    die();
}

function SQLconnection($title,$description,$closingdate,$option1,$option2,$option3,$option4,$option5,$option6){

    include 'dbActive.php';

    $error = mysqli_connect_error();
    if($error != null){
        $output = "<p>Unable to connect to database!</p>";
        exit($output);
    }
    else
    {
        include "randomIDgenerator.php";
        $username = $_SESSION['uname']; // get user's name from session cache
        $id = generateRandomString();
        $sql = "INSERT INTO polls (id,username,poll_title,current_status,meta_description,close_date,option1,option2,option3,option4,option5,option6) VALUES('$id','$username','$title','open','$description','$closingdate','$option1','$option2','$option3','$option4','$option5','$option6');";
        //above insert will fail if user input contains ' character, example: 'they're equal'    
        // mysqli_query($connection,$newUser);
            if (mysqli_query($connection, $sql)) {
                 echo '<div style="text-align: center"><a style= "padding:4%; background: lightgreen; border-radius: 5%; display:inline-block; height:100px"> Your new poll has been successfully added to the Ogopogo </a></div>';
                 echo "<div style='text-align: center; position:relative; top: -100px;'> <a style = 'background : grey; font-size : 20px; color:white' href='main.php'>GO to Main<br><img src='../client/img/right-arrow.png'></a></div>";
                 
              } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($connection);
              }
        //mysqli_free_result($results);
        $sql2 = "INSERT INTO pollStat(`pollID`,`author`) VALUES"."(".'"'.$id.'"'.","."'".$_SESSION['uname']."');";
        mysqli_query($connection, $sql2);
        mysqli_close($connection);
    }

}
?>
</html>