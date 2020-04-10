<?php
/**
 *
 * Extracts data on update, save, and delete
 *
 * @package JPSearchExtractor
 */

namespace JPSearchExtractor\Extractor;

/**
 * Class Extractor
 */
class Extractor {



	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'updated_post_meta', array( $this, 'jpsextractor_maybe_require_search_extraction'), 10, 4 );
		add_action( 'added_post_meta', array( $this, 'jpsextractor_maybe_require_search_extraction'), 10, 4 );
		add_action( 'deleted_post_meta', array($this, 'jpsextractor_maybe_require_search_extraction'), 10, 4 );
		add_action( 'shutdown', array($this, 'jpsextractor_extract_searchable_content') );

	}

	// @TODO 
	function jpsextractor_maybe_require_search_extraction( $meta_id, $post_id, $meta_key, $meta_value ) {
		// fields kept in jpsearchextractor_fields
		

		if ( ! in_array( $meta_key, [ /* list of content keys go here */ ], true ) ) { // @TODO this keys should be grabbed from whats selected in dropdown
			return;
		}

		global $jpsextractor_require_search_extraction;
		if ( ! isset( $jpsextractor_require_search_extraction ) ) {
			$jpsextractor_require_search_extraction = [];
		}

		if ( ! in_array( $post_id, $jpsextractor_require_search_extraction, true ) ) {
			$jpsextractor_require_search_extraction[] = $post_id;
		}
	}

	function jpsextractor_extract_searchable_content() {
		global $jpsextractor_require_search_extraction;

		if ( empty( $jpsextractor_require_search_extraction ) ) {
			return;
		}

		foreach ( $jpsextractor_require_search_extraction as $post_id ) {
			// grab all postmeta containing content
			// extract into a string - @TODO build a couple handlers for this depending on data type
			// update_postmeta( ... )
		}
	}
	


}