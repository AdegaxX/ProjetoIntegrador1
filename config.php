<?php
// Pegue as informações do banco de dados pelas variáveis de ambiente
$dbHost = 'junction.proxy.rlwy.net'; // Altere se necessário
$dbUsername = 'root';
$dbPassword = 'KTgoLggUEvpjZrBNcoVJzDWeTmcQqVIf';
$dbName = 'railway';
$dbPort = 45607;

// Conexão com o banco de dados
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}
?>
