<?php
/**
 * designclub functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package designclub
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'designclub_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function designclub_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on designclub, use a find and replace
		 * to change 'designclub' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'designclub', get_template_directory() . '/languages' );

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
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary', 'designclub' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'designclub_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'designclub_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function designclub_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'designclub_content_width', 640 );
}
add_action( 'after_setup_theme', 'designclub_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function designclub_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'designclub' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'designclub' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'designclub_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function designclub_scripts() {
	wp_enqueue_style( 'designclub-style', get_stylesheet_uri(), array(), _S_VERSION );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'designclub_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/*** Admin Login ***/
function login_logo(){
	echo '<style type="text/css">
        body{background: #DBDBDB !important; }
        body:before {
            content: "";
            position: absolute;
            right: 0;
            top: 0;
            width: 100%;
            height: 100%;
            clip-path: polygon(100% 100%,100% 0%,0 100%);
            background: #ffffff;
            z-index: -1;
        }
        p a{color:#fff !important;}
        h1 a{background-image: url('.get_bloginfo('template_directory') .'/images/logo.png) !important;background-size:70% !important; width:100% !important;margin: 0 auto !important; box-shadow: none !important; height: 80px !important;}
        #nav a{color:#000000 !important;}
        #backtoblog a{color:#000000 !important;}
        .wp-core-ui .button-primary {
		    background: #000000;
		    border-color: #000000;
		    color: #fff;
		    text-decoration: none;
		    text-shadow: none;
		}.wp-core-ui .button-secondary {
			color: #000000;}
		.wp-core-ui .button-primary:hover {
		    background: #000000;
		    border-color: #000000;
		    color: #fff;
		}
		input[type=password]:focus,input[type=text]:focus,input[type=checkbox]:focus{border-color: #000000;
		    box-shadow: 0 0 0 1px #000000;
			outline: 2px solid transparent;}
		</style>';
}
add_action('login_head','login_logo');

function my_login_logo_url() {
    return esc_url( home_url( '/' ) );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

add_filter('nav_menu_css_class', function ( $classes, $item, $args ){
  if($args->list_item_class) { $classes[] = $args->list_item_class; }
  return $classes;
}, 1, 3);
add_filter( 'nav_menu_link_attributes', function( $atts, $item, $args ){
  if($args->link_class) { $atts['class'] = $args->link_class; }
  return $atts;
}, 1, 3 );

if(function_exists('acf_add_options_page')){
	acf_add_options_page(array(
	        'page_title' => 'Theme Options',
            'menu_title' => 'Theme Options',
            'menu_slug' => 'theme-options',
            'capability'    => 'manage_options',
            'position' => 62
    ));
}

/**
 * WP_NAV_MENU attributes
 */
add_filter('nav_menu_css_class', function ( $classes, $item, $args ){
  if($args->list_item_class) { $classes[] = $args->list_item_class; }
  return $classes;
}, 1, 3);
add_filter( 'nav_menu_link_attributes', function( $atts, $item, $args ){
  if($args->link_class) { $atts['class'] = $args->link_class; }
  return $atts;
}, 1, 3 );

function override_mce_options($initArray) 
{
    $opts = '*[*]';
    $initArray['valid_elements'] = $opts;
    $initArray['extended_valid_elements'] = $opts;
    return $initArray;
}
add_filter('tiny_mce_before_init', 'override_mce_options');

function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

function custom_excerpt_more($more) {
   global $post;
   return '…';
}
add_filter('excerpt_more', 'custom_excerpt_more');

function ts_custom_excerpt_length( $length ) {
return 20;
}
add_filter( 'excerpt_length', 'ts_custom_excerpt_length', 999 );