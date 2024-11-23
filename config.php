<?php

    $dbHost = 'https://projetointegrador1-forms.up.railway.app/'; // Host do banco de dados no Railway
    $dbUsername = 'railway'; // Usuário do banco
    $dbPassword = 'KTgoLggUEvpjZrBNcoVJzDWeTmcQqVIf'; // Senha do banco
    $dbName = 'railway'; // Nome do banco
    $dbPort = '3306'; // Porta do banco

    $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

    

    if (!$conn) {
        die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
    }
?>
