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
	 * Key that extracted data will be saved to
	 */
	private $options_key = 'jetpack-search-meta0';

	/**
	 * Hard-coded keys, @TODO update later on
	 */
	public $test_keys = array( 'investigator_title', 'investigator_meta', 'investigator_project' );

	/**
	 * Test other keys array
	 */
	public $other_keys = array();

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'updated_post_meta', array( $this, 'jpsextractor_maybe_require_search_extraction' ), 10, 4 );
		add_action( 'added_post_meta', array( $this, 'jpsextractor_maybe_require_search_extraction' ), 10, 4 );
		add_action( 'deleted_post_meta', array( $this, 'jpsextractor_maybe_require_search_extraction' ), 10, 4 );
		add_action( 'shutdown', array( $this, 'jpsextractor_extract_searchable_content' ) );
	}

	/**
	 * Determines if extraction is required
	 */
	public function jpsextractor_maybe_require_search_extraction( $meta_id, $post_id, $meta_key, $meta_value ) {

		if ( ! in_array( $meta_key, $this->test_keys, true ) ) { // @TODO where should these keys be stored?
			return;
		}

		if ( ! in_array( $post_id, $this->other_keys, true ) ) {
			$this->other_keys[] = $post_id;
		}
	}

	/**
	 * Extracts post meta
	 */
	public function jpsextractor_extract_searchable_content() {

		if ( empty( $this->other_keys ) ) {
			return;
		}

		foreach ( $this->other_keys as $post_id ) {
			// grab all postmeta containing content.
			// extract into a string - @TODO build a couple handlers for this depending on data type.
			update_post_meta( $post_id, 'jpsearchextractor_fields', 'TESTING' );
		}
	}
}
