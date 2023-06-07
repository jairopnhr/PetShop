<?php

class ClienteService
{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addCliente($nome, $email, $senha,$papel)
    {
        $query = "INSERT INTO cliente (nome,  email, senha,papel) VALUES (:nome, :email, :senha,:papel)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':papel', $papel);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return "Cliente cadastrado com sucesso!";
        } else {
            return "Erro ao cadastrar o cliente.";
        }
    }
    public function removerCliente( $id)
    {
        $query = "DELETE cliente where id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
    }
    public function listarCliente(){
        $query = "SELECT * FROM cliente";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }
    public function buscarClientePeloId($clienteId) {
        $sql = "SELECT * FROM cliente WHERE id = :clienteId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':clienteId', $clienteId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function atualizarCliente($id ,$nome,$email,$senha){
    $sql = "UPDATE cliente SET nome = :nome, email = :email, senha =:senha  WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    
    return $stmt->execute() ;
    
    }
    public function isAdmin($username) {
        $query = "SELECT * FROM cliente WHERE nome = :username AND papel =  'ADM'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function usuarioAutenticado($username, $password) {
        $query = "SELECT * FROM cliente WHERE nome= :username AND senha = :password";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result; 
        } else {
            return false;
        }
    }

}




