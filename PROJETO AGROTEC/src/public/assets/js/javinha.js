/**
 * javinha.js
 * * Este arquivo contém as interações JavaScript para o e-commerce AgroTech, 
 * cobrindo funcionalidades em diversas páginas (Home, Login, Layout Comum).
 */

// 1. Variável Global para a URL da Home (Melhora Manutenção)
const HOME_URL = 'index.html';

// ==========================================
// 2. Lógica do Header (Efeito Logo e Dropdown)
// ==========================================

// Função para o efeito de texto na logo (Se aplicável no layout principal)
function initLogoHover() {
    // Usando seletores do seu código original que referenciam elementos de logo/texto
    const iconBtn = document.querySelector('.icon-btn');
    const textElement = document.getElementById('typed-text');
    
    if (!iconBtn || !textElement) return;

    const textToShow = "| AgroTech"; 

    // Oculta o texto ao sair do foco
    iconBtn.addEventListener('mouseleave', function() {
         textElement.innerHTML = ''; // Limpa o texto
         textElement.style.opacity = 0; // Esconde com fade-out (se houver CSS de transição)
    });

    // Mostra o texto ao passar o mouse
    iconBtn.addEventListener('mouseenter', function() {
        textElement.innerHTML = textToShow; 
        textElement.style.opacity = 1; 
    });
}


// Função para inicializar o dropdown de perfil (Se for usado na Home/Produtos)
function initProfileDropdown() {
    const perfilBtn = document.getElementById("perfil-btn");
    const options = document.getElementById("options");

    // Retorna se os elementos não existirem na página atual
    if (!perfilBtn || !options) return; 

    // Mostra ou oculta as opções ao clicar no botão
    perfilBtn.addEventListener("click", (e) => {
        e.stopPropagation(); 
        options.classList.toggle("show");
    });

    // Fecha as opções ao clicar fora do dropdown
    document.addEventListener("click", (e) => {
        // Verifica se o clique não foi no botão e nem dentro das opções
        if (!perfilBtn.contains(e.target) && !options.contains(e.target)) {
            options.classList.remove("show");
        }
    });

    // Impede que um clique dentro das opções a feche imediatamente
    options.addEventListener("click", (e) => {
        e.stopPropagation(); 
    });
    
    // Seu código original tinha esta repetição, que é desnecessária se o código acima estiver ativo:
    // document.addEventListener("click", () => {
    //     if (options.classList.contains("show")) {
    //         options.classList.remove("show");
    //     }
    // });
}

// ==========================================
// 3. Lógica da Barra Lateral (Menu Mobile/Sidebar)
// ==========================================

function initSideBar() {
    const menu = document.querySelector('.menu'); // O bloco de links
    const toggleButton = document.querySelector('#toggleButton'); // O ícone de toggle (n.png)
    
    if (!menu || !toggleButton) return;

    let isMenuVisible = false;

    toggleButton.addEventListener('click', () => {
        if (isMenuVisible) {
            // Esconde: Deixa a responsabilidade de animação para o CSS (melhor prática)
            // Se estiver usando o CSS do seu código original:
            menu.style.left = '-200px'; 
            toggleButton.style.left = '20px'; 
            // Uma melhoria seria usar classes CSS (e.g., menu.classList.remove('active'))
        } else {
            // Exibe
            menu.style.left = '0'; 
            toggleButton.style.left = '165px'; 
        }

        isMenuVisible = !isMenuVisible;
    });
}


// ==========================================
// 4. Lógica do Carousel (Slide Automático)
// ==========================================

function initCarousel() {
    const carousel = document.querySelector(".carousel__viewport");
    if (!carousel) return; 
    
    let index = 0;
    const intervalTime = 5000; // 5 segundos

    function nextSlide() {
        const slides = document.querySelectorAll(".carousel__slide");
        if (slides.length === 0) return;

        index = (index + 1) % slides.length; 
        
        if (slides[index]) { 
            carousel.scrollTo({
                left: slides[index].offsetLeft,
                behavior: "smooth"
            });
        }
    }
    
    setInterval(nextSlide, intervalTime);
}

// ==========================================
// 5. Lógica dos Formulários (Login/Cadastro/Verificação)
// ==========================================

// Função para lidar com o envio e validação do Formulário de Login/Cadastro
function initAuthForms() {
    // --- Lógica de Validação (DJOFFA) ---
    const form = document.getElementById('loginForm');
    const nomeInput = document.getElementById('nome');
    const cpfInput = document.getElementById('cpf');
    const senhaInput = document.getElementById('senha'); 

    if (form) { // Só executa se o formulário de login estiver na página
        form.addEventListener('submit', function (e) {
            e.preventDefault(); 

            let isValid = true;
            
            const validateField = (input, message) => {
                if (!input || !input.value.trim()) {
                    alert(message);
                    input.focus();
                    isValid = false;
                    return false;
                }
                return true;
            };

            // Certifique-se de que os IDs existam na página
            if (
                validateField(nomeInput, 'Por favor, preencha o campo Nome Completo.') &&
                validateField(cpfInput, 'Por favor, preencha o campo CPF.') &&
                validateField(senhaInput, 'Por favor, preencha o campo Senha.')
            ) {
                alert('Login realizado com sucesso! (Simulado)');
                // Aqui você faria a requisição final
                // form.submit();
            }
        });
    }
    
    // --- Funções Auxiliares (Botões) ---
    document.getElementById('createAccount')?.addEventListener('click', function () {
        alert('Funcionalidade Criar Nova Conta em desenvolvimento!');
        window.location.href = 'selecionarLocal.html'; 
    });

    document.getElementById('forgotPassword')?.addEventListener('click', function (e) {
        e.preventDefault();
        alert('Funcionalidade Esqueceu a Senha em desenvolvimento!');
    });
}

// ==========================================
// 6. Inicialização Global (Execução após o carregamento do DOM)
// ==========================================

document.addEventListener("DOMContentLoaded", () => {
    console.log("AgroTech: DOM totalmente carregado. Inicializando scripts multipage...");
    
    // Inicializações de Layout Comum (Header/Sidebar/Logo)
    initLogoHover(); 
    initProfileDropdown(); 
    initSideBar(); 

    // Inicializações específicas de Página
    initAuthForms();
    initCarousel(); 
});