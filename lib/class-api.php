<?php
/**
 *
 * Extracts data on update, save, and delete
 *
 * @package JPSearchExtractor
 */

namespace JPSearchExtractor\API;

/**
 * Class Extractor
 */
class API { // @TODO add authentication so searches can't be overriden

    /**
	 * Constructor
	 */
	public function __construct() {
		// handler for returning meta
		add_action( 'rest_api_init', function () {
			register_rest_route( 'jpsearchextractor/v1', '/page/(?P<id>\d+)', array(
			  'methods' => 'GET',
			  'callback' => array( $this, 'get_meta'),
			) );
		  } );

		  // post handler for saving meta
		  add_action( 'rest_api_init', function () {
			register_rest_route( 'jpsearchextractor/v1', '/meta/(?P<id>\d+)', array( // this is the page ID to update
			  'methods' => 'POST',
			  'callback' => array($this, 'process_fields'),
			) );
		  } );
		  
	}
	

	public function get_meta(){
		$postypes_to_exclude = ['acf-field-group','acf-field'];
		$extra_postypes_to_include = ["page"];
		$post_types = array_diff(get_post_types(["_builtin" => false], 'names'),$postypes_to_exclude);
	
		array_push($post_types, $extra_postypes_to_include);
	
		foreach ($post_types as $post_type) {
			register_rest_field( $post_type, 'ACF', [
				'get_callback'    => array($this, 'expose_ACF_fields'),
				'schema'          => null,
		   ]
		 );
		}
	}

	public function expose_ACF_fields( $object ) {
		$ID = $object['id'];
		return get_fields($ID);
	}

	/**
	 * @TODO move to util, 
	 */
	function starts_with ($string, $startString) { 
		$len = strlen($startString); 
		return (substr($string, 0, $len) === $startString); 
	} 
  


	/**
	 * this should have the field info 
	 */
	public function process_fields($object) {
		$page_id = $object['id'];
		$meta_fields = $object['fields']; 

		$res = get_post_meta($object['id']);

		$final = '';

		$keys = [];

		// @TODO find a better way to get these objects
		foreach($meta_fields as $key => $value){
			$search = $value;
			$search_length = strlen($search);
			foreach ($res as $key2 => $value2) {
				if (substr($key2, 0, $search_length) == $search) { // match
					array_push($keys, $key2);
				}
			}
		}

		// now get all data from matching keys
		foreach ($keys as $key => $value) {
			$test = implode($res[$value]);
			if($test){
				$final .= strip_tags(preg_replace('/{(.*?)}/', '', $test));
			}
		}

		
		return $final;
		// @TODO maybe keep track if addition fails
		update_post_meta($page_id, 'jpsearchextractor_fields', $object['fields']);

		// add this string to key: jetpack-search-meta0 @TODO maybe determine if meta should beheld differently
		if(update_post_meta($page_id, 'jetpack-search-meta0', $final) == false){
			return array("response" => 400);
		}
		return array("response" => 200);  // @TODO -> these need real API responsess
	}


}