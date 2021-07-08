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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress-practical-tatvasoft' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '*aeBGPH#QWxRk0nb&Ope008zIiw#2@Fd=*dg.w!hcl6LM1sd*]o>)q@7UD/%GaeJ' );
define( 'SECURE_AUTH_KEY',  '9wN_Y@l(`}5gcoT/J{8g~$#j@/%xA{],28<)m%*.a]P9~9xukmw1;.[DRq)}8@ K' );
define( 'LOGGED_IN_KEY',    'iM(B2&Nu2)P-[.PZ RD`0h!}!ELy{Z&p.o<k:XEsJ^l&:cEa?`o8f;pWKJ_H-#-?' );
define( 'NONCE_KEY',        ')(8@ 6hM-ZE`4`a]<<K%H-Qc^D[Z`tVc&M]SI4@Wnys$Jh!sGLxp4E|YdLc>ga`:' );
define( 'AUTH_SALT',        ']W[bDA)j_s,uu4TwuX@Q+<F;}c0W86~k3[Pua]z;,#8f5~&%Nf/5cqQ?PindC@?m' );
define( 'SECURE_AUTH_SALT', 'dhXt8~#_P+hgt6YD59Ol-h|[oK703T;` 9w(n,v,jT{f!pxgH9317~G@h<~pXB*d' );
define( 'LOGGED_IN_SALT',   '31%M2p&hkG%F)Q-mP+QdGNZ&W%w@a#?Wg6MR2N[Oot={=Vw*,|<x*L!O&`kY<D%Y' );
define( 'NONCE_SALT',       'Y}cIdM5.}pV4U>%rywaCGfM!kMz0s_|ii;g-Arr_eUPOV!V!LpGSyMGtWMH#<RvC' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
