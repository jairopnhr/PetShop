<?php
require_once './database/ConexaoPdo.php';
require_once './service/clienteservice.php';

class ClienteController
{
    private $clServi;
    public function __construct($cone)
    {
        $this->clServi = new ClienteService($cone);
    }
    public function addCliente($nome, $email, $senha,$papel)
    { 
        $resultado  =$this->clServi->addCliente( $nome, $email, $senha,$papel);   
        header('location:clientes.php');
        return $resultado;

       
    }
    public function excluirClientePeloId($id){

        $this->clServi->removerCliente($id);
    }
    public function listarClientes()
    {
        try {
            $cli = $this->clServi->listarCliente();
            return $cli;
        } catch (PDOException $e) {
            echo "Erro ao mostrar clientes" . $e->getMessage();
        }
    }
    public function buscarClientePeloId($id)
    {
        try {
      
                // Chame o método do serviço para buscar o cliente pelo ID
                $cliente = $this->clServi->buscarClientePeloId($id);
        
                // Faça o tratamento necessário caso o cliente não seja encontrado
        
                // Retorne o cliente encontrado para ser utilizado na view
                return $cliente;
        
        
        } catch (PDOException $e) {
            echo "Erro ao procurar destinatario";
        }
    }
    public function atualizarCliente($id ,$nome,$email,$senha)
    {
        try {

            return $this->clServi->atualizarCliente($id ,$nome,$email,$senha);
        } catch (PDOException $e) {
            echo "Erro ao procurar destinatario";
        }
    }
    public function VerfificarClienteADM( $usuario)
    {
        try {

            return $this->clServi->isAdmin( $usuario);
        } catch (PDOException $e) {
            echo "ERRO AO CONECTAR " . $e->getMessage();
        }
    }
    public function usuarioAutenticado($usuario,$senha){

    try {

        return $this->clServi->usuarioAutenticado(  $usuario,$senha);
    } catch (PDOException $e) {
        echo "ERRO AO CONECTAR " . $e->getMessage();
    }
}
}
