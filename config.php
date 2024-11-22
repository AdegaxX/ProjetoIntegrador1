<?php

    $dbHost = ' containers-us-west-XXXXXX.railway.app'; // Host do banco de dados no Railway
    $dbUsername = 'railway'; // Usuário do banco
    $dbPassword = 'senha'; // Senha do banco
    $dbName = 'nome_do_banco'; // Nome do banco
    $dbPort = 'XXXXX'; // Porta do banco

    $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

    

    if (!$conn) {
        die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
    }
?>