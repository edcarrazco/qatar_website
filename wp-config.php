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
define  ('WPLANG', 'es_ES');

/** The name of the database for WordPress */
define('DB_NAME', 'db_qatar');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '_Jf<zf87{<q.2ZORUQJOM6G>=rayY]Fbl*oOYzMwEkLyvh1FRTz-z <u0n r/gH+');
define('SECURE_AUTH_KEY',  '_nSf_[k]x>5}+M3{ZugzU(zp]|XR&VU2KN`07L$T^~P_ztFWUyNe1v>G@E= ~]-K');
define('LOGGED_IN_KEY',    '!mhz:0=%a,?5+``A-8ync{;W.hEn5ucvr?FqM%bWNzf;[R?,wj5Y=]:.gpRH!`tg');
define('NONCE_KEY',        'y$%7SK|~q^Ov5M?=(@d/N%@u)@{+c0iK;j{K}(qBgHiMJH12*{!dUkmoOLT]MaY:');
define('AUTH_SALT',        'Noo(+</Fxo=hF},l@BsI,F<~K=}=e;HNg8[s785vp2Mi]dJnH&KA5.2(q8jyhWI(');
define('SECURE_AUTH_SALT', 'VEWb|?lJ/H`o/MHV!b;l3hyo*GOSx565pr6G5S|}By{KQVcUn0AS)Hl<Q4<H}7ed');
define('LOGGED_IN_SALT',   '?DeB4JOHBQoEHdN:F*D*+?e/DxW!WnDW%U21KW%(lOnyH=T&]&JfOAh0 5+LC4+:');
define('NONCE_SALT',       '|L~sIBRxT%]>AD/%j(6V,BK:|0tkwWX&b!b15(,SY&/<_^eoJ}FMX?Y0!Fu*^_JH');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
