<?php
session_start();
require_once("./database/ConexaoPdo.php");
require_once('./controller/produtocontroller.php');
// Verificar se o carrinho de compras está vazio

if (empty($_SESSION['cart'])) {
    echo 'O carrinho de compras está vazio.';
} else {
    try{
        $conn = new DatabaseConnection();
        $prtController = new ProdutoController($ser);
    foreach ($_SESSION['cart'] as $product_id => $item) {
        $product =    $prtController->buscarprodutoPeloId($product_id);
        if ($product) {
            $product_name = $product['nome'];
            $product_price = $product['valor'];
            
            $subtotal = $product_price * $item['quantity'];
            
            echo '<tr>';
            echo '<td>' . $product_name . '</td>';
            echo '<td>' . $item['quantity'] . '</td>';
            echo '<td>R$' . number_format($subtotal, 2, ',', '.') . '</td>';
            echo '</tr>';
        }
    }
    
    echo '</table>';
    $total = 0;
    
    foreach ($_SESSION['cart'] as $product_id => $item) {
        $product = $prtController->buscarValorProdutoPeloId($product_id);
        if ($product) {
            $product_price = $product['valor'];
            $subtotal = $product_price * $item['quantity'];
            $total += $subtotal;
        }
    }
    echo '<p>Total: R$' . number_format($total, 2, ',', '.') . '</p>';
    $conn = null;
} catch (PDOException $e) {
    echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
}
}
?>
