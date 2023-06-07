<?php
require_once './controller/processar_cadastro.php';

// Verificar se o ID do cliente foi fornecido
if (isset($_POST['cliente_id'])) {
    $clienteId = $_POST['cliente_id'];
    $cone = new DatabaseConnection();
    // Instanciar o controlador de cliente
    $clienteController = new ClienteController($cone->connect());

    // Excluir o cliente
    $exclusaoSucesso = $clienteController->excluirClientePeloId($clienteId);

    if ($exclusaoSucesso) {
        echo '<div class="success">';
        echo '<p>Cliente excluído com sucesso.</p>';
        echo '</div>';
    } else {
        echo '<div class="error">';
        echo '<p>Ocorreu um erro ao excluir o cliente.</p>';
        echo '</div>';
    }
} else {
    echo '<div class="error">';
    echo '<p>ID do cliente não fornecido.</p>';
    echo '</div>';
}
?>