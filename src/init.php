<?php


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


//function clp_dynamic_render_callback( $attr, $content ) {
//	if ( ! is_admin() ) :
//		echo '<pre>';
//		var_dump( $attr );
//		echo '</pre>';

//		echo '<pre>';
//		var_dump( $content , JSON_PRETTY_PRINT );
//		echo '</pre>';

//		return sprintf( '<div class="bound">%s</div>' ,$content);
//	endif;
//}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function clpp_block_assets() { // phpcs:ignore

	// Register block styles for both frontend + backend.
	wp_register_style(
		'clpp_style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.min.css', dirname( __FILE__ ) ), // Block style CSS.
		[ 'wp-editor' ], // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.min.css' ) // Version: File modification time.
	);

	wp_register_style(
		'clpp_style-css-temp', // Handle.
		plugins_url( 'src/block/style.css', dirname( __FILE__ ) ), // Block style CSS.
		[ 'wp-editor' ], // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __DIR__ ) . 'src/block/style.css' ) // Version: File modification time.
	);

	// Register block editor script for backend.
	wp_register_script(
		'clpp_block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		[ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ], // Dependencies, defined above.
		null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'clpp_editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		[ 'wp-edit-blocks' ], // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'clpp_block-js',
		'cgbGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add more data here that you want to access from `cgbGlobal` object.
		]
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	register_block_type(
		'clpp/custom-list-plus', [
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'           => 'clpp_style-css',
//			'style'           => 'clpp_style-css-temp',
			// Enqueue blocks.build.js in the editor only.
			'editor_script'   => 'clpp_block-js',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'    => 'clpp_editor-css',
			// Enqueue callback
//			'render_callback' => 'clpp_dynamic_render_callback',

		]
	);

	//wp_enqueue_style('custom_list_plus',plugin_dir_path( __DIR__ ).'block.style.css');
}

// Hook: Block assets.
add_action( 'init', 'clpp_block_assets' );
