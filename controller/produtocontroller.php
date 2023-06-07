<?php
require_once './database/ConexaoPdo.php';
require_once './service/produtoservice.php';
class ProdutoController
{
    private $pdrServi;
    public function __construct($cone)
    {
        $this->pdrServi = new ProdutoService($cone);
    }
    public function addproduto( $nome, $valor, $tipo,$quantidadeProduto,$tipoAnimal,$imagem)
    {
            try {
                $this->pdrServi->addProduto( $nome, $valor, $tipo,$quantidadeProduto,$tipoAnimal,$imagem);
            } catch (PDOException $e) {
                echo "Erro ao cadastrar" . $e->getMessage();
            }

            $conexao = null;

    }
    public function listarProdutos()
    {
        try {

            $cli = $this->pdrServi->listarproduto();
            return $cli;
        } catch (PDOException $e) {
            echo "Erro ao mostrar produtos" . $e->getMessage();
        }
    }
    public function buscarprodutoPeloId($id)
    {
        try {

            $buscar = $this->pdrServi->buscarprodutoPeloId($id);
            return $buscar;
        } catch (PDOException $e) {
            echo "Erro ao procurar destinatario";
        }
    }
    public function buscarValorProdutoPeloId($id)
    {
        try {

            $buscar = $this->pdrServi->buscarPeloValorPeloId($id);
            return $buscar;
        } catch (PDOException $e) {
            echo "Erro ao procurar destinatario";
        }
    }
    public function atualizarproduto($nome, $email, $senha)
    {
        try {

            return $this->pdrServi->atualizarproduto($nome, $email, $senha);
        } catch (PDOException $e) {
            echo "Erro ao procurar destinatario";
        }
    }
      
}
