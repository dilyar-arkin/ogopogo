<?php session_start(); 
    if (!isset($_SESSION['loggedin'])) {
	    header('Location: ../client/index.html');
	    exit;
    }
    else{
        $username = $_SESSION['uname'];
        $email = $_SESSION['email'];
        $isLoggedin = $_SESSION['loggedin'];
        header('Location: main.php');
    }
?>