<?php
/**
 * Mobile Bottom Navigation Component
 *
 * @package Pooki
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cart_count = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;

$is_home_active    = is_front_page() || is_home();
$is_shop_active    = ( function_exists( 'is_shop' ) && is_shop() ) || 
                     ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) || 
                     ( function_exists( 'is_product' ) && is_product() );
$is_account_active = function_exists( 'is_account_page' ) && is_account_page();

$active_classes   = 'text-amber-700 font-bold';
$inactive_classes = 'text-neutral-600 hover:text-amber-600';
?>
<nav x-data class="fixed bottom-4 left-4 right-4 z-50 mx-auto max-w-md bg-white/95 backdrop-blur-md border border-neutral-200/80 shadow-xl rounded-2xl p-2 select-none md:hidden" aria-label="<?php esc_attr_e( 'Mobile Navigation', 'pooki' ); ?>">
    <div class="flex items-center justify-around w-full">
        
        <!-- Home Item -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex-1 min-w-0 flex flex-col items-center justify-center py-1.5 px-1 <?php echo $is_home_active ? esc_attr( $active_classes ) : esc_attr( $inactive_classes ); ?> transition-colors">
            <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" stroke-width="<?php echo $is_home_active ? '2.5' : '2'; ?>" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-[11px] leading-none whitespace-nowrap"><?php esc_html_e( 'خانه', 'pooki' ); ?></span>
        </a>

        <div class="w-px h-6 bg-neutral-200 shrink-0"></div>

        <!-- Shop Item -->
        <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop' ) ); ?>" class="flex-1 min-w-0 flex flex-col items-center justify-center py-1.5 px-1 <?php echo $is_shop_active ? esc_attr( $active_classes ) : esc_attr( $inactive_classes ); ?> transition-colors">
            <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" stroke-width="<?php echo $is_shop_active ? '2.5' : '2'; ?>" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span class="text-[11px] leading-none whitespace-nowrap"><?php esc_html_e( 'فروشگاه', 'pooki' ); ?></span>
        </a>

        <div class="w-px h-6 bg-neutral-200 shrink-0"></div>

        <!-- Cart Trigger Item (Drawer) -->
        <button type="button" 
                @click="$store.cart.toggle()" 
                class="flex-1 min-w-0 flex flex-col items-center justify-center py-1.5 px-1 text-neutral-600 hover:text-amber-600 transition-colors focus:outline-none cursor-pointer"
                aria-label="<?php esc_attr_e( 'سبد خرید', 'pooki' ); ?>"
                aria-haspopup="dialog">
            <div class="relative inline-flex items-center justify-center mb-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="absolute -top-1.5 -right-2.5 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-[#f43f5e] rounded-full leading-none ring-2 ring-white">
                    <?php echo esc_html( $cart_count ); ?>
                </span>
            </div>
            <span class="text-[11px] font-medium leading-none whitespace-nowrap"><?php esc_html_e( 'سبد خرید', 'pooki' ); ?></span>
        </button>

        <div class="w-px h-6 bg-neutral-200 shrink-0"></div>

        <!-- Account Item -->
        <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account' ) ); ?>" class="flex-1 min-w-0 flex flex-col items-center justify-center py-1.5 px-1 <?php echo $is_account_active ? esc_attr( $active_classes ) : esc_attr( $inactive_classes ); ?> transition-colors">
            <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" stroke-width="<?php echo $is_account_active ? '2.5' : '2'; ?>" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="text-[11px] leading-none whitespace-nowrap"><?php esc_html_e( 'حساب من', 'pooki' ); ?></span>
        </a>

    </div>
</nav>
