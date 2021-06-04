

<?php
	//đoạn config này trên svr
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
	define( 'DB_NAME', 'admin_work' );

	/** MySQL database username */
	define( 'DB_USER', 'admin_work' );

	/** MySQL database password */
	define( 'DB_PASSWORD', 'asrkpvg7' );

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
	define( 'AUTH_KEY',         'wc#]|T%N9*_~zi]3x![a#ahpy@ho~S-_C r -3n+U>=chqIL)GC}M}1_e/6Y<BbX' );
	define( 'SECURE_AUTH_KEY',  '5rc21Oq22*+!Im5q&K?!e8)n}gp<:;Or8fi*J0qf4&H,1~hkNU~pYY+2MP;2cftd' );
	define( 'LOGGED_IN_KEY',    'i0A5gPa}@3]t0#sN!kZ.cr)@)u>0T?o1G]@=D,nE}hpu<D&R$#] nG~t{J5<ZL$<' );
	define( 'NONCE_KEY',        '#^LuZ.va^>LZznB5V//spyR?!x $8P1@OjYN^|k_)8F}dNY8t!JDwj8(+`j41lBO' );
	define( 'AUTH_SALT',        'TtoS=L+f;ygYlN2J,?*{#UWIqKg.p**,X}NeNhyS;.[KkN-N8#xrV=L68L)J{Ft4' );
	define( 'SECURE_AUTH_SALT', 'O6)!T5f&mWO75F_@Ia5cDSCRBQwtpr_~7Cxu981!iF*cF3=Gjw3<?eQg)6yny= N' );
	define( 'LOGGED_IN_SALT',   '9<x,.%q;R*-$NED;M4`n@d6a7A$bz`c$dC&.(Z]zs{@:S3E5`W]1Kuf2LUt2{.70' );
	define( 'NONCE_SALT',       'W.*QvRZ&a(^pU{$9YMpsYSs&if+}G-wv7CQgfaFXw1Hyg#/se<,%7_V#ltBPAR5;' );

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
?>



<?php
	// Đoạn code này trên local host đức anh 
	// /**
	//  * The base configuration for WordPress
	//  *
	//  * The wp-config.php creation script uses this file during the
	//  * installation. You don't have to use the web site, you can
	//  * copy this file to "wp-config.php" and fill in the values.
	//  *
	//  * This file contains the following configurations:
	//  *
	//  * * MySQL settings
	//  * * Secret keys
	//  * * Database table prefix
	//  * * ABSPATH
	//  *
	//  * @link https://codex.wordpress.org/Editing_wp-config.php
	//  *
	//  * @package WordPress
	//  */

	// // ** MySQL settings - You can get this info from your web host ** //
	// /** The name of the database for WordPress */
	// define( 'DB_NAME', 'local' );

	// /** MySQL database username */
	// define( 'DB_USER', 'root' );

	// /** MySQL database password */
	// define( 'DB_PASSWORD', 'root' );

	// /** MySQL hostname */
	// define( 'DB_HOST', 'localhost' );

	// /** Database Charset to use in creating database tables. */
	// define( 'DB_CHARSET', 'utf8' );

	// /** The Database Collate type. Don't change this if in doubt. */
	// define( 'DB_COLLATE', '' );

	// /**
	//  * Authentication Unique Keys and Salts.
	//  *
	//  * Change these to different unique phrases!
	//  * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
	//  * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
	//  *
	//  * @since 2.6.0
	//  */
	// define('AUTH_KEY',         '5jGwm15K09o58cEWedhCjiP/B+h+IOhrPeGdLtwdE+L6O6MOhn6n9Sd5Xircx0UKZY+hf5P5Nq/H9ao0EbXT9Q==');
	// define('SECURE_AUTH_KEY',  'FP8rImn4/dXhNOonaoRg9sSs7PZd+M4mL2MjW82i+TqoZYf0Ep0uTpVc1trg82HsWWf/qmnF1kwcq0pSSr2j1w==');
	// define('LOGGED_IN_KEY',    'u3plwgyvn5CuYzMkkjHo4e5lzdBGtkBPGIJmsrd2RU4baZQJMAROjNkaT8ovgepF2GSNoFFx4qq3wkyZA3s9og==');
	// define('NONCE_KEY',        'rI6XkVQCQ7KHz5ZH/37sSgeyGZOrAclvjpF2mA7qXVcd8Zo3BJaVF5iJ2AZJl0S5Guht2tSi6+3HW19k1Fvv7Q==');
	// define('AUTH_SALT',        'RKnWAyzMnd1rBu1Zt8kmYo1Rx0ZYQgOIYXLd5A7GwTvkX4ieRXusHcYwZzgNPNovVxG0c56U/eSReW/hCbUakw==');
	// define('SECURE_AUTH_SALT', 'nCfxtnb0nIlJ3tVv2tjOIhtsupGHjKoqrDWGNTZ4wsYBeEKGxCSiTS8xksTia2PQa2W5EM5r5gtev6+YRJlPKA==');
	// define('LOGGED_IN_SALT',   'kORkEvk7kAOSlHfSmeULqNVw0r5Gq5btZbz+hV7gm7cYsvAXxUKzcL3Xhq63V4Qo8zdUFU+I8O1ds2t4c8eqzA==');
	// define('NONCE_SALT',       'zZ8i8yc8u9x7quDgKkWOzletzaiR36Lc76jr+v+N3ULs255pzbMvyKaneOlt3HUxDCIbATVGeF0VnCJiRuKGdw==');

	// /**
	//  * WordPress Database Table prefix.
	//  *
	//  * You can have multiple installations in one database if you give each
	//  * a unique prefix. Only numbers, letters, and underscores please!
	//  */
	// $table_prefix = 'wp_';




	// /* That's all, stop editing! Happy publishing. */

	// /** Absolute path to the WordPress directory. */
	// if ( ! defined( 'ABSPATH' ) ) {
	// 	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
	// }

	// /** Sets up WordPress vars and included files. */
	// require_once ABSPATH . 'wp-settings.php';
?>