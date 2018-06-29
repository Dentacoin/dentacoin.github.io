<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/dentacoi/public_html/blog/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'dentacoi_iwR');

/** MySQL database username */
define('DB_USER', 'dentacoi_iwR');

/** MySQL database password */
define('DB_PASSWORD', 'fZmyUPhoJ]Sv');

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
define('AUTH_KEY',         'Tqzu:;X,*~eMe>kt#YOFF[Yla[@@tn<k)XD6bD0KYvjFkm ;5Gvo5YKUVlKE)7Na');
define('SECURE_AUTH_KEY',  'dE!aUM;L8a9bT=*L.?Yu]GB#PYQ377X9y/f6 xu([KFfwT /|]V?`(y3<2JuKE%3');
define('LOGGED_IN_KEY',    '[b4TX<1$bw|8~|GZ<<7OCIz9u@?)>Q[Zb_>Z]VZ[V7|sS$,#HUaL?!V;$tm_PP@n');
define('NONCE_KEY',        '+EeYD=pA2EF>HntGQBfSx#Wmp7?BX.NVT51yS#;eHb%qRz9$=!W6%/%vGD9!SgW(');
define('AUTH_SALT',        'iQm>76=(T8BXUD1lIAqAi7ZjjCCsA-urz5+27I:ka]E8V%Lxwmb/IMzmpn/e#yz/');
define('SECURE_AUTH_SALT', ',3XG ;&ES(|YUuQDXam][wLkv3np/~BWEBrKhGTe!+SO66>=sy6Af-TV~cU|&-CI');
define('LOGGED_IN_SALT',   '!n2IDxJOV~ l5>+)9AK!O WNd-Kk;n5=^Hf$B1Sx0TfFsqO-4z.cf2`s^M0NbM-,');
define('NONCE_SALT',       '41NFeGW;//!N=6JKyF2-(lU7;9eHEyZs@A<wKvkME)doU_7hl?pZu)u/n?ThzI*<');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'dIf_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
