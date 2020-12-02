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
	 * Default field for storing searchable field names
	 *
	 * @var string
	 */
	private $extractor_field = 'jpsextractor_searchable_field_ids';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action(
			'rest_api_init',
			function () {
				register_rest_route(
					'jpsearchextractor/v1',
					'/page/(?P<id>\d+)',
					array(
						'methods'  => 'GET',
						'callback' => array( $this, 'get_meta' ),
					)
				);
			}
		);

		add_action(
			'rest_api_init',
			function () {
				register_rest_route(
					'jpsearchextractor/v1',
					'/meta/(?P<id>\d+)',
					array( // this is the page ID to update.
						'methods'  => 'POST',
						'callback' => array( $this, 'process_fields' ),
					)
				);
			}
		);

	}

	/**
	 * Meta get route
	 */
	public function get_meta() {
		$postypes_to_exclude = array( 'acf-field-group', 'acf-field' );
		$post_types          = array_diff( get_post_types( array( '_builtin' => false ), 'names' ), $postypes_to_exclude );

		array_push( $post_types, array( 'page' ) );

		foreach ( $post_types as $post_type ) {
			register_rest_field(
				$post_type,
				'ACF',
				array(
					'get_callback' => array( $this, 'expose_acf_fields' ),
					'schema'       => null,
				)
			);
		}
	}

	/**
	 * Exposess acf fields
	 */
	public function expose_acf_fields( $object ) {
		return get_fields( $object['id'] );
	}

	/**
	 * This should save the list of post meta ID's from this post that should be searchable
	 * Saves the keys to jpsextractor_searchable_field_ids
	 */
	public function process_fields( $object ) {

		if ( false !== update_post_meta( $object['id'], $this->extractor_field, $object['fields'] ) ) {
			return new \WP_REST_Response( null, 200 );
		} else {
			return new \WP_REST_Response( null, 500 );
		}
	}


}
