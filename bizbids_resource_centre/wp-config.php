<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'bizbids_blog');

/** MySQL database username */
define('DB_USER', 'anup');

/** MySQL database password */
define('DB_PASSWORD', 'tripleseven7');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'EE~}8DxwGK?50eY_epLv Q H ^jQLJ;V@#vCPc3]crNaV9ipW$_-31#c6OLCu2LC');
define('SECURE_AUTH_KEY',  '1I .p%/!B<7oz0fH2N+MP7|dLI;=M1@Il*FDEY9>t:e63xhP4DB{*1SC+mK.rI86');
define('LOGGED_IN_KEY',    '@{rRhwii$JqXvB}$HeH8TV+K]bk06Cz1UgXJ2FdT/bQFziT>;J3f-OC,-sN(-_sm');
define('NONCE_KEY',        '7;Som|+Iw/l>F.{leY1dfUH*9k9We-6Y7xxG_-2j,>~k-cXG3$Swo/z3Kdw5<g-4');
define('AUTH_SALT',        '4d8Pq~%+s<>|[$8-a)pJ.A`%fZnQd`wr.Um&@#rGTT<D-da1=/,gE#763a,:htQ]');
define('SECURE_AUTH_SALT', '6(n ;y:$Inr1r IjuR-i/Mh&x$J?4o%qG(8K:H^W)e_PuZ_!}2aiC<jKem9ZALCf');
define('LOGGED_IN_SALT',   '$q=w}T]J_32M0f!Cm!Q@}f%R^O RR+Rp,*j+<fdQF!9Y @Re,cJjsf?b>lOoPVJ}');
define('NONCE_SALT',       's{G|K(!,%k~V36]tI`0GcKKw_D6}%S!aAf@bbJ#M/cuM+]KD[A|!r$:NO8JfsK1|');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
