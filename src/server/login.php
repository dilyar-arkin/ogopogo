<?php 
session_start();
$islogged = $_SESSION['isloggedin'];
if(isset($islogged)){
    session_destroy();
    header('Location: ../client/index.html');
    exit; // security measure - if there is an existing session prior to register, destroy that session
} 

?>

<html>
    
<?php
// check if method is post, else terminate
if($_SERVER['REQUEST_METHOD'] === "POST"){
    if ( isset($_POST["username"]) && isset($_POST["password"])) {
        $password = $_POST["password"];   
        $username = $_POST["username"];   
        mySQLconnection($username,$password);  // send user input values to sql processing function
    }
    else{
        echo "<p class = 'warning'> fields are empty, try again </p>"; // if any of the user input values are empty, terminate
    }
}
else {
    echo " <p style='font-size : 20px; color : red'>ACCESS DENIED : unacceptable server request!</p>"; //anything other than post method are considered unacceptable, including GET
    die("<p>Connection Method Error!</p>");
}

function mySQLconnection($uname,$Password){
    $loginSuccess = false;
    $conn = mysqli_init();
    mysqli_ssl_set($conn,NULL,NULL, "{DigiCertGlobalRootCA.crt}", NULL, NULL);
    mysqli_real_connect($conn, "dilyar-db.mysql.database.azure.com", "DilyarArkin", "{Yulghun987*}", "{ogopogo}", 3306, MYSQLI_CLIENT_SSL);
    if (mysqli_connect_errno($conn)) {
        die('Failed to connect to MySQL: '.mysqli_connect_error());
    }
    $connection = $conn;

    $error = mysqli_connect_error();
    if($error != null){
        $output = "<p>Unable to connect to database!</p>";
        exit($output);
    }
    else
    {
        //good connection, so do you thing
        $sql = "SELECT * FROM users ;";

        $results = mysqli_query($connection, $sql);

        //and fetch requsults
        $counter = 0; 
        while ($row = mysqli_fetch_assoc($results))
        {
            //echo $row['username']." ".$row['firstName']." ".$row['lastName']." ".$row['email']." ".$row['password']."<br/>";
            $dbUsername[$counter] = $row['username'];
            $dbPassword[$counter] = $row['password']; 
            $dbEmail[$counter] = $row['email'];
            $dbfname[$counter] = $row['firstName'];
            $dblname[$counter] = $row['lastName'];
            $dbbadge[$counter] = $row['badge'];
            $dbUsertype[$counter] = $row['usertype'];
            $dbCity[$counter] = $row['city'];
            $dbProvince[$counter] = $row['province'];
            $dbPhoto[$counter] = $row['photo'];
            
            $counter++;
        }
        $encPassword = md5($Password);

        for($i=0;$i<$counter;$i++){
            //echo "<p>$dbPassword[$i]  $encPassword </p>"; // for dubugging only
            // admin password is p@ssw0rd
            if(strcasecmp($dbUsername[$i],$uname)==0 && $dbPassword[$i] === $encPassword ){
                //echo "window.open('home.php')";
                $loginSuccess = true;
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['uname'] = $dbUsername[$i];
                $_SESSION['usertype'] = $dbUsertype[$i];
		        $_SESSION['email'] = $dbEmail[$i];
                $_SESSION['fname'] = $dbfname[$i];
                $_SESSION['lname'] = $dblname[$i];
                $_SESSION['badge'] = $dbbadge[$i];
                $_SESSION['city'] = $dbCity[$i];
                $_SESSION['province'] = $dbProvince[$i];
                $_SESSION['photo'] = $dbPhoto[$i];
                $success = "<p>login success: credentials are validated</p>";
		        echo '<div style="text-align: center"><a style= "padding:4%; background: lightgreen; border-radius: 5%; display:inline-block; height:100px"> Welcome ' . $_SESSION['uname'] . '!' . '</a></div>';
                //echo $success;
                echo "<div style='text-align: center; position:relative; top: -100px;'> <a style = 'background : grey; font-size : 20px; color:white' href='main.php'>Go to Home<br><img src='../client/img/right-arrow.png'></a></div>";
                //exit($success);               
            }

        }
        if(!$loginSuccess){
                
                function erromsg(){
                    echo "<div style = 'text-align: center;'><a style = 'background : red; font-size : 20px'> username and/or password are invalid! </a></div>";
                }
                erromsg();
                exit("<div style = 'text-align: center;'><a style = 'background : red; font-size : 20px'> Return to login page</a><br><a href = '../client/login.html'><img src ='../client/img/back_button.png'></a></div>");
        }
        mysqli_free_result($results);
        mysqli_close($connection);
    }


}

?>

</html>
