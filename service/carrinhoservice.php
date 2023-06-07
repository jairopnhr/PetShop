<?php
class CarrinhoService
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function adicionarProduto($cliente_id, $produto_id, $quantidade)
    {
        $carrinho = $this->verificarCarrinho($cliente_id);

        if ($carrinho) {
            $carrinho_id = $carrinho['id'];
            $novaQuantidade = $carrinho['quantidade'] + $quantidade;
            $this->atualizarQuantidadeProduto($carrinho_id, $novaQuantidade);
        } else {
            $this->criarCarrinho($cliente_id, $produto_id, $quantidade);
        }
    }

    private function verificarCarrinho($cliente_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM carrinho WHERE cliente_id = :cliente_id");
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function criarCarrinho($cliente_id, $produto_id, $quantidade)
    {
        $stmt = $this->conn->prepare("INSERT INTO carrinho (cliente_id, produto_id, quantidade) 
        VALUES (:cliente_id, :produto_id, :quantidade)");
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->bindParam(':produto_id', $produto_id);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function listarProdutosDoCarrinho($cliente_id)
    {
        $sql = "SELECT p.id, p.nome, p.valor, c.quantidade
        FROM carrinho c
        INNER JOIN produto p ON c.produto_id = p.id
        WHERE c.cliente_id = :cliente_id";

     
$stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->execute();
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $produtos;
    }

    public function removerProduto($carrinho_id, $produto_id)
    {
        $sql = "DELETE FROM carrinho WHERE id = :carrinho_id AND produto_id = :produto_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':carrinho_id', $carrinho_id);
        $stmt->bindParam(':produto_id', $produto_id);
        $stmt->execute();
    }
    private function atualizarQuantidadeProduto($carrinho_id, $nova_quantidade)
    {
        $stmt = $this->conn->prepare("UPDATE carrinho SET quantidade = :nova_quantidade WHERE id = :carrinho_id");
        $stmt->bindParam(':nova_quantidade', $nova_quantidade);
        $stmt->bindParam(':carrinho_id', $carrinho_id);
        $stmt->execute();
    }
    public function limparCarrinho($cliente_id) {
        $query = "DELETE FROM carrinho WHERE cliente_id = :cliente_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function verificarCarrinhoVazio($cliente_id) {
        $query = "SELECT COUNT(*) as total FROM carrinho WHERE cliente_id = :cliente_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cliente_id", $cliente_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'] === '0';
    }
}
