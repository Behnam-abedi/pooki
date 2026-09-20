<?php
/**
 * The template for displaying all single posts
 *
 * @package Pooki
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-12 max-w-4xl">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'large', [
						'class'         => 'w-full h-auto rounded-xl mb-8 object-cover shadow-sm',
						'fetchpriority' => 'high',
					] );
				}
				?>
				<h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight"><?php the_title(); ?></h1>
				<div class="text-gray-500 text-sm mb-8"><?php echo get_the_date(); ?></div>
				<div class="pooki-post-content text-gray-700 leading-relaxed space-y-6 text-lg">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		endwhile;
	endif;
	?>
</main>

<?php
get_footer();
