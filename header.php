<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Bandana
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site-wrapper site">

	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="row">
				<div class="col-xxl-12">

					<div class="site-header-inside-wrapper">
						<div class="site-branding-wrapper">
							<?php
							// Site Custom Logo
							if ( function_exists( 'the_custom_logo' ) ) {
								the_custom_logo();
							}
							?>

							<div class="site-branding">
								<?php if ( is_front_page() && is_home() ) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
								<?php else : ?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
								<?php endif; ?>

								<?php
								$description = get_bloginfo( 'description', 'display' );
								if ( $description || is_customize_preview() ) :
								?>
								<p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
								<?php endif; ?>
							</div>
						</div><!-- .site-branding-wrapper -->
					</div><!-- .site-header-inside-wrapper -->

				</div><!-- .col-xxl-12 -->
			</div><!-- .row -->
		</div><!-- .container -->
	</header><!-- #masthead -->

	<nav id="site-navigation" class="main-navigation" role="navigation">
		<div class="container">
			<div class="row">
				<div class="col-xxl-12">

					<div class="main-navigation-inside">

						<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bandana' ); ?></a>
						<div class="toggle-menu-wrapper">
							<a href="#header-menu-responsive" title="<?php esc_attr_e( 'Menu', 'bandana' ); ?>" class="toggle-menu-control">
								<span class="toggle-menu-label"><?php esc_html_e( 'Menu', 'bandana' ); ?></span>
							</a>
						</div>

						<?php
						// Header Menu
						wp_nav_menu( apply_filters( 'bandana_header_menu_args', array(
							'container'       => 'div',
							'container_class' => 'site-header-menu',
							'theme_location'  => 'header-menu',
							'menu_class'      => 'header-menu sf-menu',
							'menu_id'         => 'menu-1',
							'depth'           => 3,
						) ) );
						?>

					</div><!-- .main-navigation-inside -->

				</div><!-- .col-xxl-12 -->
			</div><!-- .row -->
		</div><!-- .container -->
	</nav><!-- .main-navigation -->

	<div id="content" class="site-content">
