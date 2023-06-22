<?php session_start(); ?>
<html>
<?php

// check if method is post, else terminate
if($_SERVER['REQUEST_METHOD'] === "GET"){

    if (isset($_GET["pollId"])) {
        $pollID =  $_GET["pollId"];  
    
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
            $sql = "SELECT * FROM polls WHERE id="."'".$pollID."';";

            $results = mysqli_query($connection, $sql);
            //and fetch requsults
            $counter = 0; 
            $row = mysqli_fetch_assoc($results);
            
            $author = $row['username'];
            $pollID = $row['id'];
            $title = $row['poll_title'];
            $status = $row['current_status'];
            $description=$row['meta_description'];
            $closedate = $row['close_date'];
            $option1 = $row['option1'];
            $option2 = $row['option2'];
            if(!empty($row['option3'])){$option3 = $row['option3'];}
            if(!empty($row['option4'])){$option4 = $row['option4'];}
            if(!empty($row['option5'])){$option5 = $row['option5'];}
            if(!empty($row['option6'])){$option6 = $row['option6'];}
            mysqli_free_result($results);
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

?>
	<head>
		<meta charset="utf-8">
		<title>Ogopogo Polls</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link rel="stylesheet" href="css/poll.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src = "../client/js/jquery-3.7.0.js"></script>
        <script src = "js/renderDisplayPoll.js"></script>
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
            <a href="main.php" class="navbar-brand">Ogopogo</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li id="search"><a href="#">search posts</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right" id="logInlogOut">
                <li><a href="main.php" id="logoutbutt"><span class="glyphicon glyphicon-log-out"></span> Return</a></li>
            </ul>
            </div>
        </div>
    </nav>
    <div class="content home">
    <p>Welcome, you will need to vote in order to see the poll results!</p>    
	<form>
        <fieldset>
            <legend><?php echo $GLOBALS['title'];?></legend>
            <span id="pollID" hidden><?php echo $pollID;?><br></span>
            <span>Closing Time (dd:hh:mm:ss):  </span>
            <span style="background:orange ; color : white; padding:0.2em; border-radius: 5px" id="dueDate"><?php echo $closedate;?> <br></span>
            <span><br>Genre: <?php echo $description;?> <br> by: </span>
            <span id="username"><?php echo $author;?> <br></span>
            <div class="pollBox">
            <?php 
                echo '<input type="radio" id="op1" class="vote" name="vote" value='.$option1.'>';
                echo '<label class="update" for="op1"> '.$option1.'</label><br>';
                echo '<input type="radio" id="op2" class="vote" name="vote" value='.$option2.'>';
                echo '<label class="update" for="op2"> '.$option2.'</label><br>';
                if(!empty($row['option3'])){    
                    echo '<input type="radio" id="op3" class="vote" name="vote" value='.$option3.'>';
                    echo '<label class="update" for="op3"> '.$option3.'</label><br>';
                }
                if(!empty($row['option4'])){    
                    echo '<input type="radio" id="op4" class="vote" name="vote" value='.$option4.'>';
                    echo '<label class="update" for="op4">'.$option4.'</label><br>';
                }
                if(!empty($row['option5'])){    
                    echo '<input type="radio" id="op5" class="vote" name="vote" value='.$option5.'>';
                    echo '<label class="update" for="op5">'.$option5.'</label><br>';
                }
                if(!empty($row['option6'])){    
                    echo '<input type="radio" id="op6" class="vote" name="vote" value='.$option6.'>';
                    echo '<label class="update" for="op6">'.$option6.'</label><br>';
                }
                // future re-factoring : use other method to re-factor above code
            ?>
            <div id="submitPoll"><a href="#" class="create-poll">Submit Poll</a></div>
            </div>
        </fieldset>
    </form>
    <div class="pollResult" id="pollStat"></div>
    <div id="previousComments">
        <table id="commentTable">
            <thead>
                <th class="left">comment left by</th>
                <th class="right">on</th>
            </thead>
            <tbody id="commentTableBody"></tbody>
        </table>
    </div>
    <div class="leaveComment">
        <p>
        <span>Welcome <span id = "sessionuser"><?php echo $_SESSION['uname'];?></span>, leave a comment ...</span>
        </p> 
        <form>
        <textarea class="comment" style="width: 950px;" placeholder="Add your comments here"></textarea>  
        <div> <a href="#" id="commentButt" class="create-poll">Submit comment</a></div>
        </form>
    </div>
    <div id="commentTodb"></div>   
    </body>
</html>
<?php 
?>