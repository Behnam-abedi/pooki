<?php
/**
 * Mobile Sticky Bottom Navigation Bar Component
 *
 * @package Pooki
 */

$opts = get_option( 'pooki_theme_options', [] );

// Retrieve options with defaults set to true (1) for core items if not explicitly false
$has_home   = isset( $opts['mobile_bottom_bar_home'] ) ? $opts['mobile_bottom_bar_home'] : 1;
$label_home = isset( $opts['bottom_bar_label_home'] ) ? $opts['bottom_bar_label_home'] : 'خانه';

$has_shop   = isset( $opts['mobile_bottom_bar_shop'] ) ? $opts['mobile_bottom_bar_shop'] : 1;
$label_shop = isset( $opts['bottom_bar_label_shop'] ) ? $opts['bottom_bar_label_shop'] : 'فروشگاه';

$has_cart   = isset( $opts['mobile_bottom_bar_cart'] ) ? $opts['mobile_bottom_bar_cart'] : 1;
$label_cart = isset( $opts['bottom_bar_label_cart'] ) ? $opts['bottom_bar_label_cart'] : 'سبد خرید';

$has_acc    = isset( $opts['mobile_bottom_bar_account'] ) ? $opts['mobile_bottom_bar_account'] : 1;
$label_acc  = isset( $opts['bottom_bar_label_account'] ) ? $opts['bottom_bar_label_account'] : 'حساب کاربری';

$has_search = isset( $opts['mobile_bottom_bar_search'] ) ? $opts['mobile_bottom_bar_search'] : 0;
$label_search = isset( $opts['bottom_bar_label_search'] ) ? $opts['bottom_bar_label_search'] : 'جستجو';

$has_dividers = isset( $opts['bottom_bar_dividers'] ) ? $opts['bottom_bar_dividers'] : 0;

// Only render if at least one item is active
if ( ! $has_home && ! $has_shop && ! $has_cart && ! $has_acc && ! $has_search ) {
	return;
}

global $wp;
$current_url = trailingslashit( home_url( add_query_arg( array(), $wp->request ) ) );

$active_class = 'flex-1 flex flex-col items-center justify-center min-w-0 gap-y-1 rounded-xl py-1.5 px-1 transition-colors font-bold';
$active_style = 'background-color: var(--pooki-bottom-nav-active-bg, #FDFBF7); color: var(--pooki-bottom-nav-active-text, #8C6D53);';

$inactive_class = 'flex-1 flex flex-col items-center justify-center min-w-0 gap-y-1 rounded-xl py-1.5 px-1 transition-colors opacity-80 hover:opacity-100 hover:bg-stone-50';
$inactive_style = 'color: var(--pooki-bottom-bar-icon-c, #b18339);';

$nav_items = [];

?>

<div 
	x-data
	class="fixed bottom-4 inset-x-4 mx-auto max-w-[390px] z-50 flex items-center justify-between md:hidden px-3 py-2 rounded-2xl backdrop-blur-lg shadow-2xl transition-all"
	style="background-color: var(--pooki-bottom-bar-bg, rgba(255,255,255,0.95)); border: var(--pooki-bottom-nav-border-w, 1px) solid var(--pooki-bottom-nav-border-c, #e5e7eb); padding-bottom: calc(0.5rem + env(safe-area-inset-bottom));"
>
	<nav class="flex items-center justify-between w-full" aria-label="<?php esc_attr_e( 'Mobile Navigation', 'pooki' ); ?>" role="navigation">
		
		<?php if ( $has_home ) : ob_start(); ?>
		<?php $url = trailingslashit( home_url( '/' ) ); ?>
		<a href="<?php echo esc_url( $url ); ?>" class="<?php echo $current_url === $url ? esc_attr( $active_class ) : esc_attr( $inactive_class ); ?>" style="<?php echo $current_url === $url ? esc_attr( $active_style ) : esc_attr( $inactive_style ); ?>" aria-label="<?php echo esc_attr( $label_home ); ?>">
			<svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
			<span class="text-[11px] font-medium leading-tight whitespace-nowrap"><?php echo esc_html( $label_home ); ?></span>
		</a>
		<?php $nav_items[] = ob_get_clean(); endif; ?>

		<?php if ( $has_shop ) : ob_start(); ?>
		<?php $shop_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ); $shop_url = trailingslashit( $shop_url ); ?>
		<a href="<?php echo esc_url( $shop_url ); ?>" class="<?php echo $current_url === $shop_url ? esc_attr( $active_class ) : esc_attr( $inactive_class ); ?>" style="<?php echo $current_url === $shop_url ? esc_attr( $active_style ) : esc_attr( $inactive_style ); ?>" aria-label="<?php echo esc_attr( $label_shop ); ?>">
			<svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
			<span class="text-[11px] font-medium leading-tight whitespace-nowrap"><?php echo esc_html( $label_shop ); ?></span>
		</a>
		<?php $nav_items[] = ob_get_clean(); endif; ?>

		<?php if ( $has_search ) : ob_start(); ?>
		<button type="button" @click="$store.nav.searchOpen = true" class="<?php echo esc_attr( $inactive_class ); ?>" style="<?php echo esc_attr( $inactive_style ); ?>" aria-label="<?php echo esc_attr( $label_search ); ?>">
			<svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
			<span class="text-[11px] font-medium leading-tight whitespace-nowrap"><?php echo esc_html( $label_search ); ?></span>
		</button>
		<?php $nav_items[] = ob_get_clean(); endif; ?>

		<?php if ( $has_cart ) : ob_start(); ?>
		<button type="button" @click.prevent="$store.cart ? $store.cart.toggle() : window.dispatchEvent(new CustomEvent('pooki:open-cart'))" class="<?php echo esc_attr( $inactive_class ); ?>" style="<?php echo esc_attr( $inactive_style ); ?>" aria-label="<?php echo esc_attr( $label_cart ); ?>">
			<div class="relative inline-flex items-center justify-center shrink-0">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
				<span id="pooki-cart-count-bottom" class="absolute -top-1.5 -right-2 transform translate-x-1/4 -translate-y-1/4 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full text-[10px] font-bold leading-none text-white bg-rose-500 shadow-sm overflow-visible z-10">
					<?php echo esc_html( pooki_to_persian_num( class_exists( 'WooCommerce' ) ? WC()->cart->get_cart_contents_count() : 0 ) ); ?>
				</span>
			</div>
			<span class="text-[11px] font-medium leading-tight whitespace-nowrap"><?php echo esc_html( $label_cart ); ?></span>
		</button>
		<?php $nav_items[] = ob_get_clean(); endif; ?>

		<?php if ( $has_acc ) : ob_start(); ?>
		<?php $acc_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url(); $acc_url = trailingslashit( $acc_url ); ?>
		<a href="<?php echo esc_url( $acc_url ); ?>" class="<?php echo $current_url === $acc_url ? esc_attr( $active_class ) : esc_attr( $inactive_class ); ?>" style="<?php echo $current_url === $acc_url ? esc_attr( $active_style ) : esc_attr( $inactive_style ); ?>" aria-label="<?php echo esc_attr( $label_acc ); ?>">
			<svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
			<span class="text-[11px] font-medium leading-tight whitespace-nowrap"><?php echo esc_html( $label_acc ); ?></span>
		</a>
		<?php $nav_items[] = ob_get_clean(); endif; ?>

		<?php
		$divider_html = $has_dividers ? '<div class="h-6 w-px shrink-0 mx-0.5" style="background-color: var(--pooki-bottom-bar-divider)"></div>' : '';
		echo implode( $divider_html, $nav_items );
		?>
	</nav>
</div>

