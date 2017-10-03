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
define('DB_NAME', 'dentacoi_wp328');

/** MySQL database username */
define('DB_USER', 'dentacoi_wp328');

/** MySQL database password */
define('DB_PASSWORD', '!i(7iS4p7S');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'g5uadgzckmikyhyq4pdizmchaqixrbf0mle2w06azpyhyq9lcgsjxsdfl0qlqlox');
define('SECURE_AUTH_KEY',  'wrycza9tz14qwnwnfwdd7esihk8fcklexwi93k4xrjkvn5apniwx7qurzfitwycm');
define('LOGGED_IN_KEY',    'iwjaats88kzcz8op9pvnixwrsofeyys4jl8wimuix5b5k3gdjxpvhogmmsuiyzl7');
define('NONCE_KEY',        'tgzvo3xgsz28yatoqik0puimkkecjc6iidmbggto2htdghai3tsbognb0zuiryds');
define('AUTH_SALT',        'mppcuxojegq5zh88uazh8kz4ze2phcxfndnezsel3d3toek9m61twlrtyruvafik');
define('SECURE_AUTH_SALT', '8rhzgmckgmpuenokksr7apdxelusvriac0xcqt6yp7tdflxp3jligbrnsgfats4x');
define('LOGGED_IN_SALT',   'sc0nmvwoglihjk6rlnjenroie3dtlos6d9vasqve1opv0jfk0ljl3mpzhufugjif');
define('NONCE_SALT',       '0vipjlrx81ty6izjvwicbzmovymwycwlygsdwonr8akmzx1ppmomwnvsyy3th3ys');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpuv_';

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
