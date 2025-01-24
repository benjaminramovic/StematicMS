<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'stem' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3307' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'awX<%=h.0hw}SRU/>`o4 `dBq;#U-(@VIs]dCn{6BF5xFF_E!GRjU92@^w}d1#uA' );
define( 'SECURE_AUTH_KEY',  'Y-9NVI$aq:oOeVazFtl&OZh(9`9Z|%q2Rw=tc@jA^L<3M3!fNMfZ-G8J(=O7FXz_' );
define( 'LOGGED_IN_KEY',    ')!:8C+v_(UPjeMl{~@Y}1S~L6dF+k}n?Y87sN.@taU4K$#4kQPv<|Z#L%:8!K3,N' );
define( 'NONCE_KEY',        '0O0oD0~f *A(QNErB6Lu&sd;<VwnH=N3Rkj-RM1k)C-G&3j2_*(l7+?HFtHB=87H' );
define( 'AUTH_SALT',        '.Mu4(T*p+R$I%?42B$#xc|2}U|Xfm]f%`qdF1:,LW|3QRGO^x4S^VviG23qzv6x_' );
define( 'SECURE_AUTH_SALT', '0XrBGfC58DB]PJmJzB,XE/~=}Qw#(w?AP&&CR[^@eT?_8K%}=VO|yp7n{D;%%8C4' );
define( 'LOGGED_IN_SALT',   'P$>a7i#pXq&tH:$S]y}i>E<2fMCI{[ScrO:LOQ^+D+|U%~ilGsSFuDNEPls_}NsU' );
define( 'NONCE_SALT',       'HwwqC;](B2R}[$PUL9)3V21&Ka}m_}C11>iPh?=I3t +nA@` s9rlz.r(/*aY.)i' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
