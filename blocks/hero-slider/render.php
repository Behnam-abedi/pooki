<?php
/**
 * Render callback for the hero slider block.
 *
 * @param array $attributes The block attributes.
 * @param string $content The block content.
 * @param WP_Block $block The block instance.
 *
 * @package Pooki
 */

$slides = isset( $attributes['slides'] ) ? $attributes['slides'] : [];
$desktopHeight = isset( $attributes['desktopHeight'] ) ? $attributes['desktopHeight'] : '600px';
$mobileHeight = isset( $attributes['mobileHeight'] ) ? $attributes['mobileHeight'] : '400px';
$autoplayDelay = isset( $attributes['autoplayDelay'] ) ? $attributes['autoplayDelay'] : 5000;

if ( empty( $slides ) ) {
	return '';
}

$wrapper_attributes = get_block_wrapper_attributes( [
	'class' => 'pooki-hero-slider relative overflow-hidden group w-full',
] );

$unique_id = wp_unique_id( 'pooki-hero-swiper-' );

// Custom styles for height variables
$style = sprintf(
	'--slider-height-desktop: %s; --slider-height-mobile: %s;',
	esc_attr( $desktopHeight ),
	esc_attr( $mobileHeight )
);
?>
<div <?php echo $wrapper_attributes; ?> style="<?php echo esc_attr( $style ); ?>">
	<div class="swiper <?php echo esc_attr( $unique_id ); ?> h-[var(--slider-height-mobile)] md:h-[var(--slider-height-desktop)] w-full">
		<div class="swiper-wrapper">
			<?php foreach ( $slides as $index => $slide ) : ?>
				<?php
				$has_link = ! empty( $slide['linkUrl'] );
				$slide_tag = $has_link ? 'a' : 'div';
				$link_attr = $has_link ? 'href="' . esc_url( $slide['linkUrl'] ) . '"' : '';
				?>
				<<?php echo $slide_tag; ?> <?php echo $link_attr; ?> class="swiper-slide block relative w-full h-full">
					
					<!-- Desktop Image -->
					<?php if ( ! empty( $slide['desktopImageUrl'] ) ) : ?>
						<img src="<?php echo esc_url( $slide['desktopImageUrl'] ); ?>" 
						     alt="<?php echo esc_attr( isset($slide['altText']) ? $slide['altText'] : '' ); ?>"
						     class="absolute inset-0 w-full h-full object-cover hidden md:block"
						     <?php echo $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?> />
					<?php endif; ?>

					<!-- Mobile Image -->
					<?php if ( ! empty( $slide['mobileImageUrl'] ) ) : ?>
						<img src="<?php echo esc_url( $slide['mobileImageUrl'] ); ?>" 
						     alt="<?php echo esc_attr( isset($slide['altText']) ? $slide['altText'] : '' ); ?>"
						     class="absolute inset-0 w-full h-full object-cover md:hidden"
						     <?php echo $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?> />
					<?php elseif ( ! empty( $slide['desktopImageUrl'] ) ) : ?>
						<!-- Fallback to desktop for mobile if no mobile image -->
						<img src="<?php echo esc_url( $slide['desktopImageUrl'] ); ?>" 
						     alt="<?php echo esc_attr( isset($slide['altText']) ? $slide['altText'] : '' ); ?>"
						     class="absolute inset-0 w-full h-full object-cover md:hidden"
						     <?php echo $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?> />
					<?php endif; ?>
					
				</<?php echo $slide_tag; ?>>
			<?php endforeach; ?>
		</div>
		
		<?php if ( count( $slides ) > 1 ) : ?>
			<div class="swiper-button-next !text-white opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-md"></div>
			<div class="swiper-button-prev !text-white opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-md"></div>
			<div class="swiper-pagination !bottom-4"></div>
		<?php endif; ?>
	</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
	if (typeof Swiper !== 'undefined') {
		new Swiper('.<?php echo esc_js( $unique_id ); ?>', {
			modules: [window.SwiperModules.Navigation, window.SwiperModules.Pagination, window.SwiperModules.Autoplay],
			loop: <?php echo count( $slides ) > 1 ? 'true' : 'false'; ?>,
			speed: 600,
			<?php if ( count( $slides ) > 1 ) : ?>
			navigation: {
				nextEl: '.<?php echo esc_js( $unique_id ); ?> .swiper-button-next',
				prevEl: '.<?php echo esc_js( $unique_id ); ?> .swiper-button-prev',
			},
			pagination: {
				el: '.<?php echo esc_js( $unique_id ); ?> .swiper-pagination',
				clickable: true,
			},
			autoplay: {
				delay: <?php echo intval( $autoplayDelay ); ?>,
				disableOnInteraction: false,
			},
			<?php endif; ?>
		});
	}
});
</script>
