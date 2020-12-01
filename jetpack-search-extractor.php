<?php
/**
 * Plugin Name: Jetpack Search Extractor
 * Description: Extract any post meta into searchable fields
 * Version: 0.0.1
 * Author: Jake Ols
 * Author URI: https://ols.engineer
 *
 * @package JPSearchExtractor
 */

require_once __DIR__ . '/lib/class-extractor.php';
require_once __DIR__ . '/lib/class-utilities.php';
require_once __DIR__ . '/lib/class-api.php';
require_once __DIR__ . '/admin/options.php';

/**
 * Exposes ACF fields to rest API, @TODO cleanup and move to api class.
 */
function create_acf_meta_in_rest() {
	$postypes_to_exclude       = array( 'acf-field-group', 'acf-field' );
	$extra_postypes_to_include = array( 'page' );
	$post_types                = array_diff( get_post_types( array( '_builtin' => false ), 'names' ), $postypes_to_exclude );

	array_push( $post_types, $extra_postypes_to_include );

	foreach ( $post_types as $post_type ) {
		register_rest_field(
			$post_type,
			'ACF',
			array(
				'get_callback' => 'expose_acf_fields',
				'schema'       => null,
			)
		);
	}

}

/**
 * Expose ACF Fields
 */
function expose_acf_fields( $object ) {
	$object_id = $object['id'];
	return get_fields( $object_id );
}

add_action( 'rest_api_init', 'create_acf_meta_in_rest' );

// create new API class.
new JPSearchExtractor\API\API();

// create new extractor class.
new JPSearchExtractor\Extractor\Extractor();
