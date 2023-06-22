<?php
    session_start();
    if (!isset($_SESSION['loggedin'])) {
      echo "<p>You Are Not a Registered User. Please <a href='../client/login.html'>login</a> to vote!</p>";
	    exit;
    }
    else{

      if($_SERVER['REQUEST_METHOD'] === "POST"){
        if ( isset($_POST["username"]) && isset($_POST["pollID"]) && !($_POST["castedVote"] === 'undefined')) {
            $username =  $_POST["username"];
            $pollID =  $_POST["pollID"];
            $castedVote = $_POST["castedVote"];
            //establish connection with the database
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
              $sql = "SELECT * FROM polls WHERE id="."'".$pollID."'"."AND username="."'".$username."';";
              $results = mysqli_query($connection, $sql);
              $row = mysqli_fetch_assoc($results);
              $option;
              if(strcmp($row['option1'],$castedVote)==0){$option = "option1";}
              elseif(strcmp($row['option2'],$castedVote)==0){$option = "option2";}
              elseif(strcmp($row['option3'],$castedVote)==0){$option = "option3";}
              elseif(strcmp($row['option4'],$castedVote)==0){$option = "option4";}
              elseif(strcmp($row['option5'],$castedVote)==0){$option = "option5";}
              elseif(strcmp($row['option6'],$castedVote)==0){$option = "option6";}
              
              $poll_answers;
              for($i=1;$i<=6;$i++){
                $poll_answers[$i]=$row["option". $i];
              }
              //echo "SELECT * FROM polls WHERE id="."'".$pollID."'"."AND username="."'".$username."';";
              $sql2 = "SELECT "."`".$option."`"." FROM `pollStat` WHERE `pollID` ="."'".$pollID."';";
              //echo "SELECT $option"."FROM pollStat WHERE pollID ="."'".$pollID."';";
              $results = mysqli_query($connection, $sql2);
              $row = mysqli_fetch_assoc($results);
              $vote = $row["$option"];
              $vote = $vote+1;
              $sql3 = "UPDATE pollStat SET "."`".$option."`"."= ".$vote. " WHERE pollID ="."'".$pollID."';";
              mysqli_query($connection, $sql3);
              echo "<div id = 'sessionUser'>". $_SESSION['uname']."<strong> has sucessfully casted a vote</strong><br><br></div>";
              
              $sql4 = "SELECT * FROM `pollStat` WHERE pollID="."'".$pollID."';";
              $results = mysqli_query($connection, $sql4);
              $row = mysqli_fetch_assoc($results);
              
              $poll_counts;
              $total_votes = 0;
              for($i=1;$i<=6;$i++){
                $poll_counts[$i]=$row["option". $i];
                $total_votes = $total_votes + $poll_counts[$i]; 
              }
              
              //$row = mysqli_fetch_assoc($results);
              echo  "<div class='content poll-result'>";
              echo  "<div class='wrapper'>";
              echo  "<div class='poll-question'>";
              
              for($i=1;$i<=6;$i++){
                if(isset($poll_answers[$i])&& isset($poll_counts[$i])){
                    echo "<p>$poll_answers[$i]<span>($poll_counts[$i] Votes)</span></p>" ; 
                    echo  "<div class='result-bar' style= 'width:".@round(($poll_counts[$i]/$total_votes)*100)."%'>".
                            @round(($poll_counts[$i]/$total_votes)*100)."%</div>";
                } 
              }
              echo  "</div>";
              echo  "</div>";
              echo  "</div>";

            //mysqli_free_result($results);
              mysqli_close($connection);
            }
        }
        else{
            echo "<p class = 'warning'> input fields are either empty, or not enough information (make sure to select an option) </p>"; // if any of the user input values are empty, terminate
        }
    }
    else if($_SERVER['REQUEST_METHOD'] === "GET"){
      if (isset($_GET["pollID"])){

          $pollID = $_GET["pollID"];
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
              $sql4 = "SELECT * FROM `pollStat` WHERE pollID="."'".$pollID."';";
              $results = mysqli_query($connection, $sql4);
              $row = mysqli_fetch_assoc($results);
              
              $poll_counts;
              $total_votes = 0;
              for($i=1;$i<=6;$i++){
                $poll_counts[$i]=$row["option". $i];
                $total_votes = $total_votes + $poll_counts[$i]; 
              }
              
              //$row = mysqli_fetch_assoc($results);
              echo  "<div class='content poll-result'>";
              echo  "<div class='wrapper'>";
              echo  "<div class='poll-question'>";
              
              for($i=1;$i<=6;$i++){
                if(isset($poll_counts[$i])){
                    echo "<p><span>($poll_counts[$i] Votes)</span></p>" ; 
                    echo  "<div class='result-bar' style= 'width:".@round(($poll_counts[$i]/$total_votes)*100)."%'>".
                            @round(($poll_counts[$i]/$total_votes)*100)."%</div>";
                } 
              }
              echo  "</div>";
              echo  "</div>";
              echo  "</div>";
            }

      }

    }
    else {
        echo "error : unacceptable server request. access denied"; //anything other than post method are considered unacceptable, including GET
        echo "<p> BAD Connection Method! <a href='lab9-1.html'> register here</a></p>";
        die();
    }
    }
?>