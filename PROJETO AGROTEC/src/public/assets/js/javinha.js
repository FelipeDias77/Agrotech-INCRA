// Logo
// Quando o mouse passar sobre o ícone
document.querySelector('.icon-btn').addEventListener('mouseenter', function() {
    var textElement = document.getElementById('typed-text');
    var textToShow = "| AgroTech"; // Texto que você quer que apareça
    
    textElement.innerHTML = textToShow; // Coloca o texto diretamente
    textElement.style.opacity = 1; // Faz o texto aparecer com efeito fade-in
});

// LOGIN
document.addEventListener("DOMContentLoaded", () => {
    const perfilBtn = document.getElementById("perfil-btn");
    const options = document.getElementById("options");

    // Mostra ou oculta as opções ao clicar no botão
    perfilBtn.addEventListener("click", (e) => {
        e.stopPropagation(); // Impede que o clique no botão feche as opções
        options.classList.toggle("show"); // Alterna a visibilidade das opções
    });

    // Fecha as opções ao clicar fora da área de opções
    document.addEventListener("click", (e) => {
        if (!options.contains(e.target) && e.target !== perfilBtn) {
            options.classList.remove("show"); // Remove a classe "show" para esconder as opções
        }
    });
});

// Esconde as opções ao clicar em qualquer outro lugar, caso esteja visível
document.addEventListener("click", () => {
    if (options.classList.contains("show")) {
        options.classList.remove("show");
    }
});

// Impede o fechamento ao clicar nas próprias opções
options.addEventListener("click", (e) => {
    e.stopPropagation(); // Impede que o clique dentro das opções feche elas
});

// BARRA LATERAL
const menu = document.querySelector('.menu');
const toggleButton = document.querySelector('#toggleButton');

let isMenuVisible = false;

toggleButton.addEventListener('click', () => {
    if (isMenuVisible) {
        menu.style.left = '-200px'; // Esconde a barra lateral
        toggleButton.style.left = '20px'; // Mantém o botão na posição inicial
    } else {
        menu.style.left = '0'; // Exibe a barra lateral
        toggleButton.style.left = '165px'; // Move o botão para acompanhar a barra lateral
    }

    isMenuVisible = !isMenuVisible;
});

document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.querySelector(".carousel__viewport");
    let index = 0;
  
    function nextSlide() {
      const slides = document.querySelectorAll(".carousel__slide");
      index = (index + 1) % slides.length; // Loop infinito
      carousel.scrollTo({
        left: slides[index].offsetLeft,
        behavior: "smooth"
      });
    }
  
    setInterval(nextSlide, 5000); // Troca de slide a cada 5 segundos
  });

// DJOFFA
const form = document.getElementById('loginForm');
const nome = document.getElementById('nome');
const cpf = document.getElementById('cpf');
const email = document.getElementById('senha');

// Evento de envio do formulário
form.addEventListener('submit', function (e) {
    e.preventDefault(); // Impede o envio do formulário para evitar recarregar a página

    // Validação básica
    if (!nome.value.trim()) {
        alert('Por favor, preencha o campo Nome Completo.');
        nome.focus();
        return;
    }

    if (!cpf.value.trim()) {
        alert('Por favor, preencha o campo CPF.');
        cpf.focus();
        return;
    }

    if (!senha.value.trim()) {
        alert('Por favor, preencha o campo Senha');
        senha.focus();
        return;
    }

    // Mensagem de sucesso simulada
    alert('Login realizado com sucesso!');
});

// Função para criar nova conta
document.getElementById('createAccount').addEventListener('click', function () {
    alert('Funcionalidade Criar Nova Conta em desenvolvimento!');
    window.location.href = 'selecionarLocal.html';
});

// Função para recuperar senha
document.getElementById('forgotPassword').addEventListener('click', function (e) {
    e.preventDefault();
    alert('Funcionalidade Esqueceu a Senha em desenvolvimento!');
});  