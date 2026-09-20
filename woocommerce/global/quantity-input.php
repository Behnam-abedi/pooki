<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// WooCommerce logic for min/max/step
$min_value = apply_filters( 'woocommerce_quantity_input_min', $min_value, $product );
$max_value = apply_filters( 'woocommerce_quantity_input_max', $max_value, $product );
$step      = apply_filters( 'woocommerce_quantity_input_step', $step, $product );
?>
<div class="pooki-quantity flex items-center border border-gray-300 rounded-md bg-white overflow-hidden w-32 h-10" 
     x-data="{ 
         qty: <?php echo esc_js( $input_value ? $input_value : 1 ); ?>, 
         min: <?php echo esc_js( $min_value ); ?>, 
         max: <?php echo esc_js( 0 < $max_value ? $max_value : 999 ); ?> 
     }">
    <button type="button" 
            class="w-10 h-full flex justify-center items-center text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors" 
            @click="qty = qty > min ? qty - 1 : min; $refs.qtyInput.value = qty; $refs.qtyInput.dispatchEvent(new Event('change', { bubbles: true }))">
        &minus;
    </button>
    <input type="number" 
           x-ref="qtyInput" 
           id="<?php echo esc_attr( $input_id ); ?>" 
           class="qty w-12 h-full text-center border-none focus:ring-0 text-gray-900 font-medium p-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" 
           step="<?php echo esc_attr( $step ); ?>" 
           min="<?php echo esc_attr( $min_value ); ?>" 
           max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>" 
           name="<?php echo esc_attr( $input_name ); ?>" 
           value="<?php echo esc_attr( $input_value ); ?>" 
           title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>" 
           size="4" 
           inputmode="<?php echo esc_attr( $inputmode ); ?>" 
           x-model="qty" 
           @change="qty = parseInt($event.target.value) || min" />
    <button type="button" 
            class="w-10 h-full flex justify-center items-center text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors" 
            @click="qty = qty < max ? qty + 1 : max; $refs.qtyInput.value = qty; $refs.qtyInput.dispatchEvent(new Event('change', { bubbles: true }))">
        &plus;
    </button>
</div>
