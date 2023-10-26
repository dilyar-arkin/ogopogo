<?php 
session_start();
if(isset($_SESSION["loggedin"])){
    session_destroy();
    header('Location: ../client/index.html');
}

?>
<html>

    <?php
    // check if method is post, else terminate
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if ( isset($_POST["username"]) && isset($_POST["fname"]) && isset($_POST["lname"])&&isset($_POST["email"]) ) {
            $username =  $_POST["username"];
            $firstname = $_POST["fname"];   
            $lastname = $_POST["lname"];   
            $email = $_POST["email"];   
            SQLconnection($username,$firstname,$lastname,$email);  // send user input values to sql processing function
        }
        else{
            echo "<p class = 'warning'> fields are empty, try again </p>"; // if any of the user input values are empty, terminate
        }
    }
    else {
        echo "error : unacceptable server request. access denied"; //anything other than post method are considered unacceptable, including GET
        echo "<p> BAD Connection Method! <a href='../client/registerNewUser.html'> register here</a></p>";
        die();
    }

    function SQLconnection($uname, $fname,$lname,$email){
        //echo $uname ." , ". $fname ." , ". $lname ." , ". $email ; 
        $Verified = false;
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
            //good connection, so do you thing
            $sql = "SELECT * FROM users;";

            $results = mysqli_query($connection, $sql);

            //and fetch requsults
            $counter = 0; 
            while ($row = mysqli_fetch_assoc($results))
            {
                //echo $row['username']." ".$row['firstName']." ".$row['lastName']." ".$row['email']." ".$row['password']."<br/>";
                $dbUsername[$counter] = $row['username'];
                $dbFname[$counter] = $row['firstName']; 
                $dbLname[$counter] = $row['lastName'];
                $dbEmail[$counter] = $row['email'];
                $counter++;
            }

            for($i=0;$i<=$counter;$i++){
                if(strcasecmp($dbUsername[$i],$uname)==0 && strcasecmp($dbFname[$i],$fname)==0 && strcasecmp($dbLname[$i],$lname)==0 && strcasecmp($dbEmail[$i],$email)==0 ){
                    $success = "<p>user credentials successfully verified</p>";
                    echo $success;
                    $Verified = true;
                }
            }
            if($Verified){
            ?>
                <form method="POST" action="resetPassword.php">
                <label>new Password: </label>
                <input type='password' name='newpassword' id='newpassword' class='required' required><br>
                <label>re-enter new Password:</label>
                <input type='password' name='newpasswordC' id='newpassword2'class='required' required><br>
                <input type='submit' id='sendPass' value='submit'>
                <input type='reset' id='reset' value='reset'>
                </form>

            <?php
            }
            else{
                echo "Username/password entered incorrect";
                exit();
            }
            
            mysqli_free_result($results);
            mysqli_close($connection);
        

    }
    }
    ?>

</html>