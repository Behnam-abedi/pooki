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

// Mobile Header Options
$mobile_search = isset( $opts['mobile_nav_header_search'] ) ? $opts['mobile_nav_header_search'] : 1;
$mobile_phone  = isset( $opts['mobile_nav_header_phone'] ) ? $opts['mobile_nav_header_phone'] : 0;
$mobile_phone_num = isset( $opts['mobile_nav_header_phone_number'] ) ? $opts['mobile_nav_header_phone_number'] : '02112345678';
$mobile_burger = isset( $opts['mobile_nav_header_hamburger'] ) ? $opts['mobile_nav_header_hamburger'] : 1;
$topbar_hide_mobile = isset( $opts['topbar_hide_mobile'] ) ? $opts['topbar_hide_mobile'] : 1;

?>
<!-- Top Bar (Scrolls away naturally) -->
<?php if ( ! isset( $opts['topbar_enabled'] ) || $opts['topbar_enabled'] ) : ?>
	<div 
		class="w-full transition-colors duration-500 flex items-center relative z-40 <?php echo $topbar_hide_mobile ? 'hidden md:flex' : ''; ?>" 
		style="
			min-height: var(--pooki-topbar-h);
			background-color: var(--pooki-topbar-bg);
			color: var(--pooki-topbar-color);
		"
	>
		<div class="container mx-auto px-4 w-full text-center text-sm font-medium leading-none flex items-center justify-center">
			<?php 
			$topbar_content = isset( $opts['topbar_content'] ) ? $opts['topbar_content'] : 'تلفن تماس: ۰۲۱-۱۲۳۴۵۶۷۸ | ارسال رایگان برای خریدهای بالای ۱ میلیون تومان';
			echo wp_kses_post( pooki_to_persian_num( $topbar_content ) ); 
			?>
		</div>
	</div>
<?php endif; ?>

<style>.site-header { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }.logo-anim { transition: opacity 0.2s ease, width 0.3s ease 0.2s, margin 0.3s ease 0.2s; overflow: hidden; }.is-sticky .logo-anim { opacity: 0; width: 0px !important; margin: 0 !important; }.not-sticky .logo-anim { opacity: 1; width: 120px; }.center-search-anim { transition: width 0.3s ease 0.2s, opacity 0.2s ease 0.4s; overflow: visible; }.is-sticky .center-search-anim { opacity: 1; width: 100% !important; }.not-sticky .center-search-anim { opacity: 0; width: 0px !important; pointer-events: none; overflow: hidden !important; }.bottom-search-anim { transition: height 0.3s ease 0.2s, opacity 0.2s ease, margin 0.3s ease 0.2s; overflow: visible; }.is-sticky .bottom-search-anim { height: 0px !important; opacity: 0; margin-bottom: 0px !important; overflow: hidden !important; pointer-events: none; }.not-sticky .bottom-search-anim { height: 44px; opacity: 1; margin-bottom: 12px; }</style>
<style>
.mobile-header-anim { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
</style>
<header class="site-header w-full sticky top-0 z-50 border-b transition-colors duration-500"
	x-data="{ mobileMenuOpen: false, isSticky: false }"
	<?php if ( $sticky_enabled ) : ?>
	@scroll.window="if (window.pageYOffset > 100) { isSticky = true; } else if (window.pageYOffset < 20) { isSticky = false; }"
	<?php endif; ?>
	:class="[
		isSticky ? '<?php echo esc_attr( $stick_shadow ); ?>' : '<?php echo esc_attr( $base_shadow ); ?>'
	]"
	:style="{
		backgroundColor: isSticky ? 'var(--pooki-sticky-bg)' : 'var(--pooki-header-bg)',
		borderColor: isSticky ? 'var(--pooki-sticky-border)' : 'var(--pooki-header-border)'
	}"
>
	<!-- DESKTOP HEADER (Hidden on Mobile) -->
	<div class="hidden lg:block w-full">
		<div class="container mx-auto px-4 flex flex-row-reverse justify-between items-center py-2 transition-all duration-500" 
			:style="{ minHeight: isSticky ? 'var(--pooki-sticky-h)' : 'var(--pooki-header-h)' }">
			
			<!-- Logo -->
			<div class="items-center justify-start flex-shrink-0 transition-all duration-500 overflow-hidden" 
				:style="{ width: isSticky ? '0px' : 'var(--pooki-logo-w, auto)', opacity: isSticky ? '0' : '1', margin: isSticky ? '0' : '' }">
				<div class="site-branding flex items-center" :style="{ height: isSticky ? 'var(--pooki-sticky-logo-h)' : 'var(--pooki-logo-h)' }">
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

			<!-- Center Search -->
			<div class="max-w-2xl transition-all duration-500 ease-in-out relative flex-1 mx-6" 
				:style="isSticky ? { opacity: 1, width: '100%' } : { opacity: 0, width: '0px', pointerEvents: 'none' }"
				x-data="pookiLiveSearch()">
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative flex items-center w-full" @submit.prevent="goToSearch">
					<input type="hidden" name="post_type" value="product" />
					<input type="search" name="s" x-model="query" @input.debounce.300ms="fetchResults" placeholder="جستجو..." class="w-full pooki-search-input pr-12 pl-4">
					<button type="button" @click="goToSearch" class="absolute right-4 text-gray-500 hover:text-pooki-blue">
						<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
					</button>
					<div x-show="isLoading" class="absolute left-4 text-pooki-blue" style="display: none;">
						<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
							<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
							<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
						</svg>
					</div>
				</form>
				<div x-show="results.length > 0 && query.length >= 3 && !isLoading" @click.outside="results = []" class="absolute top-full right-0 mt-2 w-full bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50" style="display: none;" x-transition>
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
						<a :href="'/?s=' + query + '&post_type=product'" class="text-sm font-bold text-pooki-blue hover:text-pooki-pink transition-colors">نمایش همه نتایج</a>
					</div>
				</div>
				<div x-show="results.length === 0 && query.length >= 3 && !isLoading" class="absolute top-full right-0 mt-2 w-full bg-white rounded-xl shadow-lg border border-gray-100 p-4 text-center text-gray-500 z-50" style="display: none;">
					موردی یافت نشد.
				</div>
			</div>

			<!-- Desktop Actions -->
			<div class="flex items-center justify-end gap-x-4 flex-shrink-0">
				<?php
				foreach ( $action_items as $action ) {
					$type  = $action['type'];
					$label = ! empty( $action['label'] ) ? esc_html( $action['label'] ) : '';
					$url   = ! empty( $action['url'] ) ? esc_url( $action['url'] ) : '#';
					$svg   = ! empty( $action['icon_svg'] ) ? $action['icon_svg'] : '';
					if ( empty( $svg ) ) {
						if ( 'cart' === $type ) $svg = '<svg class="leading-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>';
						elseif ( 'account' === $type ) $svg = '<svg class="leading-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>';
						else $svg = '<svg class="leading-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>';
					}
					$base_classes = 'relative pooki-action-btn cursor-pointer transition-colors inline-flex items-center gap-x-2 aspect-square justify-center rounded-full p-2';
					$label_html = $label ? '<span class="leading-none font-sans">' . esc_html( pooki_to_persian_num( $label ) ) . '</span>' : '';
					if ( 'cart' === $type ) {
						echo '<button type="button" class="'.esc_attr($base_classes).'" @click="$store.cart.toggle()" aria-label="Cart">' . $svg . $label_html . '<span id="pooki-cart-count" class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-pooki-pink text-[10px] font-bold text-white shadow-sm leading-none">' . esc_html( pooki_to_persian_num( class_exists( 'WooCommerce' ) ? WC()->cart->get_cart_contents_count() : 0 ) ) . '</span></button>';
					} elseif ( 'account' === $type ) {
						$account_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
						echo '<a href="'.esc_url($account_url).'" class="'.esc_attr($base_classes).'" aria-label="Account">' . $svg . $label_html . '</a>';
					} else {
						echo '<a href="'.esc_url($url).'" class="'.esc_attr($base_classes).'" aria-label="Link">' . $svg . $label_html . '</a>';
					}
				}
				?>
			</div>
		</div>

		<!-- Navigation Row (Row 2 Desktop) -->
		<div class="w-full py-2.5 transition-all duration-500" :style="{ backgroundColor: isSticky ? 'var(--pooki-nav-sticky-bg)' : 'var(--pooki-nav-bg)', borderTopWidth: 'var(--pooki-nav-border-top-w)', borderTopColor: 'var(--pooki-nav-border-top-c)' }">
			<div class="container mx-auto px-4 flex justify-center items-center w-full">
				<nav class="desktop-menu flex items-center">
					<?php
					if ( has_nav_menu( 'primary' ) ) {
						wp_nav_menu( [ 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'flex gap-x-8 font-medium', 'fallback_cb' => false ] );
					}
					?>
				</nav>
			</div>
		</div>
	</div>

	<!-- MOBILE HEADER (Hidden on Desktop, Custom Absolute Positioning Animation) -->
	<div class="block lg:hidden w-full relative mobile-header-anim"
		:style="isSticky ? 'height: var(--pooki-mobile-header-sticky-h, 60px);' : 'height: calc(var(--pooki-mobile-header-h, 70px) + var(--pooki-search-h, 44px) + 12px);'">
		
		<!-- Mobile Logo (LEFT) -->
		<div class="absolute mobile-header-anim origin-left flex items-center"
			:style="isSticky ? 'top: 10px; left: 16px; opacity: 0; transform: scale(0.8); pointer-events: none;' : 'top: 15px; left: 16px; opacity: 1; transform: scale(1);'">
			<?php if ( ! empty( $logo_url ) ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="block" style="height: var(--pooki-mobile-logo-h, 40px)">
					<img src="<?php echo esc_url( $logo_url ); ?>" alt="Logo" class="h-full w-auto object-contain" fetchpriority="high">
				</a>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-2xl font-black text-pooki-pink"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
			<?php endif; ?>
		</div>

		<!-- Mobile Actions: Burger Only (RIGHT) -->
		<div class="absolute mobile-header-anim flex items-center gap-2"
			:style="isSticky ? 'top: 10px; right: 16px; z-index: 10;' : 'top: 15px; right: 16px; z-index: 10;'">
			<?php if ( $mobile_burger ) : ?>
			<button type="button" class="relative pooki-action-btn cursor-pointer transition-colors aspect-square justify-center rounded-full p-2" @click="$store.nav.toggleMobileMenu()">
				<svg class="w-5 h-5 leading-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
			</button>
			<?php endif; ?>
		</div>

		<!-- Mobile Search (The physically moving box) -->
		<div class="absolute w-full mobile-header-anim"
			:style="isSticky 
				? 'top: 8px; right: 0px; left: 0px; padding-right: 70px; padding-left: 16px;' 
				: 'top: calc(var(--pooki-mobile-header-h, 70px) - 2px); right: 0px; left: 0px; padding-right: 16px; padding-left: 16px;'"
			x-data="pookiLiveSearch()">
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative flex items-center w-full" @submit.prevent="goToSearch">
				<input type="hidden" name="post_type" value="product" />
				<input type="search" name="s" x-model="query" x-ref="searchInput" @input.debounce.300ms="fetchResults" placeholder="جستجو..." class="w-full pooki-search-input pr-12 pl-12 text-[16px]" style="font-size: 16px !important;">
<button type="button" @click="goToSearch" class="absolute right-4 text-gray-500 hover:text-pooki-blue">
	<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
</button>
<button type="button" @click="query = ''; results = []; $refs.searchInput.focus()" x-show="query.length > 0 && !isLoading" class="absolute left-4 text-gray-400 hover:text-pooki-pink" style="display: none;">
	<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
</button>
<div x-show="isLoading" class="absolute left-4 text-pooki-blue" style="display: none;">
	<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
		<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
		<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
	</svg>
</div>

			</form>
			<div x-show="results.length > 0 && query.length >= 3 && !isLoading" @click.outside="results = []" class="absolute top-full right-0 mt-2 w-full bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50 max-h-80 overflow-y-auto" style="display: none;" x-transition>
				<ul class="py-2">
					<template x-for="product in results" :key="product.id">
						<li>
							<a :href="product.url" class="flex items-center gap-4 px-4 py-2 hover:bg-gray-50">
								<div class="w-10 h-10 flex-shrink-0 bg-gray-100 rounded" x-html="product.thumbnail"></div>
								<div class="flex-grow"><h4 class="text-xs font-bold text-gray-900" x-text="product.title"></h4><div class="text-pooki-pink font-medium text-xs mt-1" x-html="product.price_html"></div></div>
							</a>
						</li>
					</template>
				</ul>
				<div class="bg-gray-50 px-4 py-2 border-t border-gray-100 text-center">
					<a :href="'/?s=' + query + '&post_type=product'" class="text-xs font-bold text-pooki-blue">نمایش همه نتایج</a>
				</div>
			</div>
			<div x-show="results.length === 0 && query.length >= 3 && !isLoading" class="absolute top-full right-0 mt-2 w-full bg-white rounded-xl shadow-lg border border-gray-100 p-4 text-center text-xs text-gray-500 z-50" style="display: none;">موردی یافت نشد.</div>
		</div>
	</div>

</header>

	<!-- Off-Canvas Mobile Drawer -->
	<?php get_template_part( 'template-parts/components/mobile-drawer' ); ?>

</header>
