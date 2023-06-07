<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

require_once './controller/carrinhocontroller.php';
require_once './database/ConexaoPdo.php';

$cone = new DatabaseConnection();
$carrinhoController = new CarrinhoController($cone->connect());
$cliente_id = $_SESSION['id'];

// Verificar se o carrinho está vazio
if ($carrinhoController->verificarCarrinhoVazio($cliente_id)) {
    echo "Seu carrinho está vazio.";
    exit;
}

// Listar os produtos do carrinho
$produtos = $carrinhoController->listarProdutos($cliente_id);

// Calcular o total do pedido
$total = 0;
foreach ($produtos as $produto) {
    $total += $produto['valor'] * $produto['quantidade'];
}

// Processar o pagamento (simulação)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lógica de processamento do pagamento
    // Aqui você pode adicionar sua integração com meios de pagamento, como API de pagamento ou gateway de pagamento.

    // Limpar o carrinho após o pagamento
    $carrinhoController->limparCarrinho($cliente_id);

    // Redirecionar para a página de confirmação
    header("Location: confirmacao.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmação do Pedido</title>
    <link rel="stylesheet" href="./css/geral.css">
    <link rel="stylesheet" href="./css/menu.css">
    <link rel="shortcut icon" type="imagex/png" href="./assets/icone.ico">
</head>
<body>
<div class="menu">
    <div>  
    </div>
    <ul>
        <!-- Seus itens de menu aqui -->
    </ul>
    <div>
        <?php echo $_SESSION["username"]; ?>
        <div>
    </div>
    </div>
</div>

<h1>Confirmação do Pedido</h1>

<table>
    <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Preço Unitário</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produtos as $produto) : ?>
            <tr>
                <td><?php echo $produto['nome']; ?></td>
                <td><?php echo $produto['quantidade']; ?></td>
                <td>R$ <?php echo $produto['valor']; ?></td>
                <td>R$ <?php echo $produto['valor'] * $produto['quantidade']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total:</th>
            <td>R$ <?php echo $total; ?></td>
        </tr>
    </tfoot>
</table>

<form method="post">
    <button type="submit">Realizar Pagamento</button>
</form>

</body>
</html>