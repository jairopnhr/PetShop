<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['ADM']) || $_SESSION['ADM'] !== true) {
    header("Location: acesso_nao_autorizado.php");
    exit;
}
require_once './controller/processar_cadastro.php';
require_once './database/ConexaoPdo.php';
if (isset($_GET['id'])) {
    $cliente_id = $_GET['id'];
   
    $conn = new DatabaseConnection();
    $clienteController = new ClienteController($conn->connect());
    $cliente = $clienteController->buscarClientePeloId($cliente_id);
    
    if (!$cliente) {
        echo "Cliente não encontrado.";
        exit();
    }
} else {
    echo "ID do cliente não fornecido.";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['email'], $_POST['senha'])) {
        $cliente_id = $_GET['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = md5($_POST['senha']);
        $atualizado = $clienteController->atualizarCliente($cliente_id,$nome, $email,$senha);

    if ($atualizado) {
        echo "Dados do cliente atualizados com sucesso.";
    } else {
        echo "Erro ao atualizar os dados do cliente.";
    }
}
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Cliente</title>
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="./css/geral.css">
    <link rel="stylesheet" href="./css/menu.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <link rel="stylesheet" href="./css/card.css">
    <link rel="stylesheet" href="./css/carousel.css">
				
    <link rel="shortcut icon" type="imagex/png" href="./assets/icone.ico">
</head>
<body>
    <h1>Editar Cliente</h1>
    <form method="POST" action="editar_cliente.php">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" value="<?php echo $cliente['nome']; ?>">
    
    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" value="<?php echo $cliente['email']; ?>">
    
    <label for="senha">Nova senha:</label>
    <input type="password" name="senha" id="senha">
    
    <button type="submit">Atualizar</button>
</form>
</body>
</html>
