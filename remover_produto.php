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
if (isset($_GET['produto_id'])) {
    $produto_id = $_GET['produto_id'];
    $cliente_id = $_SESSION['id'];
    $carrinhoController->removerProduto($cliente_id, $produto_id);
    header("Location: carrinho.php");
    exit;
}
