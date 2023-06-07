<?php
session_start();
require_once './database/ConexaoPdo.php';
require_once './controller/processar_cadastro.php';
$cone = new DatabaseConnection();
$controller = new ClienteController($cone->connect());
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['ADM']) || $_SESSION['ADM'] !== true) {
    header("Location: acesso_nao_autorizado.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Excluir Cliente</title>
    <link rel="shortcut icon" type="imagex/png" href="./assets/icone.ico">
    <link  rel="stylesheet" href="./css/geral.css" >
    <link rel="stylesheet" href="./css/menu.css">
</head>
<body>
    <h1>Excluir Cliente</h1>

    <?php
if (isset($_GET['id'])) {
    $clienteId = $_GET['id'];
    $cliente = $controller->buscarClientePeloId($clienteId);

    if ($cliente) {
        echo '<div class="confirmation">';
        echo '<p>Você tem certeza que deseja excluir o cliente ' . $cliente['nome'] . '?</p>';
        echo '<p>Email: ' . $cliente['email'] . '</p>';
        echo '<p>Papel: ' . $cliente['papel'] . '</p>';
        echo '<form method="POST" action="confirmar_exclusao.php">';
        echo '<input type="hidden" name="cliente_id" value="' . $clienteId . '">';
        echo '<button type="submit">Confirmar Exclusão</button>';
        echo '</form>';
        echo '</div>';
    } else {
        echo '<p>Cliente não encontrado.</p>';
    }
} else {
    echo '<p>ID do cliente não fornecido.</p>';
}
?>
<footer>
        <p>© 2023 Meu Site. Todos os direitos reservados.</p>
    </footer>
</body>
</html>