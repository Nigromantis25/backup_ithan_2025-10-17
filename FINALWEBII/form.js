// Este archivo quedó solo para exponer control mínimo; la lógica de checkout está en carrito.js
document.addEventListener('DOMContentLoaded', function(){
  const cancel = document.querySelector('#cancelPurchase');
  if (cancel) cancel.addEventListener('click', () => { document.querySelector('#checkoutForm').style.display = 'none'; });
});
  