<?php
/**
 * Top Slide-Down Search Modal Component
 *
 * @package Pooki
 */
?>

<!-- Slide-Down Mobile Search Modal -->
<div 
	x-show="$store.nav.searchOpen" 
	class="fixed inset-x-0 top-0 z-[100] lg:hidden"
	style="display: none;"
	x-data="pookiSearch()"
	x-cloak
>
	<!-- Backdrop Overlay -->
	<div 
		class="fixed inset-0 bg-stone-900/40 backdrop-blur-sm transition-opacity" 
		x-show="$store.nav.searchOpen"
		x-transition:enter="ease-out duration-300"
		x-transition:enter-start="opacity-0"
		x-transition:enter-end="opacity-100"
		x-transition:leave="ease-in duration-200"
		x-transition:leave-start="opacity-100"
		x-transition:leave-end="opacity-0"
		@click="$store.nav.searchOpen = false"
	></div>

	<!-- Modal Content -->
	<div 
		class="relative bg-white/98 dark:bg-stone-900/98 backdrop-blur-md shadow-2xl p-6 rounded-b-3xl transition-transform"
		x-show="$store.nav.searchOpen"
		x-transition:enter="transform transition ease-out duration-300"
		x-transition:enter-start="-translate-y-full"
		x-transition:enter-end="translate-y-0"
		x-transition:leave="transform transition ease-in duration-200"
		x-transition:leave-start="translate-y-0"
		x-transition:leave-end="-translate-y-full"
	>
		<!-- Header -->
		<div class="flex items-center justify-between mb-6">
			<h3 class="text-lg font-bold text-gray-900">جستجو در محصولات</h3>
			<button type="button" @click="$store.nav.searchOpen = false" class="p-2 text-gray-500 hover:text-pooki-pink hover:bg-gray-100 rounded-full transition-colors">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
			</button>
		</div>

		<!-- Search Form -->
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative flex items-center w-full" @submit.prevent>
			<input type="hidden" name="post_type" value="product" />
			<input 
				type="search" 
				name="s" 
				x-model="query" 
				x-ref="searchInput" 
				@input.debounce.300ms="fetchResults" 
				placeholder="نام محصول را وارد کنید..." 
				class="w-full bg-gray-100/50 border-2 border-gray-200 focus:border-pooki-blue focus:bg-white text-gray-900 rounded-full py-4 pr-14 pl-6 outline-none transition-colors text-base font-medium"
			>
			
			<button type="submit" class="absolute right-2 p-2.5 text-gray-400 hover:text-pooki-blue transition-colors">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
			</button>

			<!-- Loading Spinner -->
			<div x-show="isLoading" class="absolute left-4 text-pooki-blue" style="display: none;">
				<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
					<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
					<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
				</svg>
			</div>
		</form>

		<!-- Search Results Dropdown -->
		<div 
			x-show="results.length > 0 && query.length >= 3 && !isLoading" 
			class="mt-4 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden"
			style="display: none;"
			x-transition
		>
			<ul class="max-h-72 overflow-y-auto py-2">
				<template x-for="product in results" :key="product.id">
					<li>
						<a :href="product.url" class="flex items-center gap-4 px-4 py-3 hover:bg-gray-50 transition-colors">
							<div class="w-12 h-12 flex-shrink-0 bg-gray-100 rounded overflow-hidden" x-html="product.thumbnail"></div>
							<div class="flex-grow">
								<h4 class="text-sm font-bold text-gray-900" x-text="product.title"></h4>
								<div class="text-pooki-pink font-medium text-sm mt-1" x-html="product.price_html"></div>
							</div>
						</a>
					</li>
				</template>
			</ul>
			<div class="bg-gray-50 px-4 py-3 border-t border-gray-100 text-center">
				<a :href="'/?s=' + query + '&post_type=product'" class="text-sm font-bold text-pooki-blue hover:text-pooki-pink transition-colors">مشاهده همه نتایج</a>
			</div>
		</div>
	</div>

	<!-- Auto-focus handling -->
	<div x-effect="if($store.nav.searchOpen) { $nextTick(() => $refs.searchInput.focus()) }"></div>
</div>
