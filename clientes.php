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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Clientes</title>
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
        <?php echo $_SESSION["username"]; ?>! 
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
    <h1>Lista de Clientes</h1>
    <?php
   
    require_once './controller/processar_cadastro.php';
    require_once './database/ConexaoPdo.php';

    $con = new DatabaseConnection();
    $cli = new clienteController($con->connect());
    $clientes = $cli->listarClientes();
    
    if ($clientes) {
        foreach ($clientes as $cliente) {
            echo '<div class="cliente">';
            echo '<h2>' . $cliente['nome'] . '</h2>';
            echo '<p>Email: ' . $cliente['email'] . '</p>';
            echo '<p>Role: ' . $cliente['papel'] . '</p>';
            
            echo '<div class="acoes">';
            echo '<a href="editar_cliente.php?id=' . $cliente['id'] . '">Editar</a>';
            echo '<a href="excluir_cliente.php?id=' . $cliente['id'] . '">Excluir</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>Ocorreu um erro ao obter a lista de clientes.</p>';
    }
    ?>
    <footer>
        <p>© 2023 Meu Site. Todos os direitos reservados.</p>
    </footer>
</body>
</html>