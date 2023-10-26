<?php
    ini_set('display_errors', 'On'); 
    ini_set('html_errors', 0); 
    error_reporting(-1);
    
    $connection = mysqli_init();
    mysqli_ssl_set($connection,NULL,NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);
    mysqli_real_connect($connection, "dilyar-db.mysql.database.azure.com", "DilyarArkin", "Yulghun987*", "ogopogo", 3306,MYSQLI_CLIENT_SSL);
    if (mysqli_connect_errno($connection)) {
        die('Failed to connect to MySQL: '.mysqli_connect_error());
    }
    echo 'Successfully connected to MySQL.<br>';
?>