<?php

    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'usuarios';

    $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

    

    if (!$conn) {
        die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
    }
?>