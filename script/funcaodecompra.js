function comprarProduto(id) {
    // Aqui você pode adicionar a lógica para processar a compra do produto
    // Por exemplo, enviar uma requisição para um backend ou atualizar o status do produto no banco de dados

    // Exemplo de requisição AJAX usando jQuery
    $.post("comprar_produto.php", {
            produto_id: id
        })
        .done(function(response) {
            // Exemplo de mensagem de sucesso
            alert(response);

            // Recarregar a página ou redirecionar para outra página, se necessário
            location.reload();
        })
        .fail(function() {
            // Exemplo de mensagem de erro
            alert("Ocorreu um erro ao processar a compra.");
        });
}

// Adicionar evento de clique aos botões de compra
var btnComprar = document.getElementsByClassName("btn-comprar");
for (var i = 0; i < btnComprar.length; i++) {
    btnComprar[i].addEventListener("click", function() {
        var productId = this.getAttribute("data-id");
        comprarProduto(productId);
    });
}