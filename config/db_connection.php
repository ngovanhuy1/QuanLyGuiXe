<?php
function getDbConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "Ngovanhuy2005@";
    $dbname = "baiguixednu";
    $port = 3306;

    $conn = mysqli_connect($servername, $username, $password, $dbname, $port);
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8");
    return $conn;
}
?>
