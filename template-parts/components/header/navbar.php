<?php
/**
 * Header Navbar Component
 *
 * @package Pooki
 */
?>
<header class="site-header w-full bg-white shadow-sm" x-data="{ mobileMenuOpen: false }">
	<nav class="container mx-auto px-4 py-4 flex justify-between items-center" aria-label="Main Navigation">
		<div class="site-branding">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="text-xl font-bold text-gray-800">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
			}
			?>
		</div>
		
		<div class="desktop-menu hidden md:flex items-center space-x-6">
			<!-- Desktop Menu Placeholder -->
		</div>

		<button type="button" class="mobile-menu-toggle md:hidden" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle mobile menu">
			<svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
		</button>
	</nav>
	
	<!-- Mobile Menu Dropdown Placeholder -->
	<div class="mobile-menu md:hidden" x-show="mobileMenuOpen" x-transition style="display: none;">
		<div class="px-4 py-2">
			<!-- Mobile Menu Items Placeholder -->
		</div>
	</div>
</header>
