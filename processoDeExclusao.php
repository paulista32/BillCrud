<?php
global $pdo;
require_once("conecta.php");
require_once("Usuarios.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"])) {
        $id_usuario = $_POST["id"];

        $usuario = new Usuarios($pdo);
        $excluido = $usuario->excluir($id_usuario);

        if ($excluido) {
            echo "Usuário excluído com sucesso.";
        } else {
            echo "Erro ao excluir usuário. Por favor, tente novamente.";
        }
    }
}

