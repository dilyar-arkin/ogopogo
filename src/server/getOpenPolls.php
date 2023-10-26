<?php session_start();?>
<!DOCTYPE html>
<html>
<body>
<?php


$connection = mysqli_init();
mysqli_real_connect($connection, "dilyar-db.mysql.database.azure.com", "DilyarArkin", "{Yulghun987*}", "{ogopogo}", 3306);
if (mysqli_connect_errno($connection)) {
die('Failed to connect to MySQL: '.mysqli_connect_error());
}
$error = mysqli_connect_error();

if($error != null)
{
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else
{
//we are looping through all posts to verify and update close_status by comparing it with current time
        $sql = "SELECT * FROM polls";
        $results = mysqli_query($connection, $sql);  
        $today = date("Y-m-d h:i:s"); 
        $currentTime =  strtotime($today);
        while ($row = mysqli_fetch_assoc($results)){
            $dbTime = strtotime($row['close_date']);
            if($dbTime < $currentTime){
                $sql1 = "UPDATE polls SET current_status='closed' WHERE id="."'".$row['id']."'".";";
                if (mysqli_query($connection, $sql1)) {
                    //echo "<p>updated susccessfully<p> ";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($connection);
                }
            }
        }


// print all open polls for dynamic display
if(strcmp($_GET["option"],"open")==0){
    $sql = "SELECT * FROM polls WHERE current_status ='open' ORDER BY close_date;";
    $results = mysqli_query($connection, $sql);    
    echo "
    <table class='table-striped' id = 'openPollsTable'>
    <tr id='tHead'>
    <th class='col-sm-10 text-left ' >Open For Votes</th>
    <th class='col-sm-0 text-left'>Closing Date/Time</th>
    </tr>";
    $counter = 1;
    while($row = mysqli_fetch_assoc($results)) {
    echo "<tr>";
    echo "<td id='".$row['id']."'"."name='title' class='col-sm-10 text-left'><a id='polltitle' href='/src/server/displayPoll.php?pollId=".$row['id']."'>". $row['poll_title'] . "</a></td>";
    echo "<td class='col-sm-0' id='time$counter"."'>" . $row['close_date'] . "</td>";
    echo "</tr>";
    $counter++;
    }
    echo "</table>";

}
//display popular polls
elseif (strcmp($_GET["option"],"popular")==0){
    
    echo $username;
    $sql = "SELECT * FROM polls WHERE current_status = ". '"'.'closed'.'";';
    $results = mysqli_query($connection, $sql);
    echo "
    <table class='table-striped' id = 'PopularPollsTable'>
    <tr id='tHead'>
    <th class='col-sm-10 text-left ' >Popular Votes (> 3 comments) </th>
    <th class='col-sm-0 text-left'>Closing Date/Time</th>
    </tr>";
    $counter = 1;
    while($row = mysqli_fetch_assoc($results)) {
    echo "<tr>";
    echo "<td id='".$row['id']."'"." name='title' class='col-sm-10 text-left'><a id='polltitle' href='/src/server/displayPoll.php?pollId=".$row['id']."'>" . $row['poll_title'] . "</a></td>";
    echo "<td class='col-sm-0' id='time$counter"."'>" . $row['close_date'] . "</td>";
    echo "</tr>";
    $counter++;
    }
    echo "</table>";
}
//display polls created by a user by using session created data
elseif (strcmp($_GET["option"],"myPolls")==0){
    $username = $_SESSION['uname'];
    //echo $username;
    $sql = "SELECT * FROM polls WHERE username = ". '"'.$username.'";';
    $results = mysqli_query($connection, $sql);
    echo "
    <table class='table-striped' id = 'myPollTab'>
    <tr id='tHead'>
    <th class='col-sm-10 text-left ' >My Polls </th>
    <th class='col-sm-0 text-left'>Closing Date/Time</th>
    </tr>";
    $counter = 1;
    while($row = mysqli_fetch_assoc($results)) {
    echo "<tr>";
    echo "<td id='".$row['id']."'"." name='title' class='col-sm-10 text-left'><a id='polltitle' href='/src/server/displayPoll.php?pollId=".$row['id']."'>" . $row['poll_title'] . "</a></td>";
    echo "<td class='col-sm-0' id='time$counter"."'>" . $row['close_date'] . "</td>";
    echo "</tr>";
    $counter++;
    }
    echo "</table>";
}
//close connections with the database
    mysqli_free_result($results);
    mysqli_close($connection);
}
?>
</body>
</html>