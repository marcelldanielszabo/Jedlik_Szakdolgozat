<?php

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "guitar";
        $connection = new mysqli($servername, $username, $password, $dbname);
        mysqli_set_charset($connection,"utf8");
        if ($connection->connect_error) 
        {
         die("Connection failed: " . $connection->connect_error);
        } 

?>