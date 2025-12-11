// Funções do popup
function abrirPopup(){ document.getElementById('popup').style.display = 'flex'; }
function fecharPopup(){ document.getElementById('popup').style.display = 'none'; }
function voltarHome(){ window.location.href = "index.html"; }

// Atualizar valores e remover itens
const cartItems = document.getElementById('cart-items');
const subtotalEl = document.getElementById('subtotal');
const totalEl = document.getElementById('total');

function atualizarTotal(){
  let total = 0;
  cartItems.querySelectorAll('.cart-item').forEach(item => {
    const qty = parseInt(item.querySelector('input').value);
    const priceText = item.querySelector('.price').textContent.replace('R$', '').replace(',', '.');
    const price = parseFloat(priceText);
    total += qty * price;
  });
  subtotalEl.textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
  totalEl.textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
}

// Eventos de quantidade e remover
cartItems.addEventListener('click', e => {
  if(e.target.classList.contains('btn-qty')){
    const input = e.target.parentElement.querySelector('input');
    if(e.target.textContent === '−' && input.value > 1){
      input.value--;
    } else if(e.target.textContent === '+'){
      input.value++;
    }
    atualizarTotal();
  }
  if(e.target.classList.contains('item-remove')){
    e.target.closest('.cart-item').remove();
    atualizarTotal();
  }
});

// Atualiza ao digitar quantidade
cartItems.addEventListener('input', e => {
  if(e.target.tagName === 'INPUT'){
    atualizarTotal();
  }
});

// Função para adicionar produto diferente
function adicionarProduto(){
  const novoProduto = document.createElement('article');
  novoProduto.classList.add('cart-item');
  novoProduto.innerHTML = `
    <div class="thumb"><img src="../public/assets/img/batata.png" alt="Batata"></div>
    <div class="item-info">
      <h3 class="item-title">Batata (1kg)</h3>
      <p class="item-meta">Vendido por Agro Vale</p>
      <button class="item-remove">Remover</button>
    </div>
    <div class="item-actions">
      <div class="qty">
        <button class="btn-qty">−</button>
        <input type="number" value="1" min="1">
        <button class="btn-qty">+</button>
      </div>
      <div class="price">R$ 24,90</div>
    </div>
  `;
  cartItems.appendChild(novoProduto);
  atualizarTotal();
}
const cartBadge = document.getElementById('cart-badge');

function atualizarTotal(){
  let total = 0;
  let count = 0;
  cartItems.querySelectorAll('.cart-item').forEach(item => {
    const qty = parseInt(item.querySelector('input').value);
    const priceText = item.querySelector('.price').textContent.replace('R$', '').replace(',', '.');
    const price = parseFloat(priceText);
    total += qty * price;
    count += qty; // soma quantidade de itens
  });
  subtotalEl.textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
  totalEl.textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
  cartBadge.textContent = count; // atualiza badge
}
