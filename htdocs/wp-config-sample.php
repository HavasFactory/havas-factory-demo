<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
define( 'FORCE_SSL_ADMIN', true ); // Redirect All HTTP Page Requests to HTTPS - Security > Settings > Secure Socket Layers (SSL) > SSL for Dashboard
// END iThemes Security - Do not modify or remove this line

define( 'WP_CONTENT_DIR', realpath('/Users/kevin.rignault/Documents/PROJECTS/development/havas-factory.demo/htdocs/havas-content') );
define( 'WP_CONTENT_URL', 'https://' . $_SERVER['HTTP_HOST'] . '/havas-content' );
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'havas_demo' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'root' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'bHm|.g;2Id%yc)5]w<g9@vVJngk9sf%&Q@:tTrv6<gbv?#L$k%Mha=W;(/x$s5:E' );
define( 'SECURE_AUTH_KEY',  '3>{m7kwA{f pj,KhaJ4)@d}[#%6ATSS)} N{:i7/;{jtQMi;c^F{~aDD-{dP,+6%' );
define( 'LOGGED_IN_KEY',    '6x~(L{ awAYY;KdZY)MdibGrTJxv6gX,=[q&eG}]YnYtlwj)B/O*<vd)Yc}Q-79e' );
define( 'NONCE_KEY',        '!5D+gZ.gT@WU*FC.>P*gbT9-)/n=i`K~E{7f_U(0gV,_#pJUAXIaTfFjQ:MT=f)o' );
define( 'AUTH_SALT',        'jico3h:(6#6DL=-0Bf&6)dw]!|=6Y|]q2GMjXb_FcVic.z$.=}u1@<b:NE`ID6m8' );
define( 'SECURE_AUTH_SALT', '2c kkwB&ky!Yum(p198ipJ*^hy?|Z+ZsfRpQ@/-O(}lbhj@Yk4/]e({/x+h0~9)a' );
define( 'LOGGED_IN_SALT',   '2{I%T3<IGye~V3~e&TE2#z+;Ri|0Y5`3YO6qgTj4(.AeU,WlEmHdL[U{aXr^NkQD' );
define( 'NONCE_SALT',       'ro$uWpzG>8}>lcx4c%[W.FcJpC+.fS^,Zl^l0ScY&g`G28lTTw2_d <Sh7HQraVW' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'havas_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'WP_DEBUG_LOG', true );

// Block all WordPress auto updates
define( 'AUTOMATIC_UPDATER_DISABLED', true );
// Disable posts revisions
define( 'WP_POST_REVISIONS', 0 );
// Disable WordPress Cron -> need to call them with a real CRON tab
define( 'DISABLE_WP_CRON', true );
// Force PHP memory - maybe increase if WPML is used
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '256M' ); // used in admin area
// Force uploads to be filtered
define( 'ALLOW_UNFILTERED_UPLOADS', false );
// Block file editor in admin area
define( 'DISALLOW_FILE_EDIT', true );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
