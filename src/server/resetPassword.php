<?php session_start(); ?>

<html>

<?php
// check if method is post, else terminate
if($_SERVER['REQUEST_METHOD'] === "POST"){
    if ( isset($_POST["newpassword"]) && isset($_POST["oldpassword"])) {
        $oldpassword =  $_POST["oldpassword"];
        $password = $_POST["newpassword"];   
        $username = $_SESSION['uname'];      
        SQLconnection($username,$oldpassword,$password,$email);  // send user input values to sql processing function
    }
    else{
        echo "<p class = 'warning'> fields are empty, try again </p>"; // if any of the user input values are empty, terminate
    }
}
else {
    echo "<p><a style='color:white;background:red'>error : unacceptable server request</a></p>"; //anything other than post method are considered unacceptable, including GET
    echo "<p><a style='color:white;background:red'> ACCESS DENIED! <a href='../client/index.html'> Go Back</a></a></p>";
    die();
}

function SQLconnection($uname, $Password,$newPassword,$email){
    $Verified = false;
    $host = "mysql-server";
    $database = "ogopogo";
    $user = "webuser";
    $password = "P@ssw0rd";

    $connection = mysqli_connect($host, $user, $password, $database);

    $error = mysqli_connect_error();
    if($error != null){
        $output = "<p>Unable to connect to database!</p>";
        exit($output);
    }
    else
    {
        //good connection, so do you thing
        $sql = "SELECT * FROM users;";

        $results = mysqli_query($connection, $sql);

        //and fetch requsults
        $counter = 0; 
        while ($row = mysqli_fetch_assoc($results))
        {
            //echo $row['username']." ".$row['firstName']." ".$row['lastName']." ".$row['email']." ".$row['password']."<br/>";
            $dbUsername[$counter] = $row['username'];
            $dbpassword[$counter] = $row['password']; 
            //$dbemail[$counter] = $row['email'];
            $counter++;
        }
        $encPassword = md5($Password); //encrypt new password
        for($i=0;$i<=$counter;$i++){
            if(strcasecmp($dbUsername[$i],$uname)==0 && $dbpassword[$i] === $encPassword){
                $success = "<p> user credentials verified</p>";
                //echo $success;
                $Verified = true;
            }
        }
        if($Verified){
            $encNewPassword = md5($newPassword);
            $sql = "UPDATE users SET password = '$encNewPassword' WHERE username = '$uname';";
           // mysqli_query($connection,$newUser);
            if (mysqli_query($connection, $sql)) {
                echo "retset completed successfully ";
              } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($connection);
              }
                
            echo "<p style = 'background:green color:white '> Your password has been updated. For your safety we logged you out. Thank you! ";
            session_destroy();
            echo "<p> Go back to main page <a href='main.php'>HERE</a></p>";
        }
        else{
            echo "old password entered incorrect";
            
            exit("<p><a href='main.php'>Go Back</a></p>");
        }
        mysqli_free_result($results);
        mysqli_close($connection);
    }

}

?>

</html>
