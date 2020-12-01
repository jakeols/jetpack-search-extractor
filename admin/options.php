<?php
add_action(
	'admin_enqueue_scripts',
	function ( $hook ) {
		// only load scripts on dashboard
		if ( 'settings_page_jp-search-extractor' !== $hook ) {
			return;
		}
		// @TODO this is pointing to a docker container, should be changed
		if ( isset( $_SERVER['REMOTE_ADDR'] ) && ( '192.168.50.1' === $_SERVER['REMOTE_ADDR'] ) ) {
			// dynamic loading for preact in dev mode.
			$js_to_load = 'http://localhost:8080/bundle.js';
		} else {
			$js_to_load  = plugin_dir_url( __FILE__ ) . 'js/build/bundle.js'; // @TODO this needs to be set in preact config
			$css_to_load = plugin_dir_url( __FILE__ ) . ''; // @TODO ^.
		}
		wp_enqueue_style( 'jp_search_extractor_css', $css_to_load );
		wp_register_script( 'jp_search_extractor_js', $js_to_load, array(), false, false ); // version should be defined.
		wp_localize_script(
			'jp_search_extractor_js',
			'wpApiSettings',
			array(
				'root'  => esc_url_raw( rest_url() ),
				'nonce' => wp_create_nonce( 'wp_rest' ),
			)
		);

		wp_enqueue_script( 'jp_search_extractor_js', $js_to_load, '', false, true ); // version should be defined.
	}
);

/**
 * Adds options page
 */
function jpsextractor_register_options_page() {
	add_options_page( 'Jetpack Search Extractor Settings', 'JP Search Extractor', 'manage_network_options', 'jp-search-extractor', 'jpsextractor_option_page' );
}

add_action( 'admin_menu', 'jpsextractor_register_options_page' );

/**
 * Adds root preact div
 */
function jpsextractor_option_page() { ?>
<!-- div that preact will use  -->
<div id="jpsextractor-preact-app"></div>
<?php } ?>
