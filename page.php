<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Bandana
 */

get_header(); ?>

	<div class="container">
		<div class="row">

			<div id="primary" class="content-area <?php bandana_layout_class( 'content' ); ?>">
				<main id="main" class="site-main" role="main">

					<div id="post-wrapper" class="post-wrapper">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'template-parts/content', 'page' ); ?>

						<?php
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || '0' != get_comments_number() ) :
								comments_template();
							endif;
						?>

					<?php endwhile; // end of the loop. ?>
					</div><!-- .post-wrapper -->

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php get_sidebar(); ?>

		</div><!-- .row -->
	</div><!-- .container -->

<?php get_footer(); ?>
