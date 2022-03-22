<?php
/**
 * Havas Theme functions and definitions
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package havas_Theme_Name
 */

if ( ! function_exists( 'havas_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function havas_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Havas Theme, use a find and replace
		 * to change 'havas' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'havas', get_template_directory() . '/languages' );
		
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
		
		add_image_size( 'thumbnail-presse-gallery', 250, 0, true );
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'havas' ),
			'menu-2' => esc_html__( 'Secondary', 'havas' ),
			'menu-3' => esc_html__( 'Tertiary', 'havas' ),
		) );
		
	}
endif;
add_action( 'after_setup_theme', 'havas_setup' );


if ( ! function_exists( 'hide_menu' ) ) :
	/**
	 *  On autorise en back-office l'accès à la gestion des menus et des widgets pour les utilisateurs "Editeur"
	 */
	function hide_menu() {
		// on supprime les menus non utilisés
		// remove_menu_page( 'index.php' );                  //Dashboard
		// remove_menu_page( 'jetpack' );                    //Jetpack*
		// remove_menu_page( 'edit.php' );                   //Posts
		// remove_menu_page( 'upload.php' );                 //Media
		// remove_menu_page( 'edit.php?post_type=page' );    //Pages
		remove_menu_page( 'edit-comments.php' );          //Comments
		// remove_menu_page( 'themes.php' );                 //Appearance
		// remove_menu_page( 'plugins.php' );                //Plugins
		// remove_menu_page( 'users.php' );                  //Users
		// remove_menu_page( 'tools.php' );                  //Tools
		// remove_menu_page( 'options-general.php' );        //Settings
	}
endif;
add_action( 'admin_head', 'hide_menu' );


/**
 * remove css inline breadcrumb
 */
add_filter( 'seopress_pro_breadcrumbs_css', '__return_empty_string' );