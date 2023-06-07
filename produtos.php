<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

require_once './controller/produtocontroller.php';
require_once './controller/carrinhocontroller.php';
require_once './database/ConexaoPdo.php';

$cone = new DatabaseConnection();
$carrinhoController = new CarrinhoController($cone->connect());
$produtoController = new ProdutoController($cone->connect());

if (isset($_GET['produto_id'])) {
    $produto_id = $_GET['produto_id'];
   
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

$produtos = $produtoController->listarProdutos();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Página de Produtos</title>
    <link rel="stylesheet" href="estilos.css">
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
    <div>  
    </div>
    <ul>
    <?php if (isset($_SESSION['ADM']) && $_SESSION['ADM'] === true): ?>
        <li><a href="cadastrar.php">Cadastrar Cliente</a></li>
    <?php endif; ?>
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
    </div>
</div>

<?php foreach ($produtos as $produto): ?>
    <div class="produto">
        <div class="card">
            <img src="./imagens/<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>">
            <h3><?php echo $produto['nome']; ?></h3>
            <p>Preço: R$ <?php echo $produto['valor']; ?></p>
            <form method="post" action="produtos.php?produto_id=<?php echo $produto['id']; ?>">
                <label for="quantidade">Quantidade:</label>
                <input type="number" name="quantidade" id="quantidade" value="1" min="1">
                <button type="submit">Adicionar ao Carrinho</button>
            </form>
        </div>
    </div>
    <hr>
<?php endforeach; ?>

</body>
</html>
