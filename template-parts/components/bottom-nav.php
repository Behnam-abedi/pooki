<?php
/**
 * Mobile Sticky Bottom Navigation Bar Component
 *
 * @package Pooki
 */

$opts = get_option( 'pooki_theme_options', [] );

// Retrieve options with defaults set to true (1) for core items if not explicitly false
$has_home   = isset( $opts['mobile_bottom_bar_home'] ) ? $opts['mobile_bottom_bar_home'] : 1;
$has_shop   = isset( $opts['mobile_bottom_bar_shop'] ) ? $opts['mobile_bottom_bar_shop'] : 1;
$has_cart   = isset( $opts['mobile_bottom_bar_cart'] ) ? $opts['mobile_bottom_bar_cart'] : 1;
$has_acc    = isset( $opts['mobile_bottom_bar_account'] ) ? $opts['mobile_bottom_bar_account'] : 1;
$has_search = isset( $opts['mobile_bottom_bar_search'] ) ? $opts['mobile_bottom_bar_search'] : 0;

// Only render if at least one item is active
if ( ! $has_home && ! $has_shop && ! $has_cart && ! $has_acc && ! $has_search ) {
	return;
}
?>

<div class="fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur border-t border-stone-200 px-4 py-2 shadow-lg md:hidden pb-[env(safe-area-inset-bottom)]">
	<nav class="flex items-center justify-around w-full text-gray-500">
		
		<?php if ( $has_home ) : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex flex-col items-center justify-center gap-y-1 hover:text-pooki-blue transition-colors">
			<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
			<span class="text-[10px] font-medium leading-none">خانه</span>
		</a>
		<?php endif; ?>

		<?php if ( $has_shop ) : ?>
		<?php $shop_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ); ?>
		<a href="<?php echo esc_url( $shop_url ); ?>" class="flex flex-col items-center justify-center gap-y-1 hover:text-pooki-blue transition-colors">
			<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
			<span class="text-[10px] font-medium leading-none">فروشگاه</span>
		</a>
		<?php endif; ?>

		<?php if ( $has_search ) : ?>
		<button type="button" @click="$store.nav.searchOpen = true" class="flex flex-col items-center justify-center gap-y-1 hover:text-pooki-blue transition-colors">
			<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
			<span class="text-[10px] font-medium leading-none">جستجو</span>
		</button>
		<?php endif; ?>

		<?php if ( $has_cart ) : ?>
		<?php $cart_url = class_exists( 'WooCommerce' ) ? wc_get_cart_url() : '#'; ?>
		<button type="button" @click="$store.cart.toggle()" class="relative flex flex-col items-center justify-center gap-y-1 hover:text-pooki-blue transition-colors">
			<div class="relative">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
				<span id="pooki-cart-count-bottom" class="absolute -top-1 -right-2 flex h-4 w-4 items-center justify-center rounded-full bg-pooki-pink text-[10px] font-bold text-white shadow-sm leading-none">
					<?php echo esc_html( pooki_to_persian_num( class_exists( 'WooCommerce' ) ? WC()->cart->get_cart_contents_count() : 0 ) ); ?>
				</span>
			</div>
			<span class="text-[10px] font-medium leading-none">سبد خرید</span>
		</button>
		<?php endif; ?>

		<?php if ( $has_acc ) : ?>
		<?php $acc_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url(); ?>
		<a href="<?php echo esc_url( $acc_url ); ?>" class="flex flex-col items-center justify-center gap-y-1 hover:text-pooki-blue transition-colors">
			<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
			<span class="text-[10px] font-medium leading-none">حساب کاربری</span>
		</a>
		<?php endif; ?>

	</nav>
</div>
