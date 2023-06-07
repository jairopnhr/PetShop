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
require_once './controller/produtocontroller.php';
require_once './service/produtoservice.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $tipo = $_POST['tipo'];
    $tipo_animal = $_POST['tipo_animal'];
    $qtd_produto = $_POST['qdt_produto'];
    $imagem = $_FILES['imagem'];

    $diretorioDestino = './imagens/';
    $nomeArquivo = uniqid() . '_' . $imagem['name'];

    $caminhoCompleto = $diretorioDestino . $nomeArquivo;
    move_uploaded_file($imagem['tmp_name'], $caminhoCompleto);
    $dbConnection = new DatabaseConnection();
    $conn = $dbConnection->connect();
    $produtoController = new ProdutoController($conn);
    $produtoController->addproduto($nome, $valor, $tipo,$qtd_produto,$tipo_animal, $nomeArquivo);
    $dbConnection->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="./css/geral.css" >
    <link rel="stylesheet" href="./css/menu.css">
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

    </ul>
        <div>

        </div>
    </div>

    <h2>Cadastrar Produto</h2>
    <div class="container">
    <form method="POST" enctype="multipart/form-data" action="cadastrar_produto.php">
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="valor">Valor:</label>
        <input type="number" id="valor" name="valor" step="0.01" required>
        <label for="valor">Quantidade do produto</label>
        <input type="number" id="qdt_produto" name="qdt_produto" step="1.0" required>

        <label for="tipo">Tipo de Produto:</label>
        <select id="tipo" name="tipo" required>
            <option value="">Selecione</option>
            <option value="medicamento">Medicamento</option>
            <option value="racao">Ração</option>
        </select>
        <label for="tipo">Tipo de Animal:</label>
        <select id="tipo" name="tipo_animal" required>
            <option value="">Selecione</option>
            <option value="medicamento">Gato</option>
            <option value="racao">Cachorro</option>
            <option value="racao">Papagaio</option>
        </select>
        <label for="imagem">Imagem do Produto:</label>
        <input type="file" id="imagem" name="imagem" required>

        <input type="submit" value="Cadastrar Produto">
    </form>
    </div>
    <footer>
        <p>© 2023 Meu Site. Todos os direitos reservados.</p>
    </footer> 
</body>
</html>