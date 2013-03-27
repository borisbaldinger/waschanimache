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
define('DB_NAME', 'spambo1_waschanimache');

/** MySQL database username */
define('DB_USER', 'spambo1_boris');

/** MySQL database password */
define('DB_PASSWORD', '12Amaee!');

/** MySQL hostname */
define('DB_HOST', 'spambo1.mysql.db.internal');

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
define('AUTH_KEY',         '0WvS`aX[ey:sEHh=GjVN#4f{%|HqUBG@}0tI1F`ZyhsICf;/U0c0.cg4A0#Oo&dg');
define('SECURE_AUTH_KEY',  'k*1-U#Lw+4Ax=F>q]kO}}UN,!Z$&k<eJA=7(,iXQ6c`:3B|&S^Tra;9WL [EF?Eg');
define('LOGGED_IN_KEY',    'hw263XfrUf0I]pSPq;}nfw3My*Q9hP[BQ:|.Xy|{5DaT{FHD,AhsUBp0.G$L~|t_');
define('NONCE_KEY',        'PT-kC/Q{)_k8[:sx0@E5/_E8eZ-Sba,Z>2-(L4TZq3?TnDG:#Jq)SOMjIq:KReNW');
define('AUTH_SALT',        'lR`+&Gh]v3UvI=&Zoy v6l[_?WF;rg-,n.aM<`F6xI]{I;im8w&jp(@$?&5^s-|c');
define('SECURE_AUTH_SALT', 'm]2cz^^ NXPSYk|arlLi@~@-GCD9ClgU]K/OB>iZ~Lo4=r=@oSH*A?fD?IloJdG-');
define('LOGGED_IN_SALT',   'mn$ >28xpcwYGAC]ae**pE2+SM%O@[|q|=~_|^GugSjNJ558I<~h<2D@-fgHH0,_');
define('NONCE_SALT',       'jGA5l0cDderM=* ;&96TN3CZ~b[]=Srq3{|1T`i;Yrvv:L.]DUaRMNOzR)O@ShU*');

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
