<?php
// Pegue as informações do banco de dados pelas variáveis de ambiente
$dbHost = getenv('MYSQLHOST') ?: 'mysql.railway.internal';
$dbUsername = getenv('MYSQLUSER') ?: 'root';
$dbPassword = getenv('MYSQLPASSWORD') ?: 'KTgoLggUEvpjZrBNcoVJzDWeTmcQqVIf';
$dbName = getenv('MYSQLDATABASE') ?: 'railway';
$dbPort = getenv('MYSQLPORT') ?: 3306;

// Conexão com o banco de dados
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}
?>
