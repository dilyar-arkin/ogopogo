<?php 
session_start();
if (!isset($_SESSION['loggedin']) || strcmp($_SESSION['uname'],'admin')!=0) {
    session_destroy();
    header('Location: ../client/index.html');
    exit;
}
?>
<?php   
    // check if method is post, else terminate
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if (isset($_POST["username"]) && isset($_POST["email"])) {
            $email= $_POST["email"];   
            $username = $_POST["username"]; 
            mySQLconnection($username,$email);  // send user input values to sql processing function
        }
        else{
            echo "<p class = 'warning'> fields are empty, try again </p>"; // if any of the user input values are empty, terminate
        }
    }
    else {
        echo " <p style='font-size : 20px; color : red'>ACCESS DENIED : unacceptable server request!</p>"; //anything other than post method are considered unacceptable, including GET
        die("<p>Connection Method Error!</p>");
    }
    
    function mySQLconnection($username,$email){
            $conn = mysqli_init();
            mysqli_ssl_set($conn,NULL,NULL, "{DigiCertGlobalRootCA.crt}", NULL, NULL);
             mysqli_real_connect($conn, "dilyar-db.mysql.database.azure.com", "DilyarArkin", "{Yulghun987*}", "{ogopogo}", 3306, MYSQLI_CLIENT_SSL);
            if (mysqli_connect_errno($conn)) {
                die('Failed to connect to MySQL: '.mysqli_connect_error());
            }
            $connection = $conn;
           // $host = "mysql-server";
           // $database = "ogopogo";
           // $user = "webuser";
           // $password = "P@ssw0rd";

           // $connection = mysqli_connect($host, $user, $password, $database);

            $error = mysqli_connect_error();
            if($error != null){
                $output = "<p>Unable to connect to database!</p>";
                exit($output);
            }
            else
            {
                //good connection, so do you thing
                $sql1="SELECT * FROM users WHERE username=".'"'.$username.'"'. "AND email=".'"'.$email.'";';
                $results = mysqli_query($connection, $sql1);
                $row = mysqli_fetch_assoc($results); //expecting only 1 row since usernames are unique; 
                // -------------------------------------------------------------------------------------
                // Note: need to verify user to be deleted exists in the database otherwise return error 
                //--------------------------------------------------------------------------------------
                //if($row['username'] == $username && $row['email'] == $username ){
                    $sql = "DELETE FROM users WHERE username=".'"'.$username.'"'. "AND email=".'"'.$email.'";';
                    
                    if (mysqli_query($connection, $sql)) {
                        //$results = mysqli_query($connection, $sql); 
                        echo "User $username is deleted from the database";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
                    }
                //}
                /*
                else{
                    echo "No Such User Found in the Database, enter correct information";
                }
                */
                //and fetch requsults
                //mysqli_free_result($results);
                mysqli_close($connection);
            }
    }
?>