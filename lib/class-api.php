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
class API {

    /**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'rest_api_init', function () {
			register_rest_route( 'jpsearchextractor/v1', '/page/(?P<id>\d+)', array(
			  'methods' => 'GET',
			  'callback' => array( $this, 'get_meta'),
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


}