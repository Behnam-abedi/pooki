import Alpine from 'alpinejs';
import './modules/single-ajax';

document.addEventListener('alpine:init', () => {
  Alpine.store('cart', {
    open: false
  });
});

window.Alpine = Alpine;
Alpine.start();

if (typeof jQuery !== 'undefined') {
  jQuery(document.body).on('added_to_cart', function() {
    Alpine.store('cart').open = true;
  });
}
