<?php
    $connection = mysqli_init();
    mysqli_ssl_set($connection,NULL,NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);
    mysqli_real_connect($connection, "dilyar-db.mysql.database.azure.com", "DilyarArkin", "Yulghun987*", "ogopogo", 3306,MYSQLI_CLIENT_SSL);
    if (mysqli_connect_errno($connection)) {
        print mysqli_connect_error();
        die('Failed to connect to MySQL: '.mysqli_connect_error());
    }
?>