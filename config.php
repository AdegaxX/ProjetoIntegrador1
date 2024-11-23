<?php
// Pegue as informações do banco de dados pelas variáveis de ambiente
$dbHost = 'mysql://root:KTgoLggUEvpjZrBNcoVJzDWeTmcQqVIf@junction.proxy.rlwy.net:45607/railway';
$dbUsername = 'root';
$dbPassword = 'KTgoLggUEvpjZrBNcoVJzDWeTmcQqVIf';
$dbName = 'repositorio';
$dbPort = 3306;

// Conexão com o banco de dados
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}
?>
