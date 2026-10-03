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
$desktopAspectRatio = isset( $attributes['desktopAspectRatio'] ) ? $attributes['desktopAspectRatio'] : '21/9';
$mobileAspectRatio = isset( $attributes['mobileAspectRatio'] ) ? $attributes['mobileAspectRatio'] : '1/1';
$autoplayDelay = isset( $attributes['autoplayDelay'] ) ? $attributes['autoplayDelay'] : 5000;
$arrowColor = isset( $attributes['arrowColor'] ) ? $attributes['arrowColor'] : '#ffffff';
$paginationColor = isset( $attributes['paginationColor'] ) ? $attributes['paginationColor'] : '#ec4899';

if ( empty( $slides ) ) {
	return '';
}

$wrapper_attributes = get_block_wrapper_attributes( [
	'class' => 'pooki-hero-slider relative overflow-hidden group w-full',
] );

$unique_id = wp_unique_id( 'pooki-hero-swiper-' );

// Determine height classes or styles based on aspect ratio input
// We will use inline styles for aspect-ratio since tailwind classes like aspect-[21/9] might not be safelisted
$style = sprintf(
	'--slider-aspect-desktop: %s; --slider-aspect-mobile: %s; --swiper-navigation-color: %s; --swiper-pagination-color: %s;',
	esc_attr( $desktopAspectRatio ),
	esc_attr( $mobileAspectRatio ),
	esc_attr( $arrowColor ),
	esc_attr( $paginationColor )
);
?>
<div <?php echo $wrapper_attributes; ?> style="<?php echo esc_attr( $style ); ?>">
	<style>
		.<?php echo esc_attr( $unique_id ); ?> {
			aspect-ratio: var(--slider-aspect-mobile);
		}
		@media (min-width: 768px) {
			.<?php echo esc_attr( $unique_id ); ?> {
				aspect-ratio: var(--slider-aspect-desktop);
			}
		}
		/* Customize Swiper dots */
		.<?php echo esc_attr( $unique_id ); ?> .swiper-pagination-bullet-active {
			background: var(--swiper-pagination-color) !important;
		}
	</style>

	<div class="swiper <?php echo esc_attr( $unique_id ); ?> w-full h-full">
		<div class="swiper-wrapper">
			<?php foreach ( $slides as $index => $slide ) : ?>
				<?php
				$has_link = ! empty( $slide['linkUrl'] );
				$slide_tag = $has_link ? 'a' : 'div';
				$link_attr = $has_link ? 'href="' . esc_url( $slide['linkUrl'] ) . '"' : '';
				?>
				<<?php echo $slide_tag; ?> <?php echo $link_attr; ?> class="swiper-slide block relative w-full h-full">
					<?php if ( ! empty( $slide['imageUrl'] ) ) : ?>
						<img src="<?php echo esc_url( $slide['imageUrl'] ); ?>" 
						     alt="<?php echo esc_attr( isset($slide['altText']) ? $slide['altText'] : '' ); ?>"
						     class="absolute inset-0 w-full h-full object-cover"
						     <?php echo $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?> />
					<?php endif; ?>
				</<?php echo $slide_tag; ?>>
			<?php endforeach; ?>
		</div>
		
		<?php if ( count( $slides ) > 1 ) : ?>
			<div class="swiper-button-next opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-md"></div>
			<div class="swiper-button-prev opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-md"></div>
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
