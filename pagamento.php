<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

require_once './database/ConexaoPdo.php';
require_once './controller/carrinhocontroller.php';

$conn = new DatabaseConnection();
$carrinhoController = new CarrinhoController($conn->connect());

$id_usuario = $_SESSION['id'];
$carrinhoProdutos = $carrinhoController->listarProdutos($id_usuario);

$total = 0;
foreach ($carrinhoProdutos as $produto) {
    $total += $produto['valor'] * $produto['quantidade'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar o pagamento e finalizar a compra
    // Código para processar o pagamento e atualizar o status da compra no banco de dados

    // Limpar o carrinho
    $carrinhoController->limparCarrinho($id_usuario);

    // Redirecionar para a página de confirmação
    header("Location: confirmacao.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Finalizar Pagamento</title>
    <link rel="stylesheet" href="./css/geral.css">
    <link rel="stylesheet" href="./css/menu.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <link rel="stylesheet" href="./css/card.css">
    <link rel="stylesheet" href="./css/carousel.css">
    <link rel="shortcut icon" type="image/x-icon" href="./assets/icone.ico">
</head>
<body>
<div class="menu">
    <div></div>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="produtos.php">Produtos</a></li>
        <li><a href="carrinho.php">Carrinho</a></li>
        <li><a href="perfil.php">Perfil</a></li>
        <li><a href="logout.php">Sair</a></li>
    </ul>
    <div>
        <?php echo $_SESSION["username"]; ?>
    </div>
</div>

<h2>Finalizar Pagamento</h2>

<?php if (empty($carrinhoProdutos)) : ?>
    <p>O carrinho está vazio.</p>
<?php else : ?>
    <table>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Total</th>
        </tr>
        <?php foreach ($carrinhoProdutos as $produto) : ?>
            <tr>
                <td><?php echo $produto['nome']; ?></td>
                <td>R$ <?php echo $produto['valor']; ?></td>
                <td><?php echo $produto['quantidade']; ?></td>
                <td>R$ <?php echo $produto['valor'] * $produto['quantidade']; ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="3">Total</th>
            <th>R$ <?php echo $total; ?></th>
        </tr>
    </table>

    <form method="POST" action="">
        <button type="submit">Finalizar Pagamento</button>
    </form>
<?php endif; ?>

</body>
</html>