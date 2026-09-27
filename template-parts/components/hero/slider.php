<?php
/**
 * Main Slider Component
 *
 * @package Pooki
 */

$opts = get_option( 'pooki_theme_options', [] );
$slider_enabled = isset( $opts['slider_enabled'] ) ? $opts['slider_enabled'] : 1;

if ( ! $slider_enabled ) {
	return;
}

$items = isset( $opts['slider_items'] ) && is_array( $opts['slider_items'] ) ? $opts['slider_items'] : [];

$valid_items = [];
foreach ( $items as $item ) {
	if ( ! empty( $item['desktop_img'] ) || ! empty( $item['mobile_img'] ) ) {
		$valid_items[] = $item;
	}
}

$slide_count = count( $valid_items );

if ( $slide_count === 0 ) {
	return;
}

$width = isset( $opts['slider_width'] ) ? $opts['slider_width'] : 'container';
$height_desktop = isset( $opts['slider_height_desktop'] ) ? $opts['slider_height_desktop'] : '500px';
$height_mobile = isset( $opts['slider_height_mobile'] ) ? $opts['slider_height_mobile'] : '300px';
$border_radius = isset( $opts['slider_border_radius'] ) ? $opts['slider_border_radius'] : 12;

$autoplay = isset( $opts['slider_autoplay'] ) ? $opts['slider_autoplay'] : 1;
$autoplay_delay = isset( $opts['slider_autoplay_delay'] ) ? $opts['slider_autoplay_delay'] : 4000;

// Set up inline CSS variables for the slider
$slider_style = "--pooki-slider-h-desktop: {$height_desktop}; --pooki-slider-h-mobile: {$height_mobile}; --pooki-slider-radius: {$border_radius}px;";

$wrapper_classes = 'w-full mb-8 relative';
if ( 'container' === $width ) {
	$wrapper_classes .= ' container mx-auto px-4 mt-6';
}
?>

<div class="<?php echo esc_attr( $wrapper_classes ); ?>" style="<?php echo esc_attr( $slider_style ); ?>">
	<!-- Swiper Container -->
	<div class="swiper pooki-main-slider" style="border-radius: var(--pooki-slider-radius); overflow: hidden;">
		<div class="swiper-wrapper">
			<?php foreach ( $valid_items as $item ) : ?>
				<?php 
				$desktop_img = ! empty( $item['desktop_img'] ) ? $item['desktop_img'] : $item['mobile_img'];
				$mobile_img = ! empty( $item['mobile_img'] ) ? $item['mobile_img'] : $item['desktop_img'];
				$url = ! empty( $item['url'] ) ? $item['url'] : '';
				$alt = ! empty( $item['alt'] ) ? $item['alt'] : '';
				?>
				<div class="swiper-slide relative bg-gray-100 flex items-center justify-center">
					<?php if ( $url ) : ?>
						<a href="<?php echo esc_url( $url ); ?>" class="block w-full h-full relative" aria-label="<?php echo esc_attr( $alt ); ?>">
					<?php else: ?>
						<div class="w-full h-full relative">
					<?php endif; ?>
					
					<!-- Desktop Image -->
					<img src="<?php echo esc_url( $desktop_img ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="hidden md:block w-full h-full object-cover pooki-slide-img" fetchpriority="high">
					<!-- Mobile Image -->
					<img src="<?php echo esc_url( $mobile_img ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="block md:hidden w-full h-full object-cover pooki-slide-img" fetchpriority="high">
					
					<?php if ( $url ) : ?>
						</a>
					<?php else: ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		
		<!-- Navigation Arrows -->
		<?php if ( $slide_count > 1 ) : ?>
			<div class="swiper-button-next" style="color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.5);"></div>
			<div class="swiper-button-prev" style="color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.5);"></div>
			<!-- Pagination -->
			<div class="swiper-pagination"></div>
		<?php endif; ?>
	</div>
</div>

<style>
.pooki-main-slider {
	height: var(--pooki-slider-h-mobile);
}
@media (min-width: 768px) {
	.pooki-main-slider {
		height: var(--pooki-slider-h-desktop);
	}
}
.pooki-slide-img {
	height: 100%;
	width: 100%;
	object-fit: cover;
}
.swiper-pagination-bullet-active {
	background: var(--pooki-pink, #ec4899) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
	if (typeof Swiper !== 'undefined') {
		const swiperOpts = {
			modules: [window.SwiperModules.Navigation, window.SwiperModules.Pagination, window.SwiperModules.Autoplay],
			loop: <?php echo $slide_count > 1 ? 'true' : 'false'; ?>,
			speed: 600,
			<?php if ( $slide_count > 1 ) : ?>
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			<?php endif; ?>
		};
		
		<?php if ( $autoplay && $slide_count > 1 ) : ?>
		swiperOpts.autoplay = {
			delay: <?php echo intval( $autoplay_delay ); ?>,
			disableOnInteraction: false,
		};
		<?php endif; ?>
		
		new Swiper('.pooki-main-slider', swiperOpts);
	}
});
</script>
