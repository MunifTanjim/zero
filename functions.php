<?php
/**
 * Zero functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Zero
 * @since 0.1.0
 */

/**
 * Zero only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function zero_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on zero, use a find and replace
	 * to change 'zero' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'zero', get_parent_theme_file_path( '/languages' ) );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// This theme uses wp_nav_menu() in two location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'zero' ),
		'social'  => esc_html__( 'Social', 'zero' ),
	) );

	/*
	 * Add support for selective refresh.
	 *
	 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#widgets-opting-in-to-selective-refresh
	 */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', apply_filters( 'zero_custom_logo_arguments', array(
		'height'      => 90,
		'width'       => 90,
		'flex-height' => true,
		'flex-width'  => true,
	) ) );

	/*
 	* This theme styles the visual editor to resemble the theme style,
 	* specifically font, colors, icons, and column width.
 	*/
	add_editor_style( array( 'assets/css/editor-style.css' ) );
}
add_action( 'after_setup_theme', 'zero_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function zero_content_width() {

	$content_width = 640;

	$GLOBALS['content_width'] = apply_filters( 'zero_content_width', $content_width );
}
add_action( 'after_setup_theme', 'zero_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function zero_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Footer widget area 1', 'zero' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here for footer widget area 1.', 'zero' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer widget area 2', 'zero' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here for footer widget area 2.', 'zero' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer widget area 3', 'zero' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here for footer widget area 3.', 'zero' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Front Page template widget area', 'zero' ),
		'id'            => 'front-page',
		'description'   => esc_html__( 'Add widgets here for Front Page template.', 'zero' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner-wrapper">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'zero_widgets_init' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Zero 0.1.0
 */
function zero_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'zero_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function zero_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_html( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'zero_pingback_header' );


/**
 * Enqueue scripts and styles.
 */
function zero_scripts() {
	// Get '.min' suffix.
	$suffix = zero_get_min_suffix();

	// Add parent theme styles if using child theme.
	if ( is_child_theme() ) {
		wp_enqueue_style( 'zero-parent-style', get_theme_file_uri( '/style' . $suffix . '.css' ), array(), null );
	}

	// Theme stylesheet.
	wp_enqueue_style( 'zero-style', get_stylesheet_uri() );

	// Add theme scripts.
	wp_enqueue_script( 'zero-navigation', get_theme_file_uri( '/assets/js/navigation' . $suffix . '.js' ), array(), '20161220', true );

	wp_enqueue_script( 'zero-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix' . $suffix . '.js' ), array(), '20161220', true );

	// Add comments script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'zero_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Implement the Custom Background feature.
 */
require get_parent_theme_file_path( '/inc/custom-background.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * Load Jetpack compatibility file.
 */
require get_parent_theme_file_path( '/inc/jetpack.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );
