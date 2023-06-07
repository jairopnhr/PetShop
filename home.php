<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" href="./css/geral.css" >
    <link rel="stylesheet" href="./css/menu.css">
    <link rel="shortcut icon" type="imagex/png" href="./assets/icone.ico">
  
</head>
<body>
<?php echo $_SESSION['id'];?>
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
<footer>
        <p>© 2023 Meu Site. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
