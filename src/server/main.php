<?php session_start(); 
    if (!isset($_SESSION['loggedin'])) {
	    header('Location: ../client/index.html');
	    exit;
    }
    else{
        $username = $_SESSION['uname'];
        $email = $_SESSION['email'];
        $city = $_SESSION['city'];
        $province = $_SESSION['province'];
        $fname =$_SESSION['fname'];
        $lname = $_SESSION['lname'];
        $isLoggedin = $_SESSION['loggedin'];
        $binData = $_SESSION['photo'];
/*------------------------------------------------------------------------*/
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
          //get user profile photo from database
          $sql = "SELECT photo FROM users where username=?";
              // build the prepared statement SELECTing on the userID for the user
              $stmt = mysqli_stmt_init($connection);
              //init prepared statement object
              mysqli_stmt_prepare($stmt, $sql);
              // bind the query to the statement
              mysqli_stmt_bind_param($stmt, "i", $username);
              // bind in the variable data (ie userID)
              $result = mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
              // Run the query. run spot run!
              mysqli_stmt_bind_result($stmt, $image); //bind in results
              // Binds the columns in the resultset to variables
              mysqli_stmt_fetch($stmt);
              // Fetches the blob and places it in the variable $image for use as well
              // as the image type (which is stored in $type)
              mysqli_stmt_close($stmt);
              mysqli_close($connection);
/*------------------------------------------------------------------------*/              
        }
    }
?>

<html lang="en">
<head>
  <title>The Okanagan Ogopogo Polls</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="../client/css/mainCss.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src = "../client/js/jquery-3.7.0.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="js/mainPHP.js"></script>
  <script src="../client/js/validate.js"></script> 
  <script src="js/PollPops.js"></script> 

  <script type="text/javascript">
    var isLoggedin = <?php echo $isLoggedin ?>;
  </script>
  <style>
    legend {
    background-color: #000;
    color: #fff;
    padding: 3px 2px;   
    }
    input {
        text-align: left;
        border: 1px solid black;
    }
    label{
        margin: 0.5em;
        text-align: left;
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
            <a href="main.php" class="navbar-brand">Ogopogo</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active" id="home"><a href="#">Home</a></li>
                <li id="popPost"><a href="#">popular posts</a></li>
                <li id="myPost"><a href="#">my posts</a></li>
                <li id="search"><a href="#">search posts</a></li>
                <li><a href="../client/createPost.html">submit new post</a></li>
                <?php if ($username == 'admin'){echo "<li><a href='managePosts.php'>manage posts</a></li>";} ?>
                <?php if ($username == 'admin'){echo "<li><a href='manageUsers.php'>manage users</a></li>";} ?>

            </ul>
            <ul class="nav navbar-nav navbar-right" id="logInlogOut">
                <li><a href="logout.php" id="logoutbutt"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
            </div>
        </div>
        </nav>
        
        <div class="container-fluid text-center">    
        <div class="row content">
            <div class="col-sm-2 sidenav">
            <fieldset>
            <legend><?php echo $username?>'s Profile</legend>
            <p><a><?php echo '<img style="width: 195px; height:200px" src="data:image/JPG;base64,'.base64_encode($image).'"/>';?></a></p>
            <p>Name: <a><?php echo $fname ." ".$lname?></a></p>
            <p>Email: <a><?php echo $email?></a></p>
            <p>Location: <a><?php echo $city ." ". $province ?></a></p>
            <p id="changePassword"><a href="#">change my password</a></p>
            </fieldset>
            </div>
  <!-- main part for dynamic content delivery-->
  <!-- ------------------------------------  -->
            <div class="col-sm-8 text-center" id="contentArea"> 
              <div class="col-sm-12" id="upperContent">
                <h1>ogopogo poll station</h1>
                <a class = "col-sm-7   text-left" id="CompIntro">Ogopogo: Your Voice, Your Valley. Engage, Discuss, Decide. Join our unique platform for residents of the Okanagan Valley to participate in polls, share opinions, and shape our community. Together, we address critical issues that impact us all.</a>
                <a class = "col-sm-2"><img src="../client/img/ogopogo_mini.JPG"></a>
              </div>
              <div class="col-sm-12" id="lowerContent">
                <h3>Open Polls [-- Vote Now --] </h3>
                <p>PHP/AJAX/SQL Connection</p>
                <div id=openPollsDiv></div> <!--AJAX PHP SQL will insert server data in here about open polls titles-->
              </div>
            </div>

<!-- dynamic content boundary-->
<!-- ---------------------------------------------  -->
            <div class="col-sm-2 sidenav">
            <div class="well">
                <p>
                  <a class="welcome">welcome </a>
                  <a><?php echo $_SESSION["uname"]?></a>
                </p>
            </div>
            <div class="well">
                <p>
                  <a class ="rank">Rank: </a>
                  <a> <?php echo $_SESSION["badge"]?> </a>
                </p>
            </div>
            </div>
        </div>
        </div>

        <footer class="container-fluid text-center">
        <p>
            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2023 Copyright:
                <a href="#" style="color: gold; font-weight: bold;"> COSC360 The Ogopogo Project</a>
                </div>
        </p>
        </footer>

</body>
</html>
