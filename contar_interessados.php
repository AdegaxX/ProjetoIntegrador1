<?php
include_once('config.php');

// Conta os alunos com interesse
$queryCount = "SELECT COUNT(*) AS total_interessados FROM usuarios WHERE interesse = 1";
$stmtCount = $conn->prepare($queryCount);
$stmtCount->execute();
$resultCount = $stmtCount->get_result();
$row = $resultCount->fetch_assoc();
$totalInteressados = $row['total_interessados'];

$conn->close();

// Envia o e-mail com a quantidade de interessados
if ($totalInteressados > 0) {
    // Configurações do e-mail
    $to = "ecommerce.adegas@gmail.com"; // Altere para o e-mail de destino
    $subject = "Relatório de Interessados";
    $message = "Quantidade de alunos interessados na refeição: $totalInteressados";
    $headers = "From: leandroadegas2@gmail.com";

    // Envia o e-mail
    if (mail($to, $subject, $message, $headers)) {
        echo "E-mail enviado com sucesso!";
    } else {
        echo "Erro ao enviar o e-mail.";
    }
} else {
    echo "Nenhum interessado encontrado.";
}
?>
