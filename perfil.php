<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Verifica se o usuário é administrador
$isAdmin = isset($_SESSION['ADM']) && $_SESSION['ADM'] === true;

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
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
<div class="menu">
    <div>  
       
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
        <li><a href="perfil.php"><img src="./assets/PerifilIcone.ico" alt="Ícone Perfil"></a></li>
        <li><a href="#"><img src="./assets/carrinho.ico" alt="Ícone Carrinho"></a></li>
    </ul>
    <div>
        <?php echo $_SESSION["username"]; ?>
        <div>
    </div>
    </div>
</div>
    <h1>Perfil do Usuário</h1>
    <p>Olá, <?php echo $_SESSION['username']; ?>!</p>
    
    <?php if ($isAdmin): ?>
        <p>Você é um administrador.</p>
    <?php endif; ?>
    
    <a href="perfil.php?logout=true">Logout</a>
</body>
</html>