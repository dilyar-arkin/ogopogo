<?php 
    session_start();
    if (isset($_SESSION['loggedin'])) {
        session_destroy();
        header("refresh:5; Location: ../client/index.html");
        exit("existing session has been cleared, try again later");
    }

?>
<html>
<?php
// check if method is post, else terminate
if($_SERVER['REQUEST_METHOD'] === "POST"){
    if ( isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["userName"]) && isset($_POST["password"]) && isset($_POST["email"]) ) {
        $firstname =  $_POST["firstName"];
        $lastname =  $_POST["lastName"];
        $email = $_POST["email"];
        $password = $_POST["password"];   
        $username = $_POST["userName"];
        $city = $_POST["city"];   
        $province = $_POST["province"];   
        SQLconnection($username,$email,$firstname,$lastname,$password,$city,$province);  // send user input values to sql processing function
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

function SQLconnection($username, $email,$firstname,$lastname,$Password,$city,$province){
    $newUser = true;
    include 'dbActive.php';

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
            $dbEmail[$counter] = $row['email']; 
            $counter++;
        }
        for($i=0;$i<=$counter;$i++){
            if(strcasecmp($dbUsername[$i],$username)==0 || strcasecmp($dbEmail[$i],$email)==0 ){
                $existingUserError = "<p><a style='background:red;color:white'>error: this user already exist with same username and/or email!</p><p><a href='main.php'>return main page</a></a></p>";
                $newUser = false;
                exit($existingUserError);
            }
        }
        if($newUser){
            $encPassword = md5($Password); //encrypting password using md5 function
            $sql = "INSERT IGNORE INTO users (username,firstName,lastName,email,password,city,province,usertype,photo,badge) VALUES ('$username','$firstname','$lastname','$email','$encPassword','$city','$province','user','','newbie');";
           // mysqli_query($connection,$newUser);
            if (mysqli_query($connection, $sql)) {
                 echo '<div style="text-align: center"><a style= "padding:4%; background: lightgreen; border-radius: 5%; display:inline-block; height:100px"> New User Registration Successful! </a></div>';
                //echo $success;
                 echo "<div style='text-align: center; position:relative; top: -100px;'> <a style = 'background : grey; font-size : 20px; color:white' href='main.php'>Login Now<br><img src='../client/img/right-arrow.png'></a></div>";
                
              } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($connection);
              }
        
        }
        mysqli_free_result($results);
        mysqli_close($connection);
    }

}
?>
</html>