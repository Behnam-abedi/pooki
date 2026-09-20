import Alpine from 'alpinejs';

document.addEventListener('alpine:init', () => {
  Alpine.store('cart', {
    open: false
  });
});

window.Alpine = Alpine;
Alpine.start();
