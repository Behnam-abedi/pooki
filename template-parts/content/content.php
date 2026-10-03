<?php
/**
 * Template part for displaying posts
 *
 * @package Pooki
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6'); ?>>
	<header class="entry-header mb-4">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="text-3xl font-bold text-gray-900 leading-tight">', '</h1>' );
		else :
			the_title( '<h2 class="text-2xl font-bold text-gray-900 leading-tight"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="hover:text-indigo-600 transition-colors">', '</a></h2>' );
		endif;
		?>
	</header>

	<div class="entry-content text-gray-700 leading-relaxed">
		<?php
		if ( is_singular() ) :
			the_content();
		else :
			the_excerpt();
			?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="inline-block mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">Read More &rarr;</a>
			<?php
		endif;
		?>
	</div>
</article>
