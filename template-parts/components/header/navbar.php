<?php
/**
 * Header Navbar Component (RTL Layout)
 *
 * @package Pooki
 */
?>
<header class="site-header w-full bg-white shadow-sm sticky top-0 z-40" x-data="{ mobileMenuOpen: false }">
	<!-- Assume html dir="rtl", so flex row goes Right to Left -->
	<nav class="container mx-auto px-4 py-4 flex justify-between items-center" aria-label="Main Navigation">
		
		<!-- Right: Logo & Optional Nav -->
		<div class="flex items-center gap-x-8 flex-shrink-0">
			<!-- Logo -->
			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="text-2xl font-black text-pooki-pink hover:text-pooki-pink-dark transition-colors">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
				}
				?>
			</div>
			
			<!-- Desktop Navigation (Moved next to logo) -->
			<div class="desktop-menu hidden xl:flex items-center">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu( [
						'theme_location'  => 'primary',
						'container'       => false,
						'menu_class'      => 'flex gap-x-8 font-medium text-gray-700',
						'fallback_cb'     => false,
					] );
				} else {
					echo '<ul class="flex gap-x-8 font-medium text-gray-700">';
					echo '<li><a href="#" class="hover:text-pooki-blue transition-colors">خانه</a></li>';
					echo '<li><a href="#" class="hover:text-pooki-blue transition-colors">فروشگاه</a></li>';
					echo '<li><a href="#" class="hover:text-pooki-blue transition-colors">تماس با ما</a></li>';
					echo '</ul>';
				}
				?>
			</div>
		</div>

		<!-- Center: Live Search -->
		<div class="hidden lg:block w-full max-w-xl mx-4 relative" x-data="pookiSearch()">
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative flex items-center w-full" @submit.prevent>
				<input type="hidden" name="post_type" value="product" />
				<input type="search" name="s" x-model="query" @input.debounce.300ms="fetchResults" placeholder="جستجو در محصولات..." class="w-full bg-gray-100 text-sm rounded-full py-3 pr-12 pl-4 focus:outline-none focus:ring-2 focus:ring-pooki-blue transition-all border-none">
				<button type="button" class="absolute right-4 text-gray-500 hover:text-pooki-blue">
					<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
				</button>

				<!-- Loading Spinner -->
				<div x-show="isLoading" class="absolute left-4 text-pooki-blue" style="display: none;">
					<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
						<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
						<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
					</svg>
				</div>
			</form>

			<!-- Search Results Dropdown -->
			<div 
				x-show="results.length > 0 && query.length >= 3 && !isLoading" 
				@click.outside="results = []"
				class="absolute top-full right-0 mt-2 w-full bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50"
				style="display: none;"
				x-transition
			>
				<ul class="max-h-96 overflow-y-auto py-2">
					<template x-for="product in results" :key="product.id">
						<li>
							<a :href="product.url" class="flex items-center gap-4 px-4 py-3 hover:bg-gray-50 transition-colors">
								<div class="w-12 h-12 flex-shrink-0 bg-gray-100 rounded overflow-hidden" x-html="product.thumbnail"></div>
								<div class="flex-grow">
									<h4 class="text-sm font-bold text-gray-900" x-text="product.title"></h4>
									<div class="text-pooki-pink font-medium text-sm mt-1" x-html="product.price_html"></div>
								</div>
							</a>
						</li>
					</template>
				</ul>
				<div class="bg-gray-50 px-4 py-3 border-t border-gray-100 text-center">
					<a :href="'/?s=' + query + '&post_type=product'" class="text-sm font-bold text-pooki-blue hover:text-pooki-pink transition-colors">مشاهده همه نتایج</a>
				</div>
			</div>
			
			<!-- No Results Message -->
			<div x-show="results.length === 0 && query.length >= 3 && !isLoading" class="absolute top-full right-0 mt-2 w-full bg-white rounded-xl shadow-lg border border-gray-100 p-4 text-center text-gray-500 z-50" style="display: none;">
				محصولی یافت نشد.
			</div>
		</div>

		<!-- Left: Cart, Login, Mobile Toggle -->
		<div class="flex items-center gap-x-4 flex-shrink-0">
			
			<!-- Mobile Search Toggle (Optional, minimal implementation) -->
			<button type="button" class="lg:hidden flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full text-gray-700 hover:bg-pooki-blue hover:text-white transition-colors" aria-label="Search">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
			</button>

			<!-- Login Icon -->
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full text-gray-700 hover:bg-pooki-blue hover:text-white transition-colors" aria-label="My Account">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
			</a>

			<!-- Cart Icon (Triggers Alpine Drawer) -->
			<button type="button" class="relative flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full text-gray-700 hover:bg-pooki-blue hover:text-white transition-colors" @click="$store.cart.toggle()" aria-label="Open cart">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
				<span id="pooki-cart-count" class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-pooki-pink text-[10px] font-bold text-white shadow-sm">
					<?php echo esc_html( class_exists( 'WooCommerce' ) ? WC()->cart->get_cart_contents_count() : 0 ); ?>
				</span>
			</button>

			<!-- Mobile Menu Toggle -->
			<button type="button" class="lg:hidden flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full text-gray-700 hover:bg-pooki-blue hover:text-white transition-colors" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle mobile menu">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
			</button>
		</div>
	</nav>
	
	<!-- Mobile Menu Dropdown -->
	<div class="lg:hidden bg-gray-50 border-t border-gray-100" x-show="mobileMenuOpen" x-transition style="display: none;">
		<div class="px-4 py-4">
			<?php
			if ( has_nav_menu( 'mobile' ) ) {
				wp_nav_menu( [
					'theme_location'  => 'mobile',
					'container'       => false,
					'menu_class'      => 'flex flex-col space-y-4 text-gray-700 font-medium',
					'fallback_cb'     => false,
				] );
			} else {
				echo '<ul class="flex flex-col space-y-4 text-gray-700 font-medium">';
				echo '<li><a href="#" class="block hover:text-pooki-blue">خانه</a></li>';
				echo '<li><a href="#" class="block hover:text-pooki-blue">فروشگاه</a></li>';
				echo '<li><a href="#" class="block hover:text-pooki-blue">تماس با ما</a></li>';
				echo '</ul>';
			}
			?>
		</div>
	</div>
</header>
