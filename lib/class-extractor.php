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
	 *
	 * @var string
	 */
	private $options_key = 'jetpack-search-meta0';

	/**
	 * Hard-coded keys, @TODO update later on
	 *
	 * @var array
	 */
	public $test_keys = array( 'investigator_title', 'investigator_meta', 'investigator_project' );

	/**
	 * Default field for storing searchable field names
	 *
	 * @var string
	 */
	private $extractor_field = 'jpsextractor_searchable_field_ids';

	/**
	 * Test other keys array
	 *
	 * @var array
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

	/**
	 * Extract arrays
	 */
	private function jpsextractor_extract_array( $object ) {
		$res = get_post_meta( $object['id'] );

		$page_id     = $object['id'];
		$meta_fields = $object['fields'];

		$final = '';

		$keys = array();

		// @TODO find a better way to get these objects
		foreach ( $meta_fields as $key => $value ) {
			$search        = $value;
			$search_length = strlen( $search );
			foreach ( $res as $key2 => $value2 ) {
				if ( substr( $key2, 0, $search_length ) == $search ) { // match
					array_push( $keys, $key2 );
				}
			}
		}

		// now get all data from matching keys.
		foreach ( $keys as $key => $value ) {
			$test = implode( $res[ $value ] );
			if ( $test ) {
				$final .= wp_strip_all_tags( preg_replace( '/{(.*?)}/', '', $test ) );
			}
		}

		return $final;
		// @TODO maybe keep track if addition fails
		update_post_meta( $page_id, 'jpsearchextractor_fields', $object['fields'] );

		// add this string to key: jetpack-search-meta0 @TODO maybe determine if meta should beheld differently.
		if ( update_post_meta( $page_id, 'jetpack-search-meta0', $final ) == false ) {
			return array( 'response' => 400 );
		}
		return array( 'response' => 200 );  // @TODO -> these need real API responsess
	}
}
