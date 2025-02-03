<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Carrega o PHPMailer automaticamente
include_once('config.php'); // Arquivo de configuração do banco de dados

// Configura o fuso horário para garantir a hora correta
date_default_timezone_set('America/Sao_Paulo');

// Verifica a conexão com o banco de dados
if (!$conn) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

// Consulta SQL para contar o número de estudantes interessados (interesse = 1)
$queryCount = "SELECT COUNT(*) AS total_interesse FROM usuarios WHERE interesse = 1";
$resultCount = $conn->query($queryCount);

// Verifica se a consulta foi bem-sucedida
if ($resultCount) {
    $row = $resultCount->fetch_assoc();
    $totalInteresse = $row['total_interesse']; // Número total de interessados
} else {
    $totalInteresse = 0; // Se houver erro na consulta, assume que ninguém manifestou interesse
}

// **Configuração do PHPMailer**
$mail = new PHPMailer(true);

try {
    // Configuração do servidor SMTP (Gmail)
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'rian.ssrb@gmail.com'; // Seu e-mail Gmail
    $mail->Password   = 'lhvqwckoxiypbzdn'; // Senha de Aplicativo do Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Configuração do e-mail (remetente e destinatário)
    $mail->setFrom('rian.ssrb@gmail.com', 'Rian Albano');
    $mail->addAddress('creedbr007@gmail.com'); // E-mail de destino

    // Assunto e corpo do e-mail
    $mail->Subject = 'Quantidade de interessados para refeição';
    $mail->Body    = "A quantidade total de pessoas interessadas na refeição é: $totalInteresse";

    // Enviar o e-mail
    $mail->send();
    echo '✅ E-mail enviado com sucesso!';
} catch (Exception $e) {
    echo "❌ Erro ao enviar e-mail: {$mail->ErrorInfo}";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
