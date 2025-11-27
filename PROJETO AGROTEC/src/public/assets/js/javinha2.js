// Tela 1 - Verifica se um método foi selecionado
function verificacao() {
  const selecionado = document.querySelector('input[name="metodo"]:checked');
  if (!selecionado) {
    alert("Por favor, selecione um método de verificação.");
  } else {
    window.location.href = "codigo.html";
  }
}

// Tela 2 - Verifica se o código tem 6 dígitos
function codigo() {
  const codigo = document.querySelector(".input-codigo").value;
  if (codigo.length !== 6 || isNaN(codigo)) {
    alert("Digite um código válido de 6 números.");
  } else {
    window.location.href = "nova-senha.html";
  }
}

// Tela 3 - Confirma se as senhas coincidem
function novaSenha() {
  const senha1 = document.querySelectorAll(".input-codigo")[0].value;
  const senha2 = document.querySelectorAll(".input-codigo")[1].value;

  if (!senha1 || !senha2) {
    alert("Preencha os dois campos de senha.");
    return;
  }

  if (senha1 !== senha2) {
    alert("As senhas não coincidem!");
  } else {
    alert("Senha redefinida com sucesso!");
  }
}