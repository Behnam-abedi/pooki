<?php
/**
 * Hero Component
 *
 * @package Pooki
 */
?>
<section aria-labelledby="hero-heading" class="relative bg-gray-50 overflow-hidden">
	<div class="container mx-auto px-4 py-16 sm:py-24 lg:py-32">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
			
			<div class="hero-content text-center lg:text-left">
				<h1 id="hero-heading" class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight mb-6">
					Discover our latest collection
				</h1>
				<p class="text-lg sm:text-xl text-gray-600 mb-8 max-w-2xl mx-auto lg:mx-0">
					Experience unparalleled quality and design with our premium products. 
					Elevate your everyday with items crafted to perfection.
				</p>
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
				<!-- TODO: Add dynamic LCP image with fetchpriority="high" -->
				<span class="text-gray-400 font-medium text-lg">Image Placeholder</span>
			</div>
			
		</div>
	</div>
</section>
