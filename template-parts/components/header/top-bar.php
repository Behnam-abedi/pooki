<?php
/**
 * Top Bar Component
 *
 * @package Pooki
 */

$options       = get_option( 'pooki_theme_options' );
$topbar_text   = ! empty( $options['pooki_topbar_text'] ) ? $options['pooki_topbar_text'] : '';
$support_phone = ! empty( $options['pooki_support_phone'] ) ? $options['pooki_support_phone'] : '';

// Do not render anything if both fields are empty.
if ( empty( $topbar_text ) && empty( $support_phone ) ) {
	return;
}
?>
<div class="pooki-topbar bg-indigo-600 text-white text-xs md:text-sm font-medium py-2 px-4">
	<div class="container mx-auto max-w-7xl flex flex-col md:flex-row justify-between items-center text-center md:text-right space-y-2 md:space-y-0">
		<div class="topbar-announcement">
			<?php echo esc_html( $topbar_text ); ?>
		</div>
		<?php if ( ! empty( $support_phone ) ) : ?>
		<div class="topbar-phone flex items-center justify-center md:justify-end">
			<svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
			<span dir="ltr"><?php echo esc_html( $support_phone ); ?></span>
		</div>
		<?php endif; ?>
	</div>
</div>
