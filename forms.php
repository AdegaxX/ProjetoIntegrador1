<?php
include_once('config.php');

if (isset($_POST['submit'])) {
    $horaAtual = date('H');  // hora atual no formulario de 24h
    if ($horaAtual >= 21) {
        echo "<script>alert("O formulário só pode ser enviado até as 21h.");</script>";
        exit;   // Encerra a execução para evitar salvar os dados
    }

    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $interesse = $_POST['interesse'];

    $result = mysqli_query($conexao, "INSERT INTO usuarios(nome, matricula, interesse') VALUES ('$nome', '$matricula', '$interesse')");

    if ($result) {
        echo "<script>alert('Dados enviados com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao enviar os dados.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Formulário RU</title>
</head>
<body>

    <style>
        body {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            background-color: rgb(17,54,71);
            font-size: 12px;
        }
        .box {
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.8);
            padding: 15px;
            border-radius: 15px;
            width: 20%;
        }
        fieldset {
            border: 3px solid dodgerblue;
        }
        legend {
            text-align: center;
            border: 1px solid dodgerblue;
            padding: 10px;
            border-radius: 8px;
            background-color: dodgerblue;
            color: white;
        }
        .inputBox {
            position: relative;
        }
        .inputUser {
            background: none;
            border: none;
            border-bottom: 1px solid white;
            outline: none;
            color: white;
            font-size: 15px;
            width: 100%;
            letter-spacing: 2px;
        }
        .labelInput {
            position: absolute;
            top: 0px;
            left: 0px;
            pointer-events: none;
            transition: .5s;
        }
        img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 4px; 
        }
        .inputUser:focus ~ .labelInput {
            top: 20px;
            font-size: 12px;
        }
        button {
            align-self: center;
            background-color: dodgerblue;
            border: none;
            color: white;
            border-radius: 5px;
            height: 25px;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
            border-radius: 5px;
        }
        img#brasao {
            width: 50%;
            vertical-align: middle;
            position: relative;
            bottom: 8px;
        }
        </style>

    <div class="box">
        <form action="formulario.php" method="POST" id="meuFormulario">
            <div style="display: grid; place-items: center;">
                <img src="brasao-cor-vertical.png" alt="brasao" id="brasao">
            </div>
            <fieldset>
                <legend><b>RU Itapajé</b></legend>
                <br>
                <div class="inputBox" id="divnome">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome">Nome completo</label>
                </div>
                <div class="inputBox" id="divmatricula">
                    <input type="number" name="matricula" id="matricula" class="inputUser" required>
                    <label for="matricula">Matrícula/SIAPE</label>
                </div>
                <div class="cardapio" id="divcardapio">
                    <br>
                    Cardápio semanal:
                    <img src="cardapio.png" alt="cardapio">
                </div>
                <div id="proximo_dia">
                    <p id="data-dia-util"></p>
                </div>
                <label for="interesse" class="checkbox-container" id="interesse">
                    <input type="checkbox" name="interesse" id="interesse">
                    Tenho interesse
                </label>
                <br><br>
                <button type="submit" id="submit">Enviar</button>
            </fieldset>
        </form>
    </div>

    <script>
        // Função para calcular automaticamente o prox dia útil do forms:
        function calcularProximoDia() {
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

            document.getElementById("data-dia-util").innerText = `${diaSemana}, ${diaMes}/${mes}/${ano}`;
        }

        window.onload = function() {
            calcularProximoDia();
            const dadosSalvos = JSON.parse(localStorage.getItem("dadosFormulario")) || {};

            if (dadosSalvos.nome) document.getElementById("nome").value = dadosSalvos.nome;
            if (dadosSalvos.matricula) document.getElementById("matricula").value = dadosSalvos.matricula;
            if (dadosSalvos.interesse) {
                document.getElementById("interesse-checkbox").checked = dadosSalvos.interesse === "true";
            }
        };

        document.getElementById("meuFormulario").addEventListener("submit", function(event) {
            const hora = new Date();
            const horaAtual = agora.getHours();

            if (horaAtual >= 21) {
                alert("O formulário só pode ser enviado até as 21h.")
                event.preventDefault(); // cancela o envio do formulario
            }
        });
    
    </script>
</body>
</html>