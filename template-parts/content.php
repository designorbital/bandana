<?php
/**
 * The default template for displaying content
 *
 * @package Bandana
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( bandana_has_post_thumbnail() ) : ?>
	<div class="entry-image-wrapper">
		<?php bandana_post_thumbnail(); ?>
	</div><!-- .entry-image-wrapper -->
	<?php endif; ?>

	<div class="entry-content-wrapper">

		<?php if ( 'post' === get_post_type() ) : // For Posts ?>
		<div class="entry-meta entry-meta-header-before">
			<?php
			bandana_posted_on();
			bandana_first_category();
			bandana_sticky_post();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<header class="entry-header">
			<?php the_title( sprintf( '<h1 class="entry-title"><a href="%1$s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
		</header><!-- .entry-header -->

		<?php if ( bandana_has_excerpt() ) : ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php endif; ?>

		<div class="more-link-wrapper">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="more-link"><?php esc_html_e( 'Continue Reading', 'bandana' ); ?></a>
		</div><!-- .more-link-wrapper -->

	</div><!-- .entry-content-wrapper -->

</article><!-- #post-## -->
