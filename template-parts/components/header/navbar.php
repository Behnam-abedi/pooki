<?php
/**
 * Header Navbar Component (RTL Layout)
 *
 * @package Pooki
 */

$opts = get_option( 'pooki_theme_options', [] );
$sticky_enabled = isset( $opts['sticky_header_enabled'] ) && $opts['sticky_header_enabled'] ? true : false;
$logo_url = isset( $opts['logo_url'] ) ? esc_url( $opts['logo_url'] ) : '';

// Retrieve shadow options from db or fallback
$header_shadow = isset( $opts['header_shadow'] ) ? $opts['header_shadow'] : 'sm';
$sticky_shadow = isset( $opts['sticky_shadow'] ) ? $opts['sticky_shadow'] : 'md';

// Base shadow classes
$shadow_classes = [
	'none' => 'shadow-none',
	'sm'   => 'shadow-sm',
	'md'   => 'shadow-md',
	'lg'   => 'shadow-lg',
];
$base_shadow = isset( $shadow_classes[ $header_shadow ] ) ? $shadow_classes[ $header_shadow ] : 'shadow-sm';
$stick_shadow = isset( $shadow_classes[ $sticky_shadow ] ) ? $shadow_classes[ $sticky_shadow ] : 'shadow-md';

?>
<header 
	class="site-header w-full sticky top-0 z-40 transition-all duration-300 border-b"
	x-data="{ mobileMenuOpen: false, isSticky: false }"
	<?php if ( $sticky_enabled ) : ?>
	@scroll.window="isSticky = (window.pageYOffset > 50)"
	<?php endif; ?>
	:class="{
		'<?php echo esc_attr( $stick_shadow ); ?>': isSticky,
		'<?php echo esc_attr( $base_shadow ); ?>': !isSticky
	}"
	:style="{
		backgroundColor: isSticky ? 'var(--pooki-sticky-bg)' : 'var(--pooki-header-bg)',
		borderColor: isSticky ? 'var(--pooki-sticky-border)' : 'var(--pooki-header-border)'
	}"
>
	<!-- Top Bar -->
	<?php if ( ! isset( $opts['topbar_enabled'] ) || $opts['topbar_enabled'] ) : ?>
		<div 
			class="w-full transition-all duration-300 overflow-hidden flex items-center" 
			:style="{ 
				height: isSticky ? '0' : 'var(--pooki-topbar-h)',
				opacity: isSticky ? '0' : '1',
				backgroundColor: 'var(--pooki-topbar-bg)',
				color: 'var(--pooki-topbar-color)'
			}"
		>
			<div class="container mx-auto px-4 w-full text-center text-sm font-medium leading-none flex items-center justify-center">
				<?php 
				$topbar_content = isset( $opts['topbar_content'] ) ? $opts['topbar_content'] : 'تلفن تماس: ۰۲۱-۱۲۳۴۵۶۷۸ | ارسال رایگان برای خریدهای بالای ۱ میلیون تومان';
				echo wp_kses_post( pooki_to_persian_num( $topbar_content ) ); 
				?>
			</div>
		</div>
	<?php endif; ?>

	<div class="w-full">
		<!-- Main Header Row (Row 1) -->
		<div 
			class="container mx-auto px-4 flex justify-between items-center py-2 transition-all duration-300" 
			aria-label="Main Header" 
			:style="{ minHeight: isSticky ? 'var(--pooki-sticky-h)' : 'var(--pooki-header-h)' }"
		>
			
			<!-- Right: Logo -->
			<div class="flex items-center flex-shrink-0">
				<!-- Logo -->
				<div class="site-branding flex items-center transition-all duration-300" :style="{ height: isSticky ? 'var(--pooki-sticky-logo-h)' : 'var(--pooki-logo-h)' }">
					<?php if ( ! empty( $logo_url ) ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="h-full block">
							<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="h-full w-auto object-contain" fetchpriority="high">
						</a>
					<?php else : ?>
						<?php
						if ( has_custom_logo() ) {
							$custom_logo_id = get_theme_mod( 'custom_logo' );
							$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
							echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="h-full block">';
							echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="h-full w-auto object-contain" fetchpriority="high">';
							echo '</a>';
						} else {
							echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="text-2xl font-black text-pooki-pink hover:text-pooki-pink-dark transition-colors">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
						}
						?>
					<?php endif; ?>
				</div>
			</div>

			<!-- Center: Live Search -->
			<div class="hidden lg:block w-full max-w-2xl mx-6 relative" x-data="pookiSearch()">
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative flex items-center w-full" @submit.prevent>
				<input type="hidden" name="post_type" value="product" />
				<input type="search" name="s" x-model="query" @input.debounce.300ms="fetchResults" placeholder="جستجو در محصولات..." class="w-full pooki-search-input pr-12 pl-4">
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

			<!-- Dynamic Header Actions -->
			<?php
			$action_items = isset( $opts['header_action_items'] ) && is_array( $opts['header_action_items'] ) ? $opts['header_action_items'] : [];
			if ( empty( $action_items ) ) {
				$action_items = [
					[ 'type' => 'account', 'label' => '', 'icon_svg' => '' ],
					[ 'type' => 'cart', 'label' => '', 'icon_svg' => '' ],
				];
			}

			foreach ( $action_items as $action ) {
				$type  = $action['type'];
				$label = ! empty( $action['label'] ) ? esc_html( $action['label'] ) : '';
				$url   = ! empty( $action['url'] ) ? esc_url( $action['url'] ) : '#';
				$svg   = ! empty( $action['icon_svg'] ) ? $action['icon_svg'] : '';

				if ( empty( $svg ) ) {
					// Fallback SVGs
					if ( 'cart' === $type ) {
						$svg = '<svg class="leading-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>';
					} elseif ( 'account' === $type ) {
						$svg = '<svg class="leading-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>';
					} else {
						$svg = '<svg class="leading-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>';
					}
				}

				$base_classes = 'relative pooki-action-btn cursor-pointer transition-colors';
				if ( empty( $label ) ) {
					$base_classes .= ' aspect-square justify-center rounded-full p-2';
				} else {
					$base_classes .= ' inline-flex items-center gap-x-2';
				}
				
				$label_html = '';
				if ( $label ) {
					$label_html = '<span class="leading-none font-sans">' . esc_html( pooki_to_persian_num( $label ) ) . '</span>';
				}

				if ( 'cart' === $type ) {
					?>
					<button type="button" class="<?php echo esc_attr( $base_classes ); ?>" @click="$store.cart.toggle()" aria-label="Cart">
						<?php echo $svg; ?>
						<?php echo $label_html; ?>
						<span id="pooki-cart-count" class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-pooki-pink text-[10px] font-bold text-white shadow-sm leading-none">
							<?php echo esc_html( pooki_to_persian_num( class_exists( 'WooCommerce' ) ? WC()->cart->get_cart_contents_count() : 0 ) ); ?>
						</span>
					</button>
					<?php
				} elseif ( 'account' === $type ) {
					$account_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
					?>
					<a href="<?php echo esc_url( $account_url ); ?>" class="<?php echo esc_attr( $base_classes ); ?>" aria-label="Account">
						<?php echo $svg; ?>
						<?php echo $label_html; ?>
					</a>
					<?php
				} else {
					?>
					<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $base_classes ); ?>" aria-label="Link">
						<?php echo $svg; ?>
						<?php echo $label_html; ?>
					</a>
					<?php
				}
			}
			?>

			<!-- Mobile Menu Toggle -->
			<button type="button" class="lg:hidden flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full text-gray-700 hover:bg-pooki-blue hover:text-white transition-colors" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle mobile menu">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
			</button>
		</div>
		</div>

		<!-- Navigation Row (Row 2) -->
		<div 
			class="hidden lg:block w-full py-2.5 transition-all duration-300"
			:style="{
				backgroundColor: isSticky ? 'var(--pooki-nav-sticky-bg)' : 'var(--pooki-nav-bg)',
				borderTopWidth: 'var(--pooki-nav-border-top-w)',
				borderTopColor: 'var(--pooki-nav-border-top-c)'
			}"
		>
			<div class="container mx-auto px-4 flex justify-center items-center w-full">
				<nav class="desktop-menu flex items-center">
					<style>
						.pooki-dynamic-menu-link {
							color: var(--pooki-menu-color, #374151);
							transition: color 0.2s ease-in-out;
						}
						.pooki-dynamic-menu-link:hover {
							color: var(--pooki-menu-hover-color, #ec4899);
						}
						.desktop-menu ul li a {
							color: var(--pooki-menu-color, #374151);
							transition: color 0.2s ease-in-out;
						}
						.desktop-menu ul li a:hover {
							color: var(--pooki-menu-hover-color, #ec4899);
						}
					</style>
					<?php
					if ( has_nav_menu( 'primary' ) ) {
						wp_nav_menu( [
							'theme_location'  => 'primary',
							'container'       => false,
							'menu_class'      => 'flex gap-x-8 font-medium',
							'fallback_cb'     => false,
						] );
					} else {
						echo '<ul class="flex gap-x-8 font-medium">';
						echo '<li><a href="#" class="pooki-dynamic-menu-link">خانه</a></li>';
						echo '<li><a href="#" class="pooki-dynamic-menu-link">فروشگاه</a></li>';
						echo '<li><a href="#" class="pooki-dynamic-menu-link">تماس با ما</a></li>';
						echo '</ul>';
					}
					?>
				</nav>
			</div>
		</div>
	</div>
	
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
