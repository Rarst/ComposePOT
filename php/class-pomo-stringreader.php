<?php

namespace Rarst\ComposePOT;

/**
 * Provides file-like methods for manipulating a string instead of a physical file.
 */
class POMO_StringReader extends POMO_Reader {

	var $_str = '';

	/**
	 * @param string $str
	 */
	function __construct( $str = '' ) {
		parent::__construct();
		$this->_str = $str;
		$this->_pos = 0;
	}

	/**
	 * @param int $bytes
	 *
	 * @return string
	 */
	function read( $bytes ) {
		$data = $this->substr( $this->_str, $this->_pos, $bytes );
		$this->_pos += $bytes;
		if ( $this->strlen( $this->_str ) < $this->_pos ) {
			$this->_pos = $this->strlen( $this->_str );
		}

		return $data;
	}

	/**
	 * @param int $pos
	 *
	 * @return int
	 */
	function seekto( $pos ) {
		$this->_pos = $pos;
		if ( $this->strlen( $this->_str ) < $this->_pos ) {
			$this->_pos = $this->strlen( $this->_str );
		}

		return $this->_pos;
	}

	/**
	 * @return int
	 */
	function length() {
		return $this->strlen( $this->_str );
	}

	/**
	 * @return string
	 */
	function read_all() {
		return $this->substr( $this->_str, $this->_pos, $this->strlen( $this->_str ) );
	}

}