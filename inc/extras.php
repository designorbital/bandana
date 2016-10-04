<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Bandana
 */

/**
 * Theme Mod Defaults
 *
 * @param string $theme_mod - Theme modification name.
 * @return mixed
 */
function bandana_default( $theme_mod = '' ) {

	$default = array (
		'bandana_sidebar_position' => 'right',
	);

	return ( isset ( $default[$theme_mod] ) ? $default[$theme_mod] : '' );

}

/**
 * Theme Mod Wrapper
 *
 * @param string $theme_mod - Name of the theme mod to retrieve.
 * @return mixed
 */
function bandana_mod( $theme_mod = '' ) {
	return get_theme_mod( $theme_mod, bandana_default( $theme_mod ) );
}

/**
 * Register Google fonts for Cell.
 *
 * @return string Google fonts URL for the theme.
 */
function bandana_fonts_url() {

    // Fonts and Other Variables
    $fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

    /* Translators: If there are characters in your language that are not
    * supported by Lato, translate this to 'off'. Do not translate
    * into your own language.
    */
    if ( 'off' !== esc_html_x( 'on', 'Lato font: on or off', 'bandana' ) ) {
		$fonts[] = 'Lato';
	}

	/* Translators: If there are characters in your language that are not
    * supported by Merriweather Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    if ( 'off' !== esc_html_x( 'on', 'Merriweather Sans font: on or off', 'bandana' ) ) {
		$fonts[] = 'Merriweather Sans';
	}

	/* Translators: If there are characters in your language that are not
    * supported by Montserrat, translate this to 'off'. Do not translate
    * into your own language.
    */
    if ( 'off' !== esc_html_x( 'on', 'Montserrat font: on or off', 'bandana' ) ) {
		$fonts[] = 'Montserrat';
	}

	/* Translators: To add an additional character subset specific to your language,
	* translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'.
	* Do not translate into your own language.
	*/
	$subset = esc_html_x( 'no-subset', 'Add new subset (cyrillic, greek, devanagari, vietnamese)', 'bandana' );

	if ( 'cyrillic' === $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' === $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' === $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' === $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;

}

/**
 * Filter 'get_custom_logo'
 *
 * @return string
 */
function bandana_get_custom_logo( $html ) {
	return sprintf( '<div class="site-logo-wrapper">%1$s</div>', $html );
}
add_filter( 'get_custom_logo', 'bandana_get_custom_logo' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function bandana_page_menu_args( $args ) {
	$args['show_home'] = true;
	$args['menu_class'] = 'site-header-menu';
	return $args;
}
add_filter( 'wp_page_menu_args', 'bandana_page_menu_args' );

/**
 * Add ID and CLASS attributes to the first <ul> occurence in wp_page_menu
 */
function bandana_page_menu_class( $class ) {
  return preg_replace( '/<ul>/', '<ul class="header-menu sf-menu">', $class, 1 );
}
add_filter( 'wp_page_menu', 'bandana_page_menu_class' );

/**
 * Filter 'excerpt_length'
 *
 * @param int $length
 * @return int
 */
function bandana_excerpt_length( $length ) {
	return apply_filters( 'bandana_excerpt_length', 25 );
}
add_filter( 'excerpt_length', 'bandana_excerpt_length' );

/**
 * Filter 'excerpt_more'
 *
 * Remove [...] string
 * @param str $more
 * @return str
 */
function bandana_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'bandana_excerpt_more' );

/**
 * Filter 'the_content_more_link'
 * Prevent Page Scroll When Clicking the More Link.
 *
 * @param string $link
 * @return filtered link
 */
function bandana_the_content_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'bandana_the_content_more_link_scroll' );

/**
 * Filter `body_class`
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function bandana_body_classes( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Site Title & Tagline Class
	if ( display_header_text() ) {
		$classes[] = 'has-site-branding';
	}

	// Custom Header
	if ( get_header_image() ) {
		$classes[] = 'has-custom-header';
	}

	// Custom Background Image
	if ( get_background_image() ) {
		$classes[] = 'has-custom-background-image';
	}

	// Sidebar Position Class
	if ( bandana_has_sidebar() ) {
		$classes[] = 'has-' . esc_attr( bandana_mod( 'bandana_sidebar_position' ) ) . '-sidebar';
	} else {
		$classes[] = 'has-no-sidebar';
	}

	// Excerpt Class
	if ( bandana_has_excerpt() ) {
		$classes[] = 'has-excerpt';
	}

	return $classes;
}
add_filter( 'body_class', 'bandana_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function bandana_attachment_link( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) ) {
		return $url;
	}

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id ) {
		$url .= '#main';
	}

	return $url;
}
add_filter( 'attachment_link', 'bandana_attachment_link', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function bandana_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'bandana_setup_author' );

/**
 * Blog Credits.
 *
 * @return void
 */
function bandana_credits_blog() {
	$credit_blog_string = '<div class="credits-blog">&copy; %1$s %2$s <span>&sdot;</span> <a href="%3$s">%4$s</a></div>';
	printf( $credit_blog_string,
		esc_html__( 'Copyright', 'bandana' ),
		esc_html( date( 'Y' ) ),
		esc_url( home_url() ),
		esc_html( get_bloginfo( 'name' ) )
	);
}
add_action( 'bandana_credits', 'bandana_credits_blog' );

/**
 * Display Designer Credits.
 *
 * @return void
 */
function bandana_credit_designer() {
	$credit_designer_string = '<a href="%1$s" title="%2$s">%2$s</a> <span>&sdot;</span> %3$s <a href="%4$s" title="%5$s">%5$s</a>';
	printf( $credit_designer_string,
		esc_url( 'https://designorbital.com/bandana/' ),
		'Bandana Theme',
		esc_html__( 'Powered by', 'bandana' ),
		esc_url( __( 'https://wordpress.org/', 'bandana' ) ),
		'WordPress'
	);
}
add_action( 'bandana_credits', 'bandana_credit_designer' );

if ( ! function_exists( 'bandana_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @return void
 */
function bandana_the_attached_image() {
	$post                = get_post();
	/**
	 * Filter the default Bandana attachment size.
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 1140.
	 *     @type int $width  Width of the image in pixels. Default 1140.
	 * }
	 */
	$attachment_size     = apply_filters( 'bandana_attachment_size', 'full' );
	$next_attachment_url = wp_get_attachment_url();

	if ( $post->post_parent ) { // Only look for attachments if this attachment has a parent object.

		/*
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => 100,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID',
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {

			foreach ( $attachment_ids as $key => $attachment_id ) {
				if ( $attachment_id === $post->ID ) {
					break;
				}
			}

			// For next attachment
			$key++;

			if ( isset( $attachment_ids[ $key ] ) ) {
				// get the URL of the next image attachment
				$next_attachment_url = get_attachment_link( $attachment_ids[$key] );
			} else {
				// or get the URL of the first image attachment
				$next_attachment_url = get_attachment_link( $attachment_ids[0] );
			}

		}

	} // end post->post_parent check

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		esc_attr( get_the_title() ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);

}
endif;
