<?php

class ProdutoService
{
    public $conn;
    public function __construct($conn)
    {
        $this->conn =$conn;
    }

    public function addProduto( $nome, $valor, $tipo,$quantidadeProduto,$tipoAnimal,$imagem)
    {
        $query = "INSERT INTO produto (nome,valor,tipo,tipo_animal,qtd_produto,imagem) VALUES ( ? ,? ,? ,?,?,?)";
        $stmt = $this->conn ->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $valor);
        $stmt->bindParam(3, $tipo);
        
        $stmt->bindParam(4, $tipoAnimal);
        $stmt->bindParam(5, $quantidadeProduto);
        
        $stmt->bindParam(6, $imagem);
        $stmt->execute();

    }
    public function removerProduto( $id)
    {
        $query = "DELETE produto where id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $conexao = null;
        return true;
    }
    public function listarProduto(){
        $sql = "SELECT * FROM produto";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conexao = null;

        return $produtos;
    }
    public function buscarProdutoPeloId($id){
        $query = "SELECT * FROM produto where id =:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',$id ,PDO::PARAM_INT);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }
    public function atualizarproduto($nome,$valor){
    $sql = "UPDATE produto SET nome = :nome, valor = :valor,  WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
    return $stmt->execute() ;
    }
    public function buscarPeloValorPeloId($id){
        $query = "SELECT valor FROM produto where id =:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',$id ,PDO::PARAM_INT);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }
        
    public function getProdutoPorId($produtoId) {
        $query = "SELECT * FROM produto WHERE id = :produtoId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':produtoId', $produtoId, PDO::PARAM_INT);
        $stmt->execute();

        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        return $produto ? $produto : null;
    }    
    
    }