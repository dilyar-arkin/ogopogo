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
        if (isset($_POST["username"]) && isset($_POST["id"])) {
            $pollid= $_POST["id"];   
            $username = $_POST["username"]; 
            mySQLconnection($username,$pollid);  // send user input values to sql processing function
        }
        else{
            echo "<p class = 'warning'> fields are empty, try again </p>"; // if any of the user input values are empty, terminate
        }
    }
    else {
        echo " <p style='font-size : 20px; color : red'>ACCESS DENIED : unacceptable server request!</p>"; //anything other than post method are considered unacceptable, including GET
        die("<p>Connection Method Error!</p>");
    }
    
    function mySQLconnection($username,$pollid){

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
                //To Do List: Verify if such poll exist before delete command
                //$sql1="SELECT * FROM polls WHERE id=".'"'.$pollid.'"'. "AND username=".'"'.$username.'";';
                //$results = mysqli_query($connection, $sql1);
                //$row = mysqli_fetch_assoc($results); //expecting only 1 row since usernames are unique; 
                // -------------------------------------------------------------------------------------
                // Note: need to verify polls to be deleted exists in the database otherwise return error 
                //--------------------------------------------------------------------------------------
                //if($row['username'] == $username && $row['email'] == $username ){
                    $sql = "DELETE FROM polls WHERE username=".'"'.$username.'"'. "AND id=".'"'.$pollid.'";';
                    
                    if (mysqli_query($connection, $sql)) {
                        //$results = mysqli_query($connection, $sql); 
                        echo "Poll id: $pollid is deleted from the database";
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