<?php
add_action('admin_enqueue_scripts', function ($hook) {
  // only load scripts on dashboard
  if ($hook != 'settings_page_jp-search-extractor') {
    return;
  }
   // @TODO this is pointing to a docker container, should be changed 
  if ($_SERVER['REMOTE_ADDR'] == '192.168.50.1') {
    // dynamic loading for preact in dev mode
    $js_to_load = 'http://localhost:8080/bundle.js';
  } else {
    $js_to_load = plugin_dir_url( __FILE__ ) . 'js/build/bundle.js'; // @TODO this needs to be set in preact config 
    $css_to_load = plugin_dir_url( __FILE__ ) . ''; // @TODO ^
  }
  wp_enqueue_style('jp_search_extractor_css', $css_to_load);
  wp_enqueue_script('jp_search_extractor_js', $js_to_load, '', mt_rand(10,1000), true);
});

function jpsextractor_register_options_page() {
	add_options_page( 'Jetpack Search Extractor Settings', 'JP Search Extractor', 'manage_network_options', 'jp-search-extractor', 'jpsextractor_option_page' );
}

add_action( 'admin_menu', 'jpsextractor_register_options_page' );

function jpsextractor_option_page() { ?>
  <!-- div that preact will use  -->
  <div id="jpsextractor-preact-app"></div>
<?php } ?>