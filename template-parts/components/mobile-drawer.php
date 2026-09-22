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
		x-transition:enter="ease-in-out duration-500"
		x-transition:enter-start="opacity-0"
		x-transition:enter-end="opacity-100"
		x-transition:leave="ease-in-out duration-500"
		x-transition:leave-start="opacity-100"
		x-transition:leave-end="opacity-0"
		class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
		@click="$store.nav.toggleMobileMenu()"
		aria-hidden="true"
	></div>

	<div class="fixed inset-0 overflow-hidden pointer-events-none">
		<div class="absolute inset-0 overflow-hidden">
			<div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full">
				<!-- Drawer Panel (Right-aligned for RTL, but the user said left-0, so let's use left-0) -->
				<!-- Wait, the user specifically said "left-0" which implies they want it sliding from left. I will use left-0. -->
			</div>
			<div class="pointer-events-none fixed inset-y-0 left-0 flex max-w-full">
				<!-- Drawer Panel -->
				<div
					x-show="$store.nav.mobileMenuOpen"
					x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
					x-transition:enter-start="-translate-x-full"
					x-transition:enter-end="translate-x-0"
					x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
					x-transition:leave-start="translate-x-0"
					x-transition:leave-end="-translate-x-full"
					class="pointer-events-auto w-80 max-w-[85vw] bg-white shadow-2xl flex flex-col h-full"
					@click.stop
				>
					<!-- Header inside Drawer -->
					<div class="flex items-center justify-between px-4 py-4 border-b border-gray-100 shrink-0">
						<button
							type="button"
							class="relative rounded-md text-gray-400 hover:text-gray-500 focus:outline-none bg-gray-100 hover:bg-pooki-blue hover:text-white transition-colors p-2 aspect-square flex items-center justify-center rounded-full"
							@click="$store.nav.toggleMobileMenu()"
							aria-label="بستن منو"
							aria-expanded="true"
						>
							<span class="absolute -inset-2.5"></span>
							<span class="sr-only">بستن منو</span>
							<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
							</svg>
						</button>
						<h2 class="text-lg font-bold text-gray-900" id="slide-over-title">منو</h2>
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
		</div>
	</div>
</div>
