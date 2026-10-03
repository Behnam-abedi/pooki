import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import Alpine from 'alpinejs';
import './modules/single-ajax';

document.addEventListener('alpine:init', () => {
  Alpine.store('cart', {
    isOpen: false,
    toggle() {
      this.isOpen = !this.isOpen;
    }
  });

  Alpine.store('nav', {
    mobileMenuOpen: false,
    searchOpen: false,
    toggleMobileMenu() {
      this.mobileMenuOpen = !this.mobileMenuOpen;
    }
  });

  Alpine.effect(() => {
    if (Alpine.store('nav').mobileMenuOpen || Alpine.store('nav').searchOpen || Alpine.store('cart').isOpen) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
  });

  Alpine.store('search', {
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
    },
    goToSearch() {
      if (this.query.trim().length > 0) {
        window.location.href = `/?s=${encodeURIComponent(this.query)}&post_type=product`;
      }
    }
  });

  Alpine.data('pookiLiveSearch', () => ({
    get query() { return Alpine.store('search').query; },
    set query(val) { Alpine.store('search').query = val; },
    get results() { return Alpine.store('search').results; },
    set results(val) { Alpine.store('search').results = val; },
    get isLoading() { return Alpine.store('search').isLoading; },
    fetchResults() { return Alpine.store('search').fetchResults(); },
    goToSearch() { return Alpine.store('search').goToSearch(); }
  }));
});

window.Alpine = Alpine;
Alpine.start();

if (typeof jQuery !== 'undefined') {
  jQuery(document.body).on('added_to_cart', function() {
    Alpine.store('cart').isOpen = true;
  });
}

window.Swiper = Swiper;
window.SwiperModules = { Navigation, Pagination, Autoplay };
