<?php
include_once('config.php');

// Função para verificar se é dia útil (segunda a sexta)
function isWeekday() {
    $currentDay = date('N'); // Retorna 1 (segunda) a 7 (domingo)
    return $currentDay >= 1 && $currentDay <= 5; // Segunda a sexta
}

// Executa apenas em dias úteis
if (!isWeekday()) {
    exit("Hoje não é um dia útil. O script não será executado.\n");
}

// Consulta a contagem de interessados
$query = "SELECT COUNT(*) as total_interessados FROM usuarios WHERE interesse = 1";
$result = $conn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $totalInteressados = $row['total_interessados'];
} else {
    die("Erro ao consultar o banco de dados.\n");
}

// Configuração do e-mail
$to = "seu-email@example.com"; // Altere para o seu e-mail
$subject = "Resumo de Interessados - " . date('d/m/Y');
$message = "Total de interessados na refeição hoje: {$totalInteressados}.\n\nEsse e-mail foi enviado automaticamente pelo sistema.";
$headers = "From: noreply@example.com";

// Envia o e-mail
if (mail($to, $subject, $message, $headers)) {
    echo "E-mail enviado com sucesso!\n";
} else {
    echo "Erro ao enviar o e-mail.\n";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
