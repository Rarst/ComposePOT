<?php

namespace Rarst\ComposePOT;

/**
 * Reads the contents of the file in the beginning.
 */
class POMO_CachedFileReader extends POMO_StringReader {

	/**
	 * @param string $filename
	 */
	function __construct( $filename ) {
		parent::__construct();
		$this->_str = file_get_contents( $filename );
		if ( false === $this->_str ) {
			return;
		}
		$this->_pos = 0;
	}
}

/**
 * Reads the contents of the file in the beginning.
 */
class POMO_CachedIntFileReader extends POMO_CachedFileReader {

	/**
	 * @param string $filename
	 */
	function __construct( $filename ) {
		parent::__construct( $filename );
	}
}