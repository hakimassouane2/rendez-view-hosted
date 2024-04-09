<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'rendezn286' );

/** Database username */
define( 'DB_USER', 'rendezn286' );

/** Database password */
define( 'DB_PASSWORD', 'Hakimleboss93' );

/** Database hostname */
define( 'DB_HOST', 'rendezn286.mysql.db' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'tc^u?~DN;:6uVgKJ3wBh<nztnnJoguqA gVV907{)@*vyTBQuA*[#/8KF6N_P@E&' );
define( 'SECURE_AUTH_KEY',   '[K+Mi 6MF/l&SDRpMN-3;e^{5Z&yj:cz pkS8[/X&~u}oKrHlF`GO5d=co0OqQef' );
define( 'LOGGED_IN_KEY',     '`<hQ6xXoLZ59_/7S<eI>gYsL<1qXoj2!:PuI)$9?`_/#~7Q8>d3$MsP}3aN]N{4X' );
define( 'NONCE_KEY',         '8#h)y%Rd6S!*XH38Y5p]8?yrY7n#rnvhY*?;8D~VQB^oQ)a4CznD/=Q9_7mAPuGV' );
define( 'AUTH_SALT',         '8Ra2Bs;[9AMcpQ^IVQ(O8~UO>MyaB;jMzs;uk1i0Ax26Dpf;MZQnw:sFK/=$Nd;5' );
define( 'SECURE_AUTH_SALT',  'D@&idk{a_sz%XdI?Vgrci6UJ0XQ7PSCst,(}NQZWQaj/.ZwNnkFs{ms181D R6_T' );
define( 'LOGGED_IN_SALT',    'bIFH0fuE&IE,^z$zx5b88xuJB/sy#:IdUKyW-V#B*PC<o5<V_k:E.c%KF)^BzI.`' );
define( 'NONCE_SALT',        'l2K3V<}C0`3Q+or1Wew1=6#k:8fd{#1 g|OTfm^IMsAo)=ALT O=zf<CKKx/c5-O' );
define( 'WP_CACHE_KEY_SALT', 'Vp$)wIkP_;D^UczGtA1,>$hp8mPl28<y+aZfpuXKu#@TI@GN{_`kQArZ AGW:rt+' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
