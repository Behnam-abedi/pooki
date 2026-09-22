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
	class="fixed inset-0 z-[100] h-screen w-full flex flex-col p-5 overflow-y-auto lg:hidden"
	style="display: none; background-color: var(--pooki-search-modal-bg);"
	x-data="pookiLiveSearch()"
	x-cloak
>
	<div 
		class="relative w-full h-full flex flex-col transition-transform"
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
			<h3 class="text-lg font-bold" style="color: var(--pooki-search-modal-text);">جستجو در محصولات</h3>
			<button type="button" @click="$store.nav.searchOpen = false" class="p-2 rounded-full transition-colors opacity-70 hover:opacity-100" style="color: var(--pooki-search-modal-text);">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
			</button>
		</div>

		<!-- Search Form -->
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative flex items-center w-full" @submit.prevent>
			<input type="hidden" name="post_type" value="product" />
			<input 
				type="search" 
				name="s" 
				x-model.debounce.300ms="query" 
				x-ref="searchInput" 
				placeholder="نام محصول را وارد کنید..." 
				class="w-full rounded-full py-3.5 pr-14 pl-6 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#8C6D53]/30 transition-colors text-base font-medium"
				style="background-color: var(--pooki-search-modal-input-bg); border: 1px solid var(--pooki-search-modal-input-border); color: var(--pooki-search-modal-text);"
			>
			
			<button type="submit" class="absolute right-2 p-2.5 opacity-60 hover:opacity-100 transition-colors" style="color: var(--pooki-search-modal-text);">
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
			x-show="query.length >= 3" 
			class="mt-4 flex-grow overflow-hidden flex flex-col"
			style="display: none;"
			x-transition
		>
			<ul class="flex-grow overflow-y-auto py-2" x-show="results.length > 0 && !isLoading">
				<template x-for="product in results" :key="product.id">
					<li class="mb-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
						<a :href="product.url" class="flex items-center gap-4 px-4 py-3 hover:bg-gray-50 transition-colors relative">
							<div class="w-16 h-16 flex-shrink-0 bg-gray-50 rounded-lg overflow-hidden" x-html="product.thumbnail"></div>
							<div class="flex-grow">
								<h4 class="text-sm font-bold text-gray-900" x-text="product.title"></h4>
								<div class="text-pooki-pink font-medium text-sm mt-1" x-html="product.price_html"></div>
								<span x-show="product.out_of_stock" class="text-xs font-bold text-red-500 mt-1 block">ناموجود</span>
							</div>
						</a>
					</li>
				</template>
				<div class="mt-4 mb-8 text-center">
					<a :href="'/?s=' + query + '&post_type=product'" class="inline-block px-6 py-2 rounded-full bg-[#8C6D53] text-white text-sm font-bold hover:bg-[#735A44] transition-colors">مشاهده همه نتایج</a>
				</div>
			</ul>

			<!-- Empty State -->
			<div x-show="results.length === 0 && !isLoading && query.length >= 3" class="text-center py-10">
				<div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center text-gray-400">
					<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
				</div>
				<p class="text-gray-500 font-medium">محصولی یافت نشد</p>
			</div>
		</div>
	</div>

	<!-- Auto-focus handling -->
	<div x-effect="if($store.nav.searchOpen) { $nextTick(() => $refs.searchInput.focus()) }"></div>
</div>
