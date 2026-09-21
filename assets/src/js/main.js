import Alpine from 'alpinejs';
import './modules/single-ajax';

document.addEventListener('alpine:init', () => {
  Alpine.store('cart', {
    isOpen: false,
    toggle() {
      this.isOpen = !this.isOpen;
    }
  });

  Alpine.data('pookiSearch', () => ({
    query: '',
    results: [],
    isLoading: false,
    async fetchResults() {
      if (this.query.length < 3) {
        this.results = [];
        return;
      }
      this.isLoading = true;
      try {
        const response = await fetch(`/wp-admin/admin-ajax.php?action=pooki_live_search&s=${encodeURIComponent(this.query)}`);
        const data = await response.json();
        if (data.success) {
          this.results = data.data;
        } else {
          this.results = [];
        }
      } catch (error) {
        console.error('Search error:', error);
        this.results = [];
      } finally {
        this.isLoading = false;
      }
    }
  }));
});

window.Alpine = Alpine;
Alpine.start();

if (typeof jQuery !== 'undefined') {
  jQuery(document.body).on('added_to_cart', function() {
    Alpine.store('cart').isOpen = true;
  });
}
