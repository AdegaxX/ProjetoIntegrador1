<?php
include_once('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM usuarios WHERE id = $id";
    $result = mysqli_query($conexao, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);
    } else {
        echo "Usuário não encontrado.";
        exit;
    }
}

if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $interesse = isset($_POST['interesse']) ? 1 : 0;

    $query = "UPDATE usuarios SET nome = '$nome', matricula = '$matricula', interesse = '$interesse' WHERE id = $id";
    $result = mysqli_query($conexao, $query);

    if ($result) {
        echo "<script>alert('Dados atualizados com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao atualizar os dados.');</script>";
    }
}
?>

<form action="editar.php" method="POST">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" value="<?= $usuario['nome'] ?>" required>
    <label for="matricula">Matrícula:</label>
    <input type="number" name="matricula" value="<?= $usuario['matricula'] ?>" required>
    <label for="interesse">Interesse:</label>
    <input type="checkbox" name="interesse" <?= $usuario['interesse'] == 1 ? 'checked' : '' ?>>
    <button type="submit" name="editar">Salvar Alterações</button>
</form>
