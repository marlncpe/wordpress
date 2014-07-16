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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'USUARIO');

/** MySQL database password */
define('DB_PASSWORD', 'CLAVE');

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
define('AUTH_KEY',         '{,gOwwe3&~y<vY+k^o[6UQs$~IPW:^6CjkDrF5PZiIq661-jrw-NIcDW[BdO=%Qu');
define('SECURE_AUTH_KEY',  'q+79&smp#~sQY,DIJ/ufVxttR?.k%H3WXi*q}-&poMHhBvstIP3uU3kK0nQ%H<H]');
define('LOGGED_IN_KEY',    'bwE-v 5+}CW+mE(%+UqS:j,B6I{.q@cGJ$hqZj0r?JZ SQCf`QeEIqA2Fbck+cPB');
define('NONCE_KEY',        'W%<=v>=BM+I;0Lw>)Ov27L)?<+QRCRA3u(OC-)!KTMf@2]{B|~;|_.N-V~x>}_sI');
define('AUTH_SALT',        '^~n#+8R~#|{v%:=UHZiRHhI>I,Q,vG(g~^5bmw4D<n+%?r0b*4%fb8y}W%b,fF)I');
define('SECURE_AUTH_SALT', '-#IqdCPvy?+3:r7B%b|MRV)uQr<^ziQ$J^XNj+D%N}q-*1B#9S1>7d;i.3)4Dg:a');
define('LOGGED_IN_SALT',   '!(Ig/!bl<6Kb+[C@2:V64)YU/QH;_gn5A)B7CXBJHbmokwf*=j@/p[;!=S:{L*~3');
define('NONCE_SALT',       'uLz2i7J#%hcg-8|@jT$<}1[1$`Y4`-LTM;|--$&%O_XKAHNHA25TqC`8ju-w5||e');

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
