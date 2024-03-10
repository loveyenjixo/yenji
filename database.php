<?php

    $hostname = "localhost";
    $dbuser = "root";
    $dbPassword = "";
    $dbname = "perwebsite_db";
    $conn = mysqli_connect($hostname, $dbuser, $dbPassword, $dbname);
    if (!$conn) {
        die("Something went wrong!");
    }


?>
