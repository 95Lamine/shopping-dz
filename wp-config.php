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
define('DB_NAME', 'shop');

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
define('AUTH_KEY',         'RvoMux$jm*Y}21xLU8 ,0sS=VU$Lk ,m_L{&oQ@,8u0^4I^(IA{,Sj+t>9M=wF3#');
define('SECURE_AUTH_KEY',  'tnr4=<z-G5VwDr+IALw!&zT!pN[JAd!StBI<>NTg}Xjdox?>`aq_U[1na1T;gN&g');
define('LOGGED_IN_KEY',    'jCI)8vX*3 6,z$W!v47uHlbcg;xtr&d{!70PVe;E^}9q=.q-9I/VTf8UnNT@@=RR');
define('NONCE_KEY',        ' geLT{y]4yaUHB?!Xe@r*Q,m`<c83|}q%PF 3[#@V&u9%1J+Q6x/f5HGYMx37kvR');
define('AUTH_SALT',        'W|$=1}t4y.!b;g%KZx-jh6Ncnh/YxWwU({p^cyANDeb@0&AzQYqdpNO<J;O#$mnF');
define('SECURE_AUTH_SALT', '2xXdqYN*Q&S1@F,#tja><v;?$C&S!VLYM]?th&9!q:[X7WH*;n2UuODtgmG#Ws<n');
define('LOGGED_IN_SALT',   '9*61wFL;<CvO>X?@a:a)?FWS%>94FmyB}qKtmd:&@>5Z+b#qFT@g[(K1;*fnc`Ga');
define('NONCE_SALT',       'p;a6Pd6bthq{Sn;u+Tk [3Rw(p~w@<d2t}R9S#iXV6i/:#n+cl!`.4m~1OL]$4?X');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'sh_';

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
