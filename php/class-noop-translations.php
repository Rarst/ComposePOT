<?php

namespace Rarst\ComposePOT;

/**
 * Provides the same interface as Translations, but doesn't do anything
 */
class NOOP_Translations {
	var $entries = array();
	var $headers = array();

	/**
	 * @param $entry
	 *
	 * @return bool
	 */
	function add_entry( $entry ) {
		return true;
	}

	/**
	 * @param $header
	 * @param $value
	 */
	function set_header( $header, $value ) {
	}

	/**
	 * @param $headers
	 */
	function set_headers( $headers ) {
	}

	/**
	 * @param $header
	 *
	 * @return bool
	 */
	function get_header( $header ) {
		return false;
	}

	/**
	 * @param $entry
	 *
	 * @return bool
	 */
	function translate_entry( &$entry ) {
		return false;
	}

	/**
	 * @param string      $singular
	 * @param null|string $context
	 *
	 * @return mixed
	 */
	function translate( $singular, $context = null ) {
		return $singular;
	}

	/**
	 * @param int $count
	 *
	 * @return int
	 */
	function select_plural_form( $count ) {
		return 1 == $count ? 0 : 1;
	}

	/**
	 * @return int
	 */
	function get_plural_forms_count() {
		return 2;
	}

	/**
	 * @param string      $singular
	 * @param string      $plural
	 * @param int         $count
	 * @param null|string $context
	 *
	 * @return mixed
	 */
	function translate_plural( $singular, $plural, $count, $context = null ) {
		return 1 == $count ? $singular : $plural;
	}

	/**
	 * @param $other
	 */
	function merge_with( &$other ) {
	}
}