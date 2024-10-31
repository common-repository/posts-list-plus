<?php
/**
 * Plugin Name: Custom List Plus
 * Description: Custom list controlled by Gutenberg framework
 * Author: Tom Goldberg
 * Author URI: https://www.goldbergtom.com
 * Version: 1.0.2
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct script access disallowed.' );
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';