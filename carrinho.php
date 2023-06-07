<?php

require_once './database/ConexaoPdo.php';
require_once './controller/carrinhocontroller.php';
session_start();
$conn = new DatabaseConnection();
$carrinhoController = new CarrinhoController($conn->connect());

if (isset($_GET['produto_id'])) {
    $produto_id = $_GET['produto_id'];
    $produtoController = new ProdutoController($conn->connect());
    $produto = $produtoController->buscarprodutoPeloId($produto_id);
    
    if ($produto) {
        $cliente_id = $_SESSION['id'];
        $quantidade = $_POST['quantidade'] ?? 1;
        
        $carrinhoController->adicionarProduto($cliente_id, $produto_id, $quantidade);
        header("Location: carrinho.php");
        exit;
    } else {
        echo "Produto não encontrado";
        exit;
    }
}

$id_usuario = $_SESSION['id']; 
$carrinhoProdutos = $carrinhoController->listarProdutos($id_usuario);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carrinho</title>
    <link rel="stylesheet" href="./css/geral.css">
    <link rel="stylesheet" href="./css/menu.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <link rel="stylesheet" href="./css/card.css">
    <link rel="stylesheet" href="./css/carousel.css">
    <link rel="shortcut icon" type="image/x-icon" href="./assets/icone.ico">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        a {
            color: #337ab7;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php if (empty($carrinhoProdutos)) : ?>
        <p>O carrinho está vazio.</p>
    <?php else : ?>
        <table>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th></th>
            </tr>
            <?php foreach ($carrinhoProdutos as $produto) : ?>
                <tr>
                    <td><?php echo $produto['nome']; ?></td>
                    <td>R$ <?php echo $produto['valor']; ?></td>
                    <td>
                        <form method="post" action="atualizar_quantidade.php">
                            <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                            <input type="number" name="quantidade" value="<?php echo $produto['quantidade']; ?>">
                            <button type="submit">Atualizar</button>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="remover_produto.php">
                            <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                            <button type="submit">Remover</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
