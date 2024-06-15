<?php
global $pdo;
require_once("conecta.php");
require_once("Usuarios.php");

$usuario = new Usuarios($pdo);
$lista = $usuario->listarTodos();

// Verifica se os dados foram submetidos para atualização
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $atualizado = $usuario->atualizar($id, $nome, $email, $senha);

    if ($atualizado) {
        // Exibir mensagem de sucesso
        echo '<div id="success-message">Os dados foram salvos com sucesso!</div>';
    } else {
        // Exibir mensagem de erro
        echo '<div id="error-message">Erro ao atualizar usuário. Por favor, tente novamente.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .delete-button, .edit-button, .save-button, .cancel-button, .add-user-button {
            border: none;
            padding: 10px 20px; /* Ajusta o padding para tornar o botão maior */
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-button, .save-button {
            background-color: #28a745;
            color: #fff;
        }
        .delete-button, .cancel-button {
            background-color: #dc3545;
            color: #fff;
        }
        .add-user-button {
            background-color: #007bff;
            color: #fff;
        }
        .delete-button:hover, .edit-button:hover, .save-button:hover, .cancel-button:hover, .add-user-button:hover {
            filter: brightness(85%); /* Reduz um pouco o brilho ao passar o mouse */
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        #update-form {
            display: none;
            margin: 20px auto;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        #update-form label {
            display: block;
            margin-bottom: 10px;
        }
        #update-form input[type="text"],
        #update-form input[type="email"],
        #update-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        #update-form .button-container {
            text-align: center;
            margin-top: 20px;
        }
        #update-form input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        #update-form .cancel-button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }
        #update-form input[type="submit"]:hover, #update-form .cancel-button:hover {
            filter: brightness(85%);
        }
    </style>
</head>
<body>
<h1>Lista de Usuários</h1>

<table id="user-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Senha</th>
        <th>Editar</th>
        <th>Excluir</th>
    </tr>
    </thead>
    <tbody>
    <!-- Loop PHP para listar usuários -->
    <?php foreach ($lista as $usuario) : ?>
        <tr data-id="<?php echo $usuario['id']; ?>">
            <td><?php echo $usuario["id"]; ?></td>
            <td class="name"><?php echo $usuario["nome"]; ?></td>
            <td class="email"><?php echo $usuario["email"]; ?></td>
            <td class="senha"><?php echo $usuario["senha"]; ?></td>
            <td><button class="edit-button" onclick="editRow(<?php echo $usuario['id']; ?>)">Editar</button></td>
            <td><button class="delete-button" onclick="deleteUser(<?php echo $usuario['id']; ?>)">Excluir</button></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="button-container">
    <button class="add-user-button" onclick="location.href='index.php'">Cadastrar outro usuário</button>
</div>

<!-- Formulário para editar usuário -->
<div id="update-form">
    <h2>Editar Usuário</h2>
    <form id="edit-user-form" method="post" action="atualizarUsuario.php">
        <input type="hidden" id="update-id" name="id">
        <label for="update-nome">Nome:</label>
        <input type="text" id="update-nome" name="nome" required>

        <label for="update-email">Email:</label>
        <input type="email" id="update-email" name="email" required>

        <label for="update-senha">Senha:</label>
        <input type="password" id="update-senha" name="senha" required>

        <div class="button-container">
            <input type="submit" value="Salvar">
            <button type="button" class="cancel-button" onclick="cancelEdit()">Cancelar</button>
        </div>
    </form>
</div>

<script>
    function editRow(id) {
        var row = document.querySelector("tr[data-id='" + id + "']");
        var nameCell = row.querySelector('.name');
        var emailCell = row.querySelector('.email');
        var senhaCell = row.querySelector('.senha');

        var name = nameCell.innerText;
        var email = emailCell.innerText;
        var senha = senhaCell.innerText;

        document.getElementById('update-id').value = id;
        document.getElementById('update-nome').value = name;
        document.getElementById('update-email').value = email;
        document.getElementById('update-senha').value = senha;

        // Esconder a tabela de usuários
        document.getElementById('user-table').style.display = 'none';
        // Exibir o formulário de edição
        document.getElementById('update-form').style.display = 'block';
    }

    function cancelEdit() {
        // Exibir a tabela de usuários
        document.getElementById('user-table').style.display = 'table';
        // Esconder o formulário de edição
        document.getElementById('update-form').style.display = 'none';
    }

    function deleteUser(id) {
        if (confirm('Tem certeza de que deseja excluir este usuário?')) {
            // Redirecionar para o script de exclusão
            window.location = 'excluirUsuario.php?id=' + id;
        }
    }
</script>

</body>
</html>


















