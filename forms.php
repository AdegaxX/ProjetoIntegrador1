<?php
include_once('config.php');

// Configura o fuso horário do servidor
date_default_timezone_set('America/Sao_Paulo');

// Obtém o horário e o dia da semana atuais
$currentHour = (int) date('H');
$currentMinute = (int) date('i');
$currentDay = (int) date('w'); // 0 = Domingo, 6 = Sábado

// Define os horários permitidos (8h às 21h)
$horaInicio = 8;
$horaFim = 21;
$horarioPermitido = ($currentHour >= $horaInicio && $currentHour < $horaFim) || ($currentHour == $horaFim && $currentMinute == 0);


// Verifica se o horário está permitido
if (!$horarioPermitido) {
    echo "<script>
        alert('Formulário disponível apenas entre 8h e 21h.');
        window.location.href = 'forms.php';
    </script>";
    exit;
}


// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $matricula = trim($_POST['matricula']);
    $interesse = isset($_POST['interesse']) ? 1 : 0;

    // Verifica se o usuário já está cadastrado
    $queryCheck = "SELECT * FROM usuarios WHERE matricula = ?";
    $stmtCheck = $conn->prepare($queryCheck);
    $stmtCheck->bind_param("s", $matricula);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();


    if ($resultCheck->num_rows > 0) {
        echo "<script>
            alert('Usuário já cadastrado! Você será redirecionado para edição.');
            window.location.href = 'editar.php?matricula=' + encodeURIComponent('$matricula');
        </script>";
        $stmtCheck->close();
        $conn->close();
        exit;
    }


    #if ($resultCheck->num_rows > 0) {
    #    echo "<script>
    #        alert('Usuário já cadastrado! Você será redirecionado para edição.');
    #        window.location.href = 'editar.php?matricula=$matricula';
    #    </script>";
    #    $stmtCheck->close();
    #    $conn->close();
    #    exit;
    #}

    // Usuário não existe, insere novo registro
    $queryInsert = "INSERT INTO usuarios (nome, matricula, interesse) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($queryInsert);
    $stmtInsert->bind_param("ssi", $nome, $matricula, $interesse);


    if ($stmtInsert -> execute()) {
        echo "<script>
            alert('Usuário cadastrado com sucesso!');
            localStorage.setItem('matriculaCadastrada', '$matricula');
            window.location.href = 'forms.php';
            </script>";
    } else {
        echo "<script>alert('Erro ao cadastrar usuário.');</script>";
    }


    #if ($stmtInsert->execute()) {
    #    echo "<script>alert('Usuário cadastrado com sucesso!');</script>";
    #} else {
    #    echo "<script>alert('Erro ao cadastrar usuário.');</script>";
    #}

    $stmtInsert->close();
    $stmtCheck->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="imagens/food.png" />
    <title>Formulário RU Itapajé</title>
    <style>
        .brasao {
            width: 35%;
            max-width: 450px;
            display: block;
            margin: 0 auto;
            border-radius: 8px;
        }

        body { 
            font-family: Arial, sans-serif;
            background-color: #282A36;
            color: black;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
        }

        form {
            width: auto;
            max-width:auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #CCCCCC;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 30px ;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        h3 {
            font-family: Arial, sans-serif;
            color: black;
            font-size: 12px;
            margin-bottom: 30px;
        }

        input {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        label {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        label input {
            margin-right: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #2A9C01;
            color: white;
            border-radius: 4px;
            border: 0;
            cursor: pointer;
        }

        button:hover {
            background-color: #46C001;
        }

        /* checkbox */
        .container {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 35px;
            width: 100%;
        }

        .check-label {
            display: flex;
            align-items: center; 
            gap: 5px;
            width: 100%;
        }

        .check {
            margin: 0; 
            padding: 0;
            width: 100%;
        }

        #span {
            display: flex;
            justify-content: flex-start;
            width: 100%;
            font-size: 13px;
        }
        #interesse {
            display: flex;
            justify-content: flex-start;
            margin: 0;
            width: 5%;
        }

        /* Estilo imagens */
        .carrossel {
            margin: 15% auto;
            text-align: center;
        }
        .carrossel img {
            width: 100%;
            max-width: 550px;
            display: block;
            margin: 0 auto;
            border-radius: 8px;
        }


        /*Estilo do link*/
        .avaliacao {
            text-align: center; /* Centraliza o link */
            margin-top: 20px; /* Adiciona um espaço entre o botão e o link */
        }
        .avaliacao a {
            color: white; /* Deixa o texto branco */
            font-size: 16px;
            text-decoration: none; /* Remove o sublinhado */
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff; /* Cor de fundo azul */
            border-radius: 5px;
        }
        .avaliacao a:hover {
            background-color: #0056b3; /* Efeito de hover mais escuro */
        }

    </style>

</head>
<body>
    <form action="forms.php" method="POST">
        <img class="brasao" src="brasaoUFC.png" alt="brasaoUFC">
        <h2>RU Itapajé - Demanda de refeição</h2>
        <h3>
            Preencha seus dados de identificação se deseja solicitar a refeição.
            
            <br><b>(Obs.: O preenchimento deve ser feito, no máximo, até as 21:00 horas do dia anterior ao da refeição pretendida)
            <br><br>
            Adote seu copo! O RU não disponibilizará mais copos descartáveis. Colabore com a conservação do planeta!
            </b>
        </h3>
        <div>
            <input type="text" pattern="[A-Za-z ]+" title="Somente letras" id="nome" name="nome" placeholder="Nome completo" required>
            <input type="tel" maxlength="7" pattern="\d{6,7}" title="Erro: Insira todos os números da matrícula/SIAPE" id="matricula" name="matricula" placeholder="Matrícula" required>

            <div class="carrossel">
                <img id="current-cardapio" src="CARDAPIO1.png" alt="Cardápio 1">
            </div>
        </div>

        <div class="container">
            <label class="check-label">
                <input class="check" type="checkbox" id="interesse" name="interesse">
                <span id="span">Tenho interesse em solicitar refeição para:</span>
            </label>
        </div>
        <p><span id="data-dia-util"></span></p>
        <button type="submit">Enviar</button>

        <div class="avaliacao">
            <a href="https://forms.gle/uQPNQLnC7yKRLN1a8" target="_blank">Avalie a refeição</a>
        </div>
    </form>

    <script>
        // Função para calcular automaticamente o prox dia útil do forms:
        function calcularProximoDia() {
            //console.log("Função calcularProximoDia() chamada!"); // depuração

            const hoje = new Date();    // Dia atual
            let proximoDiaUtil = new Date(hoje);    // Atribui a data na variável

            // Avança para o próximo dia
            proximoDiaUtil.setDate(hoje.getDate() + 1);

            while (proximoDiaUtil.getDay() == 0 || proximoDiaUtil.getDay() == 6) {  // Range para os dias úteis
                proximoDiaUtil.setDate(proximoDiaUtil.getDate() + 1);
            }

            const diasSemana = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"];
            const diaSemana = diasSemana[proximoDiaUtil.getDay()];

            // Formata o dia e o mês com dois dígitos
            const diaMes = String(proximoDiaUtil.getDate()).padStart(2, '0');
            const mes = String(proximoDiaUtil.getMonth() + 1).padStart(2, '0');
            const ano = proximoDiaUtil.getFullYear();

            console.log(`Próximo dia útil: ${diaSemana}, ${diaMes}/${mes}/${ano}`) // Debug

            document.getElementById("data-dia-util").innerText = `${diaSemana}, ${diaMes}/${mes}/${ano}`;
        }

        document.addEventListener("DOMContentLoaded", function() {
            calcularProximoDia();
        });

        // Cardápio automatico:
        const cardapios = [
            "imagens/CARDAPIO2.png",
            "imagens/CARDAPIO3.png",
            "imagens/CARDAPIO4.png",
            "imagens/CARDAPIO1.png"
        ];

        //Calcula o cardápio:
        function getCardapioSemana() {
            const today = new Date();
            const firstDayOfYear = new Date(today.getFullYear(), 0, 1);
            const daysSinceStartOfYear = Math.floor((today - firstDayOfYear) / (1000 * 60 * 60 * 24));
            const weekNumber = Math.floor(daysSinceStartOfYear / 7); // semanas completas desde o inicio do ano
            return cardapios[weekNumber % cardapios.length];
        }

        // Atualiza o cardápio da semana no DOMINGO:
        function updateCardapio() {
            const cardapioImg = document.getElementById("current-cardapio");
            const cardapioFile = getCardapioSemana();
            cardapioImg.src = getCardapioSemana();
            cardapioImg.style.display = "block";
        }

        // Inicia o formulario:
        window.onload = function() {
            calcularProximoDia();
            updateCardapio();

            // Preenche os dados salvos, se houver:
            const dadosSalvos = JSON.parse(localStorage.getItem("dadosFormulario")) || {};
            if (dadosSalvos.nome) document.getElementById("nome").value = dadosSalvos.nome;
            if (dadosSalvos.matricula) document.getElementById("matricula").value = dadosSalvos.matricula;
            if (dadosSalvos.interesse) {
                document.getElementById("interesse").checked = dadosSalvos.interesse === "true";
            }
        };

        function verificarHorario() {
            const agora = new Date();
            const hora = agora.getHours();

            const botao = document.querySelector("button[type='submit']");
    
            if (hora < 8 || hora >= 21) {
                botao.disabled = true; 
                botao.style.backgroundColor = "#808080"; // Cinza para indicar bloqueio
                alert("Formulário disponível apenas entre 13h e 21h.");
            }
        }

    document.addEventListener("DOMContentLoaded", verificarHorario);
    

    // Função para verificar se já há o usuário:
        document.addEventListener("DOMContentLoaded", function() {
        const matriculaCadastrada = localStorage.getItem("matriculaCadastrada");
        if (matriculaCadastrada) {
            document.getElementById("matricula").value = matriculaCadastrada;
            document.getElementById("matricula").setAttribute("readonly", true);
            document.getElementById("nome").setAttribute("readonly", true);
            document.querySelector("button[type='submit']").disabled = true;
            alert("Você já preencheu o formulário.");
        }

    </script>
</body>
</html>