<?php

    $dbHost = '127.0.0.1';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'usuarios2';

    $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

    

    if (!$conn) {
        die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
    }
?>