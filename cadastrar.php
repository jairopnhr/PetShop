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
require_once './database/ConexaoPdo.php';
require_once './controller/processar_cadastro.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);
    
    $papel = $_POST['tipo'];
    $dbConnection = new DatabaseConnection();
    $conn = $dbConnection->connect();
    $clienteController = new ClienteController($conn);
    $clienteController->addCliente($nome, $email, $senha, $papel );
    $dbConnection->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Tela de Cadastro</title>
    <link rel="stylesheet" href="./css/geral.css" >
    <link rel="stylesheet" href="./css/menu.css">
    <link rel="shortcut icon" type="imagex/png" href="./assets/icone.ico">
</head>
<body>
    <div class="menu">
    <div class="logo">
        <img src="./assets/Logo.jpeg">
    </div>
    <ul >
    <?php if (isset($_SESSION['ADM']) && $_SESSION['ADM'] === true): ?>
            <li><a href="cadastrar.php">Cadastrar Cliente</a></li>
        <?php endif; ?>
        <li><a href="carrinho_compras.php">Carrinho de Compras</a></li>
        <li><a href="produtos.php">Produtos</a></li>
        <li><a href="medicamentos.php">Medicamentos</a></li>
        <li><a href="home.php">Home</a></li>
        <?php if (isset($_SESSION['ADM']) && $_SESSION['ADM'] === true): ?>
        <li><a href="cadastrar_produto.php">Cadastrar Produto</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['ADM']) && $_SESSION['ADM'] === true): ?>
        <li><a href="clientes.php">Clientes</a></li>
        <?php endif?>

    </ul>
        <div>
        </div>
    </div> 
    <h2>Cadastro de Usuário</h2>
        <div class="container">
    <form method="POST" action="cadastrar.php">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br><br>
        <label for="senha">Senha:</label>
        <select id="tipo" name="tipo" required>
            <option value="">Selecione</option>
            <option value="ADM">Administrador</option>
            <option value="USER">Usuario</option>
        </select>
        <input type="submit" value="Cadastrar">
    </form>
    </div>   
    <footer>
        <p>© 2023 Meu Site. Todos os direitos reservados.</p>
    </footer> 
</body>
</html>