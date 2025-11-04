document.addEventListener("DOMContentLoaded", function () {
    // Adiciona um evento de clique ao botão "Comprar Agora"
    document.getElementById('pagar-mercadopago').addEventListener('click', function(event) {
        // Impede o comportamento padrão do botão, como enviar um formulário
        event.preventDefault(); 

        // URL de pagamento do Mercado Pago.
        // IMPORTANTE: Este é apenas um link de exemplo para demonstração.
        // Em um ambiente real, esta URL vai ser gerada pelo nosso servidor (backend)
        // apde pagamento no Mercado Pago.ós a criação da preferência 
        const urlMercadoPago = 'https://www.mercadopago.com.br/checkout/v1/redirect?pref_id=SEU_ID_DA_PREFERENCIA';

        // Redireciona o usuário para a página de pagamento
        window.location.href = urlMercadoPago;
    });
});
