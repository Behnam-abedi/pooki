<?php
/**
 * Mobile Drawer Component
 *
 * @package Pooki
 */
?>
<!-- Mobile Menu Drawer Overlay -->
<div
	x-data
	x-show="$store.nav.mobileMenuOpen"
	class="relative z-[100] lg:hidden"
	aria-labelledby="slide-over-title"
	role="dialog"
	aria-modal="true"
	style="display: none;"
>
	<!-- Background Backdrop -->
	<div
		x-show="$store.nav.mobileMenuOpen"
		x-transition:enter="transition-opacity ease-out duration-300"
		x-transition:enter-start="opacity-0"
		x-transition:enter-end="opacity-100"
		x-transition:leave="transition-opacity ease-in duration-200"
		x-transition:leave-start="opacity-100"
		x-transition:leave-end="opacity-0"
		@click="$store.nav.mobileMenuOpen = false"
		class="fixed inset-0 z-[100] bg-black/50 backdrop-blur-md"
		aria-hidden="true"
	></div>

	<!-- Drawer Panel -->
	<div
		x-show="$store.nav.mobileMenuOpen"
		x-transition:enter="transform transition-transform duration-300 ease-out"
		x-transition:enter-start="translate-x-full"
		x-transition:enter-end="translate-x-0"
		x-transition:leave="transform transition-transform duration-300 ease-out"
		x-transition:leave-start="translate-x-0"
		x-transition:leave-end="translate-x-full"
		@keydown.escape.window="$store.nav.mobileMenuOpen = false"
		class="fixed inset-y-0 right-0 z-[110] w-[85vw] sm:w-96 flex flex-col shadow-2xl"
		style="background-color: var(--pooki-drawer-bg, #FAF7F2); color: var(--pooki-drawer-text, #292524);"
	>
					<!-- Header inside Drawer -->
					<div class="flex items-center justify-between px-5 py-4 border-b border-stone-200/60 shrink-0">
						<h2 class="text-lg font-bold" id="slide-over-title">منو</h2>
						<button
							type="button"
							class="p-2 rounded-full transition-colors opacity-70 hover:opacity-100 bg-stone-100/50"
							@click="$store.nav.mobileMenuOpen = false"
							aria-label="بستن منو"
							aria-expanded="true"
							style="color: var(--pooki-drawer-text);"
						>
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
						</button>
					</div>

					<!-- Navigation Links -->
					<nav aria-label="Mobile Navigation" class="flex-1 overflow-y-auto p-4">
						<?php
						if ( has_nav_menu( 'mobile' ) ) {
							wp_nav_menu( [
								'theme_location'  => 'mobile',
								'container'       => false,
								'menu_class'      => 'flex flex-col space-y-4 text-gray-700 font-medium',
								'fallback_cb'     => false,
							] );
						} elseif ( has_nav_menu( 'primary' ) ) {
							wp_nav_menu( [
								'theme_location'  => 'primary',
								'container'       => false,
								'menu_class'      => 'flex flex-col space-y-4 text-gray-700 font-medium',
								'fallback_cb'     => false,
							] );
						} else {
							echo '<ul class="flex flex-col space-y-4 text-gray-700 font-medium">';
							echo '<li><a href="#" class="block hover:text-pooki-blue transition-colors">خانه</a></li>';
							echo '<li><a href="#" class="block hover:text-pooki-blue transition-colors">فروشگاه</a></li>';
							echo '<li><a href="#" class="block hover:text-pooki-blue transition-colors">تماس با ما</a></li>';
							echo '</ul>';
						}
						?>
					</nav>
	</div>
</div>
