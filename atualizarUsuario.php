<?php
global $pdo;
require_once("conecta.php");
require_once("Usuarios.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"])) {
        $id_usuario = $_POST["id"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        $usuario = new Usuarios($pdo);
        $atualizado = $usuario->atualizar($id_usuario, $nome, $email, $senha);

        if ($atualizado) {
            echo "Usuário atualizado com sucesso.";
        } else {
            echo "Erro ao atualizar usuário. Por favor, tente novamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        .message {
            font-size: 18px;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .error {
            color: white;
            background-color: #dc3545;
        }

        .button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    // Verifica se a atualização foi bem-sucedida e exibe mensagem correspondente
    if ($atualizado) {
    } else {
        echo "<p class='message error'>Ocorreu um erro ao atualizar o usuário. Por favor, tente novamente.</p>";
    }
    ?>
    <!-- Botão para voltar para a página de mostrar usuários -->
    <button class="button" onclick="location.href='mostrarUsuários.php'">Voltar para a Tabela</button>
</div>

</body>
</html>



