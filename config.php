<?php

    $dbHost = 'Localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'formulario_RU';

    $conexao = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);


    if (!$conexao) {
        die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
    }
?>