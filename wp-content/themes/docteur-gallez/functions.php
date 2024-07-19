<?php

/**
 * Theme setup.
 */
function tailpress_setup() {
	add_theme_support( 'title-tag' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'tailpress' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

    add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'editor-styles' );
	add_editor_style( 'css/editor-style.css' );
}

add_action( 'after_setup_theme', 'tailpress_setup' );

/**
 * Enqueue theme assets.
 */
function tailpress_enqueue_scripts() {
	$theme = wp_get_theme();

	wp_enqueue_style( 'gallez', tailpress_asset( 'css/app.css' ), array(), $theme->get( 'Version' ) );
	wp_enqueue_script( 'gallez', tailpress_asset( 'js/app.js' ), array(), $theme->get( 'Version' ) );
	wp_enqueue_style( 'slick-stylesheet', tailpress_asset( 'css/slick.css' ), array(), $theme->get( 'Version' ) );
	wp_enqueue_script( 'gallez-jquery', tailpress_asset( 'js/jquery-3.6.0.min.js'), array(), $theme->get( 'Version' ) );
	wp_enqueue_script( 'gallez-slick', tailpress_asset( 'js/slick.min.js'), array(), $theme->get( 'Version' ) );
	wp_enqueue_script( 'gallez-app', tailpress_asset( 'js/app.js' ), array(), $theme->get( 'Version' ) );
	wp_register_style('googleFonts', '//fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap', array(), null);
	wp_enqueue_style('googleFonts');
}

add_action( 'wp_enqueue_scripts', 'tailpress_enqueue_scripts' );

/**
 * Get asset path.
 *
 * @param string  $path Path to asset.
 *
 * @return string
 */
function tailpress_asset( $path ) {
	if ( wp_get_environment_type() === 'production' ) {
		return get_stylesheet_directory_uri() . '/' . $path;
	}

	return add_query_arg( 'time', time(),  get_stylesheet_directory_uri() . '/' . $path );
}

/**
 * Adds option 'li_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The current item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tailpress_nav_menu_add_li_class( $classes, $item, $args, $depth ) {
	if ( isset( $args->li_class ) ) {
		$classes[] = $args->li_class;
	}

	if ( isset( $args->{"li_class_$depth"} ) ) {
		$classes[] = $args->{"li_class_$depth"};
	}

	return $classes;
}

add_filter( 'nav_menu_css_class', 'tailpress_nav_menu_add_li_class', 10, 4 );

/**
 * Adds option 'submenu_class' to 'wp_nav_menu'.
 *
 * @param string  $classes String of classes.
 * @param mixed   $item The current item.
 * @param WP_Term $args Holds the nav menu arguments.
 *
 * @return array
 */
function tailpress_nav_menu_add_submenu_class( $classes, $args, $depth ) {
	if ( isset( $args->submenu_class ) ) {
		$classes[] = $args->submenu_class;
	}

	if ( isset( $args->{"submenu_class_$depth"} ) ) {
		$classes[] = $args->{"submenu_class_$depth"};
	}

	return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'tailpress_nav_menu_add_submenu_class', 10, 3 );


// Enqueue Block Editor script
add_action('enqueue_block_editor_assets', 'example_block_enqueues');
function example_block_enqueues() {
    wp_enqueue_script('your-theme-editor-customisations', get_template_directory_uri() . '/editor.js', array('wp-edit-post', 'wp-blocks', 'wp-dom-ready'), '', true);
}


function register_widget_areas() {
	register_sidebar( array(
		'name'          => 'Footer area one',
		'id'            => 'footer_area_one',
		'description'   => 'This widget area discription',
		'before_widget' => '<section class="footer-area footer-area-one">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	  ));
  
  }
  
  add_action( 'widgets_init', 'register_widget_areas' );