<?php
/**
 * Bandana functions and definitions
 *
 * @package Bandana
 */

if ( ! function_exists( 'bandana_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bandana_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Bandana, use a find and replace
	 * to change 'bandana' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'bandana', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 200,
		'width'       => 580,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// Theme Image Sizes
	add_image_size( 'bandana-featured', 695, 521, true );

	// This theme uses wp_nav_menu() in four locations.
	register_nav_menus( array (
		'header-menu' => esc_html__( 'Header Menu', 'bandana' ),
	) );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array ( 'css/editor-style.css', bandana_fonts_url() ) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array (
		'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'bandana_custom_background_args', array (
		'default-color' => 'f5f5f5',
		'default-image' => '',
	) ) );

}
endif; // bandana_setup
add_action( 'after_setup_theme', 'bandana_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bandana_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bandana_content_width', 695 );
}
add_action( 'after_setup_theme', 'bandana_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function bandana_widgets_init() {

	// Widget Areas
	register_sidebar( array(
		'name'          => esc_html__( 'Main Sidebar', 'bandana' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'bandana_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bandana_scripts() {

	/**
	 * Enqueue JS files
	 */

	// Enquire
	wp_enqueue_script( 'enquire', get_template_directory_uri() . '/js/enquire.js', array( 'jquery' ), '2.1.2', true );

	// Superfish Menu
	wp_enqueue_script( 'hover-intent', get_template_directory_uri() . '/js/hover-intent.js', array( 'jquery' ), 'r7', true );
	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '1.7.5', true );

	// Comment Reply
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Keyboard image navigation support
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'bandana-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20140127', true );
	}

	// Custom Script
	wp_enqueue_script( 'bandana-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '1.0', true );

	/**
	 * Enqueue CSS files
	 */

	// Bootstrap
	wp_enqueue_style( 'bandana-bootstrap', get_template_directory_uri() . '/css/bootstrap.css' );

	// Fontawesome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css' );

	// Fonts
	wp_enqueue_style( 'bandana-fonts', bandana_fonts_url(), array(), null );

	// Theme Stylesheet
	wp_enqueue_style( 'bandana-style', get_stylesheet_uri() );

}
add_action( 'wp_enqueue_scripts', 'bandana_scripts' );

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
