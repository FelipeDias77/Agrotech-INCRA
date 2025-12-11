// Este código deve ser colocado em um novo arquivo, por exemplo, 'selecionarLocal.js'

// Espera que o HTML seja carregado completamente.
document.addEventListener('DOMContentLoaded', () => {

    // Seleciona o botão 'Selecionar'.
    const botaoSelecionar = document.querySelector('.button.authorize');
    
    // Adiciona a ação de clique ao botão.
    botaoSelecionar.addEventListener('click', () => {
        
        // Encontra o botão de rádio que está selecionado.
        const radioSelecionado = document.querySelector('input[name="cidade"]:checked');

        // Se uma opção foi escolhida...
        if (radioSelecionado) {
            
            // Pega o texto do rótulo associado à opção.
            const cidadeSelecionada = radioSelecionado.nextElementSibling.textContent.trim();
            
            // Salva a cidade no armazenamento local do navegador.
            localStorage.setItem('cidadeUsuario', cidadeSelecionada);

            // Redireciona o usuário para a página principal.
            window.location.href = 'index.html';

        } else {
            // Se o usuário não selecionou nada, avisa com um pop-up.
            alert('Por favor, selecione uma cidade para continuar.');
        }
    });
});