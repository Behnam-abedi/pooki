<?php
/**
 * Hero Component
 *
 * @package Pooki
 */

$hero_title    = get_theme_mod( 'pooki_hero_title', 'Premium Products' );
$hero_subtitle = get_theme_mod( 'pooki_hero_subtitle', 'Discover our latest collection' );
$hero_image    = get_theme_mod( 'pooki_hero_image' );
?>
<section aria-labelledby="hero-heading" class="relative bg-gray-50 overflow-hidden">
	<div class="container mx-auto px-4 py-16 sm:py-24 lg:py-32">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
			
			<div class="hero-content text-center lg:text-left">
				<?php if ( $hero_title ) : ?>
					<h1 id="hero-heading" class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight mb-6">
						<?php echo esc_html( $hero_title ); ?>
					</h1>
				<?php endif; ?>

				<?php if ( $hero_subtitle ) : ?>
					<p class="text-lg sm:text-xl text-gray-600 mb-8 max-w-2xl mx-auto lg:mx-0">
						<?php echo esc_html( $hero_subtitle ); ?>
					</p>
				<?php endif; ?>

				<div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
					<a href="#" class="inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out">
						Shop Now
					</a>
					<a href="#" class="inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition duration-150 ease-in-out">
						Learn More
					</a>
				</div>
			</div>

			<div class="hero-image relative rounded-xl overflow-hidden shadow-2xl bg-gray-200 aspect-w-16 aspect-h-9 lg:aspect-none lg:h-full min-h-[300px] flex items-center justify-center">
				<?php if ( $hero_image ) : ?>
					<?php
					$attachment_id = attachment_url_to_postid( $hero_image );
					if ( $attachment_id ) {
						echo wp_get_attachment_image( $attachment_id, 'full', false, [
							'class'         => 'object-cover w-full h-full',
							'fetchpriority' => 'high',
							'loading'       => 'eager',
						] );
					} else {
						?>
						<img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( $hero_title ); ?>" class="object-cover w-full h-full" fetchpriority="high" loading="eager" />
						<?php
					}
					?>
				<?php else : ?>
					<span class="text-gray-400 font-medium text-lg">Image Placeholder</span>
				<?php endif; ?>
			</div>
			
		</div>
	</div>
</section>
