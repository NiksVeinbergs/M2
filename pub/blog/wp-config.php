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
define('DB_NAME', 'stagingm2blog');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'option123');

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
define('AUTH_KEY',         '$vCT#B6g?]{i>: HP)Lm(LCAd](L^JS-YPzV-W]K:iZuDBDiue>v?.kw$j4|:~65');
define('SECURE_AUTH_KEY',  'q[[7uHKtN%^QOx :<LaWUTZ1G,o8Z:9-E:J85T(*xx8rkU>VPsFr*y!,Dwtz;Kiz');
define('LOGGED_IN_KEY',    ',F??VCum4#/0y9&RX!S+3q8yVagI_lv!;msdV{2I?l% r^3t|O#@F&7*E;fz7r0W');
define('NONCE_KEY',        '|Q@oVGr(O#VwI35WZ }nLqkHZLO6j9.h}6N`QVt%v?_[6zq$RqfYH XO0qk[AyCl');
define('AUTH_SALT',        '#%>+_R-&vF=sO`cR[R?4YTw2ZH&g=b=CRsOI@DUuKE!9P$&ZGI243pwV)]1XBUaQ');
define('SECURE_AUTH_SALT', 'DN/W/MbvldE/fyG,d6!Jrdw*9nZ9E6xGPCVA#_W`9&XTW~YAq4<;L-xV(kyHyE~p');
define('LOGGED_IN_SALT',   'P66AVMn%uL3mH-m;3z)ePMUX0}8wttT{|xX=yYi5R. 2 8>!!P0<^vV Y<U)jBCZ');
define('NONCE_SALT',       '(;ZVaNfUeIQa%_<V@c :eaHjNih`)v{uAfs%/gkfYpQ4g)MCHtpN8M0OsxMxzyvz');

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
ini_set('display_errors','Off');
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
        define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define('WP_HOME','/news');
define('WP_SITEURL','/blog');
