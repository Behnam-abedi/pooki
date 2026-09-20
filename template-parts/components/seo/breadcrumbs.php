<?php
/**
 * Breadcrumbs Component
 *
 * @package Pooki
 */
?>
<nav aria-label="Breadcrumbs" class="pooki-breadcrumbs text-sm text-gray-500 mb-6 font-medium">
	<?php
	if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		rank_math_the_breadcrumbs();
	}
	?>
</nav>
