<?php 
session_start();
if (!isset($_SESSION['loggedin']) || strcmp($_SESSION['uname'],'admin')!=0) {
    session_destroy();
    header('Location: ../client/index.html');
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src = "../client/js/jquery-3.7.0.js"></script>
        <script src="js/adminManagesUsers.js"></script>
        <script></script>
        <style>
            form{margin: 0.5em;}
            fieldset{margin: 0.5em;}
            legend{color: orange;}
            input{margin: 0.25em;color: #000;}
            label{margin: 0.25em;}
            div{text-align: center;
                margin-top: 0;
                margin-bottom: 0;
                margin-left: auto;
                margin-right: auto;}
            body{
                background: #504A4B;
                color: whitesmoke;
            }
            table{
                margin-top: 0;
                margin-bottom: 0;
                margin-left: auto;
                margin-right: auto;
                border: 1px solid black;
                border-collapse: collapse;
                font-family:Verdana, Geneva, Tahoma, sans-serif;
                
            }
            th{padding: 1em;}
            td{padding: 0.5em;}
            tr{
                text-align: center;
                border: 1px solid black;
                border-collapse: collapse;
                padding: 0.5em;
            }
            tr:nth-child(even){
                background-color: #3A3B3C;
            }
            a.inner {
                color: #000;
                background-color: wheat;
                padding: 0.2em;
                margin: 0.5em;
                border-radius: 10px;
            }
            p{
                font-size: 30px;
                font-weight: bolder;
                font-family: sans-serif ;
            }
        </style>
    </head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
            <a class="navbar-brand">Ogopogo</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="main.php"><span class="glyphicon glyphicon-arrow-left"></span> Return Main</a></li>
            </ul>
            </div>
        </div>
    </nav>
    <div>
        <p> Users Management Tool </p>
        <div style="width: 300px; text-align:left">
            
                <fieldset>
                    <legend>Detele User</legend>
                    <label>enter username: </label>
                    <input type="text" name="username" id="username" value=""><br>
                    <label>enter user's email</label>
                    <input type="text" name="email" id="email"value=""><br>
                    <input type="submit" id="DeleteUser">
                </fieldset>
            
        </div>
        <div style="text-align: center;"><a id="deleteStatus"></a></div>
        <p>Full Users List</p>
        <?php

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

                
                if (mysqli_query($connection, $sql)) {
                    //echo "<p>connection established successfully<p> ";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($connection);
                }
                
                $results = mysqli_query($connection, $sql); 
                //and fetch requsults
                echo "<div>";
                echo "<table>
                        <tr><th>user name</th><th>first name</th><th>last name</th><th>email</th><th>city</th><th>province</th><th>user type</th><th>badge</th></tr>";
                while ($row = mysqli_fetch_assoc($results))
                {
                    //echo $row['username']." ".$row['firstName']." ".$row['lastName']." ".$row['email']." ".$row['password']."<br/>";
                    echo "<tr>";
                    echo "<td>".$row['username']."</td>";
                    echo "<td>".$row['firstName']."</td>";
                    echo "<td>".$row['lastName']."</td>";
                    echo "<td>".$row['email']."</td>";
                    echo "<td>".$row['city']."</td>";
                    echo "<td>".$row['province']."</td>";
                    echo "<td>".$row['usertype']."</td>";
                    echo "<td>".$row['badge']."</td>";
                    echo "</tr>";

                }
                echo "</table>";
                echo "</div>";
                
                
                mysqli_free_result($results);
                mysqli_close($connection);
            }

        ?>
        <br>
        <span><a href="main.php">Back to Main</a></span>
    </div>
</body>
</html>
