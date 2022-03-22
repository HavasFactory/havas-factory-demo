<?php
/**
 * Digital Factory plugin bootstrap file
 *
 * @link              http://www.havasdigitalfactory.com/
 * @since             1.0.1
 * @package           Digital_Factory_Bootstrap
 *
 * @wordpress-plugin
 * Plugin Name:       Digital Factory Bootstrap
 * Plugin URI:        http://www.havasdigitalfactory.com/
 * Description:       Clean and block unused features / API option page
 * Version:           1.0.1
 * Author:            Sébastien Gastard - Digital Factory
 * Author URI:        http://www.havasdigitalfactory.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       digital-factory-bootstrap
 */

if ( ! function_exists( 'no_autosave' ) ) :
	/**
	 * On désactive le système de sauvegarde automatique
	 */
	function no_autosave() {
		wp_deregister_script( 'autosave' );
	}
endif;

if ( ! function_exists( 'wpt_remove_version' ) ) :
	/**
	 * On supprime le tag generator dans le flux RSS
	 *
	 * @return string
	 */
	function wpt_remove_version() {
		return '';
	}
endif;

if ( ! function_exists( 'vc_remove_wp_ver_css_js' ) ) :
	/**
	 * On supprime le numéro de version que Wordpress passe en paramètre des scripts
	 *
	 * @param $src
	 *
	 * @return string
	 */
	function vc_remove_wp_ver_css_js( $src ) {
		if ( strpos( $src, 'ver=' ) ) {
			$src = remove_query_arg( 'ver', $src );
		}

		return $src;
	}
endif;

if ( ! function_exists( 'wpc_sanitize_french_chars' ) ) :
	/**
	 * On force le renommage des fichiers lors de l'upload dans la galerie média (site en FR, par défaut Wordpress laisse les majuscules et les caractères accentués)
	 *
	 * @param $filename
	 *
	 * @return mixed|string
	 */
	function wpc_sanitize_french_chars( $filename ) {
		// Force the file name in UTF-8 (encoding Windows / Mac / Linux)
		$filename = mb_convert_encoding( $filename, 'UTF-8' );

		$char_not_clean = array(
			'/@/',
			'/À/',
			'/Á/',
			'/Â/',
			'/Ã/',
			'/Ä/',
			'/Å/',
			'/Ç/',
			'/È/',
			'/É/',
			'/Ê/',
			'/Ë/',
			'/Ì/',
			'/Í/',
			'/Î/',
			'/Ï/',
			'/Ò/',
			'/Ó/',
			'/Ô/',
			'/Õ/',
			'/Ö/',
			'/Ù/',
			'/Ú/',
			'/Û/',
			'/Ü/',
			'/Ý/',
			'/à/',
			'/á/',
			'/â/',
			'/ã/',
			'/ä/',
			'/å/',
			'/ç/',
			'/è/',
			'/é/',
			'/ê/',
			'/ë/',
			'/ì/',
			'/í/',
			'/î/',
			'/ï/',
			'/ð/',
			'/ò/',
			'/ó/',
			'/ô/',
			'/õ/',
			'/ö/',
			'/ù/',
			'/ú/',
			'/û/',
			'/ü/',
			'/ý/',
			'/ÿ/',
			'/©/',
		);
		$clean          = array(
			'a',
			'a',
			'a',
			'a',
			'a',
			'a',
			'a',
			'c',
			'e',
			'e',
			'e',
			'e',
			'i',
			'i',
			'i',
			'i',
			'o',
			'o',
			'o',
			'o',
			'o',
			'u',
			'u',
			'u',
			'u',
			'y',
			'a',
			'a',
			'a',
			'a',
			'a',
			'a',
			'c',
			'e',
			'e',
			'e',
			'e',
			'i',
			'i',
			'i',
			'i',
			'o',
			'o',
			'o',
			'o',
			'o',
			'o',
			'u',
			'u',
			'u',
			'u',
			'y',
			'y',
			'copy',
		);

		$friendly_filename = preg_replace( $char_not_clean, $clean, $filename );

		// After replacement, we destroy the last residues
		$friendly_filename = utf8_decode( $friendly_filename );
		$friendly_filename = preg_replace( '/\?/', '', $friendly_filename );

		// Lowercase
		$friendly_filename = strtolower( $friendly_filename );

		return $friendly_filename;
	}
endif;

if ( ! function_exists( 'cetsi_remove_smt_auth' ) ) :
	/**
	 * On désactive l'authentification auto par SMTP pour l'envoi de mail via la fonction wp_mail() dû à un bug PHP 5.6 et SSL
	 *
	 * @param $phpmailer
	 */
	function cetsi_remove_smt_auth( $phpmailer ) {
		if ( is_ssl() && version_compare( PHP_VERSION, '5.6.0' ) >= 0 ) {
			$phpmailer->SMTPAutoTLS = false;
		}
	}
endif;

if ( ! function_exists( 'secure_API' ) ) :
	/**
	 * Require allowed endpoint to be used
	 */
	function secure_API( $access ) {
		// block default endpoint from the REST API, like /wp-json/xx/v1/xxx/
		$forbidden_endpoints = array(
			'#/wp-json(/)?$#',
			'#/wp-json/wp(/)?$#',
			'#/wp-json/wp/(.*)?$#',
		);

		foreach ( $forbidden_endpoints as $regex_forbidden_endpoint ) {
			preg_match( $regex_forbidden_endpoint, $_SERVER['REQUEST_URI'], $matches );

			if ( count( $matches ) > 0 ) {
				return new WP_Error( 'rest_cannot_access', __( 'Forbidden access', 'hdf' ), array( 'status' => rest_authorization_required_code() ) );
			}
		}

		return $access;
	}
endif;

if ( ! function_exists( 'clean_theme' ) ) :
	/**
	 * Nettoyage du header / API / Désactivation des emoji dans header.php
	 */
	function clean_theme() {
		// WP version.
		remove_action( 'wp_head', 'wp_generator' );
		// Post and comment feed links.
		remove_action( 'wp_head', 'feed_links', 2 );
		// Index link.
		remove_action( 'wp_head', 'index_rel_link' );
		// Shortlink.
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
		// Windows Live Writer.
		remove_action( 'wp_head', 'wlwmanifest_link' );
		// Category feed links.
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		// Start link.
		remove_action( 'wp_head', 'start_post_rel_link', 10 );
		// Previous link.
		remove_action( 'wp_head', 'parent_post_rel_link', 10 );
		// Canonical.
		remove_action( 'wp_head', 'rel_canonical', 10 );
		// Links for adjacent posts.
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
		// Emoji detection script.
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		// Emoji styles.
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		// REST API
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
		// hide API link and need tu be logged-in to use
		add_filter( 'rest_authentication_errors', 'secure_API' );

		// XML RPC
		add_filter( 'xmlrpc_enabled', '__return_false' );
		remove_action( 'wp_head', 'rsd_link' );

		// si multilingue
		global $sitepress;
		remove_action( 'wp_head', array( $sitepress, 'meta_generator_tag' ) );
		if ( defined( 'WPSEO_VERSION' ) ) {
			add_action( 'get_header', function () {
				ob_start( function ( $o ) {
					return preg_replace( '/\n?<.*?yoast.*?>/mi', '', $o );
				} );
			} );
			add_action( 'wp_head', function () {
				ob_end_flush();
			}, 999 );
		}
	}
endif;

if ( ! function_exists( 'block_author_archive' ) ) :
	/**
	 * On bloque le référencement naturel de WP de la liste des users
	 *
	 * @param $query
	 */
	function block_author_archive( &$query ) {
		if ( ! is_admin() && $query->is_author ) {
			wp_redirect( home_url( '/' ), 301 );
			exit();
		}
	}
endif;

if ( ! function_exists( 'restrict_access_bo' ) ) :
	/**
	 * Restriction d'accès au BO à l'admin et aux éditeurs
	 */
	function restrict_access_bo() {
		if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
			if ( ! current_user_can( 'administrator' ) && ! current_user_can( 'editor' ) && !current_user_can('df_contact_data_manager') ) {
				wp_redirect( home_url( '/' ), 302 );
				exit();
			}
		}
	}
endif;


if ( ! function_exists( 'remove_native_search' ) ) :
	/**
	 * @param $query
	 */
	function remove_native_search( $query ) {

		if ( $query->is_search && $query->is_main_query() ) {
			unset( $_GET['s'] );
			unset( $_POST['s'] );
			unset( $_REQUEST['s'] );
			unset( $query->query['s'] );
			$query->set( 's', '' );
			$query->is_search = false;
			$query->set_404();
			status_header( 404 );
			nocache_headers();
		}
	}
endif;

if ( ! function_exists( 'remove_native_search_form' ) ) :
	/**
	 * @param $form
	 *
	 * @return void
	 */
	function remove_native_search_form( $form ) {

		return '';
	}
endif;

if ( ! function_exists( 'hdf_add_favicon' ) ):
	/**
	 * Add favicons to the current theme
	 */
	function hdf_add_favicon() {
		?>
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo( esc_url( get_stylesheet_directory_uri() . '/favicons/apple-touch-icon.png' ) ); ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo( esc_url( get_stylesheet_directory_uri() . '/favicons/favicon-32x32.png' ) ); ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo( esc_url( get_stylesheet_directory_uri() . '/favicons/favicon-16x16.png' ) ); ?>">
        <link rel="manifest" href="<?php echo( esc_url( get_stylesheet_directory_uri() . '/favicons/webmanifest.json' ) ); ?>">
        <link rel="mask-icon" href="<?php echo( esc_url( get_stylesheet_directory_uri() . '/favicons/safari-pinned-tab.svg' ) ); ?>" color="#5bbad5">
        <meta name="theme-color" content="#ffffff">
		<?php
	}
endif;

if ( ! function_exists( 'hdf_check_favicon' ) ):
	/**
	 * Check the favicons, show a warning message in BO if not present
	 */
	function hdf_check_favicon() {
		$required_files = array(
			'apple-touch-icon.png',
			'favicon-32x32.png',
			'favicon-16x16.png',
			'webmanifest.json',
			'safari-pinned-tab.svg',
		);

		// all files are required
		$message = array();

		foreach ( $required_files as $required_file ):
			if ( ! file_exists( get_stylesheet_directory() . '/favicons/' . $required_file ) ):
				$message[] = sprintf( __( '%s is missing.', 'hdf' ), get_stylesheet_directory_uri() . '/favicons/' . $required_file );
			endif;
		endforeach;

		if ( count( $message ) > 0 ):
			$class        = 'notice notice-error';
			$html_message = __( 'Please don\'t forget to <a href="https://realfavicongenerator.net" target="_blank">provide favicons</a>.', 'hdf' );
			$html_message .= '<br>' . implode( '<br>', $message );
			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $html_message );
		endif;
	}
endif;

if ( ! function_exists( 'hdf_remove_type_attr' ) ) :
	/**
	 * Remove type tag from script and style
	 */
	function hdf_remove_type_attr( $tag, $handle = '' ) {
		return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
	}
endif;

/**
 * Custom snippet to add poylang support in custom endpoitn REST API (via ?lang=XX)
 */
if ( ! function_exists( 'polylang_json_api_init' ) ) :
	function polylang_json_api_init() {
		if ( function_exists( 'pll_default_language' ) ):
			global $polylang;

			$default  = pll_default_language();
			$langs    = pll_languages_list();
			$cur_lang = '';

			if ( isset( $_GET['lang'] ) ):
				$cur_lang = $_GET['lang'];
			endif;

			if ( ! in_array( $cur_lang, $langs ) ) {
				$cur_lang = $default;
			}

			$polylang->curlang         = $polylang->model->get_language( $cur_lang );
			$GLOBALS['text_direction'] = $polylang->curlang->is_rtl ? 'rtl' : 'ltr';
		endif;
	}
endif;

/*
	ACTIONS
*/
add_action( 'wp_print_scripts', 'no_autosave' );
add_action( 'phpmailer_init', 'cetsi_remove_smt_auth' );
add_action( 'init', 'clean_theme' );
add_action( 'pre_get_posts', 'block_author_archive' );
add_action( 'admin_init', 'restrict_access_bo' );
add_action( 'wp_head', 'hdf_add_favicon' );
add_action( 'admin_notices', 'hdf_check_favicon' );
add_action( 'rest_api_init', 'polylang_json_api_init' );

if ( ! is_admin() ) {
	add_action( 'parse_query', 'remove_native_search' );
}

/*
	FILTERS
*/
add_filter( 'sanitize_file_name', 'wpc_sanitize_french_chars', 10 );
add_filter( 'the_generator', 'wpt_remove_version' );
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'get_search_form', 'remove_native_search_form' );
add_filter( 'style_loader_tag', 'hdf_remove_type_attr', 10, 2 );
add_filter( 'script_loader_tag', 'hdf_remove_type_attr', 10, 2 );
add_filter( 'autoptimize_html_after_minify', 'hdf_remove_type_attr', 10, 2 );