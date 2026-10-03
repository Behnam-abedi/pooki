<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package Pooki
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 text-center"><?php the_title(); ?></h1>
	<div class="pooki-page-content text-gray-700 leading-relaxed space-y-6">
		<?php the_content(); ?>
	</div>
</article>
