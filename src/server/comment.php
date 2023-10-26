<?php
      
      if($_SERVER['REQUEST_METHOD'] === "GET"){
        if ( isset($_GET["pollID"])) {
            $pollID =  $_GET["pollID"];
            //establish connection with the database
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
                $sql = "SELECT * FROM comments WHERE pollID="."'".$pollID."';";
                $results = mysqli_query($connection, $sql);
                while($row = mysqli_fetch_assoc($results)){
                    echo '<tr><td class="left">'.$row['author'].'</td><td class="right">'.$row['time_stamp'].'</td></tr>';
                    echo "<tr><td colspan='2'>".$row['description']."</td>";
                }
                //mysqli_free_result($results);
                mysqli_close($connection);
            }
        }
        else{
            echo "<p class = 'warning'> input fields are either empty, or not enough information (make sure to select an option) </p>"; // if any of the user input values are empty, terminate
        }
    }
    else {
        echo "error : unacceptable server request. access denied"; //anything other than post method are considered unacceptable, including GET
        echo "<p> BAD Connection Method! <a href='lab9-1.html'> register here</a></p>";
        die();
    }
?>