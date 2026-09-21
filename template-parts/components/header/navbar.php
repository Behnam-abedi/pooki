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
		
		<!-- Item 1: Right in RTL (Logo) -->
		<div class="site-branding flex-shrink-0">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				// Using Pooki Brand Color for Text Logo
				echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="text-2xl font-black text-pooki-pink hover:text-pooki-pink-dark transition-colors">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
			}
			?>
		</div>
		
		<!-- Item 2: Center (Navigation) -->
		<div class="desktop-menu hidden md:flex items-center flex-grow justify-center">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( [
					'theme_location'  => 'primary',
					'container'       => false,
					'menu_class'      => 'flex space-x-8 space-x-reverse font-medium text-gray-700',
					'fallback_cb'     => false,
				] );
			} else {
				echo '<ul class="flex space-x-8 space-x-reverse font-medium text-gray-700">';
				echo '<li><a href="#" class="hover:text-pooki-blue transition-colors">خانه</a></li>';
				echo '<li><a href="#" class="hover:text-pooki-blue transition-colors">فروشگاه</a></li>';
				echo '<li><a href="#" class="hover:text-pooki-blue transition-colors">تماس با ما</a></li>';
				echo '</ul>';
			}
			?>
		</div>

		<!-- Item 3: Left in RTL (Search, Cart, Login) -->
		<div class="flex items-center space-x-6 space-x-reverse flex-shrink-0">
			
			<!-- Minimalist Search -->
			<div class="hidden lg:block relative">
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative flex items-center">
					<input type="hidden" name="post_type" value="product" />
					<input type="search" name="s" placeholder="جستجو..." class="w-48 bg-gray-50 border border-gray-200 text-sm rounded-full py-2 pr-10 pl-4 focus:outline-none focus:ring-2 focus:ring-pooki-blue focus:border-transparent transition-all">
					<button type="submit" class="absolute right-3 text-gray-400 hover:text-pooki-blue">
						<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
					</button>
				</form>
			</div>

			<!-- Login Icon -->
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="text-gray-600 hover:text-pooki-blue transition-colors" aria-label="My Account">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
			</a>

			<!-- Cart Icon (Triggers Alpine Drawer) -->
			<button type="button" class="relative text-gray-600 hover:text-pooki-blue transition-colors" @click="$store.cart.toggle()" aria-label="Open cart">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
				<span id="pooki-cart-count" class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-pooki-pink text-xs font-bold text-white shadow-sm">
					<?php echo esc_html( class_exists( 'WooCommerce' ) ? WC()->cart->get_cart_contents_count() : 0 ); ?>
				</span>
			</button>

			<!-- Mobile Menu Toggle -->
			<button type="button" class="mobile-menu-toggle md:hidden text-gray-600 hover:text-pooki-blue" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle mobile menu">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
			</button>
		</div>
	</nav>
	
	<!-- Mobile Menu Dropdown -->
	<div class="mobile-menu md:hidden bg-gray-50 border-t border-gray-100" x-show="mobileMenuOpen" x-transition style="display: none;">
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
