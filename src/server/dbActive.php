<?
$connection = mysqli_init();
    mysqli_real_connect($connection, "dilyar-db.mysql.database.azure.com", "DilyarArkin", "Yulghun987*", "ogopogo", 3306);
    if (mysqli_connect_errno($connection)) {
    die('Failed to connect to MySQL: '.mysqli_connect_error());
    }
?>