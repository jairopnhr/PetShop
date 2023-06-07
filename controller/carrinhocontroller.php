<?php
require_once './service/carrinhoservice.php';

class CarrinhoController {
    private $carrinhoService;

    public function __construct($conn) {
        $this->carrinhoService = new CarrinhoService($conn);
    }

    public function adicionarProduto($cliente_id, $produto_id, $quantidade) {
        $this->carrinhoService->adicionarProduto($cliente_id, $produto_id, $quantidade);
    }

    public function listarProdutos($cliente_id) {
        return $this->carrinhoService->listarProdutosDoCarrinho($cliente_id);
    }

    public function removerProduto($carrinho_id, $produto_id) {
        $this->carrinhoService->removerProduto($carrinho_id, $produto_id);
    }
    public function limparCarrinho($cliente_id){
        $this->carrinhoService->limparCarrinho($cliente_id);
    }

    public function verificarCarrinhoVazio($cliente_id){
        return $this->carrinhoService->verificarCarrinhoVazio($cliente_id);
    }
}