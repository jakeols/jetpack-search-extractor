<?php
add_action('admin_enqueue_scripts', function ($hook) {
  // only load scripts on dashboard
  if ($hook != 'index.php') {
    return;
  }
   // @TODO this is pointing to a docker container, should be changed 
  if (in_array($_SERVER['REMOTE_ADDR'], array('10.255.0.2', '::1'))) {
    // dynamic loading for preact in dev mode
    $js_to_load = 'http://localhost:8080/static/js/bundle.js';
  } else {
    $js_to_load = plugin_dir_url( __FILE__ ) . ''; // @TODO this needs to be set in preact config 
    $css_to_load = plugin_dir_url( __FILE__ ) . ''; // @TODO ^
  }
  wp_enqueue_style('jp_search_extractor_css', $css_to_load);
  wp_enqueue_script('jp_search_extractor_js', $js_to_load, '', mt_rand(10,1000), true);
});