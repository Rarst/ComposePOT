<?php

namespace Rarst\ComposePOT;

/**
 * Adds textdomain argument to all i18n function calls.
 */
class AddTextdomain {

	var $modified_contents = '';
	var $funcs;

	/**
	 * Sets up MakePOT instance and rules.
	 */
	function __construct() {
		$makepot     = new MakePOT;
		$this->funcs = array_keys( $makepot->rules );
	}

	/**
	 * @deprecated
	 */
	function usage() {
		$usage = "Usage: php add-textdomain.php [-i] <domain> <file>\n\nAdds the string <domain> as a last argument to all i18n function calls in <file>\nand prints the modified php file on standard output.\n\nOptions:\n    -i    Modifies the PHP file in place, instead of printing it to standard output.\n";
		fwrite( STDERR, $usage );
		exit( 1 );
	}

	/**
	 * @param string $token_text
	 * @param bool   $inplace
	 */
	function process_token( $token_text, $inplace ) {
		if ( $inplace ) {
			$this->modified_contents .= $token_text;
		} else {
			echo $token_text;
		}
	}

	/**
	 * @param string $domain
	 * @param string $source_filename
	 * @param bool   $inplace
	 */
	function process_file( $domain, $source_filename, $inplace ) {

		$this->modified_contents = '';
		$domain                  = addslashes( $domain );

		$source = file_get_contents( $source_filename );
		$tokens = token_get_all( $source );

		$in_func        = false;
		$args_started   = false;
		$parens_balance = 0;
		$found_domain   = false;

		foreach ( $tokens as $token ) {
			$string_success = false;
			if ( is_array( $token ) ) {
				list( $id, $text ) = $token;
				if ( T_STRING == $id && in_array( $text, $this->funcs ) ) {
					$in_func        = true;
					$parens_balance = 0;
					$args_started   = false;
					$found_domain   = false;
				} elseif ( T_CONSTANT_ENCAPSED_STRING == $id && ( "'$domain'" == $text || "\"$domain\"" == $text ) ) {
					if ( $in_func && $args_started ) {
						$found_domain = true;
					}
				}
				$token = $text;
			} elseif ( '(' == $token ) {
				$args_started = true;
				++$parens_balance;
			} elseif ( ')' == $token ) {
				--$parens_balance;
				if ( $in_func && 0 == $parens_balance ) {
					$token        = $found_domain ? ')' : ", '$domain')";
					$in_func      = false;
					$args_started = false;
					$found_domain = false;
				}
			}
			$this->process_token( $token, $inplace );
		}

		if ( $inplace ) {
			$f = fopen( $source_filename, 'w' );
			fwrite( $f, $this->modified_contents );
			fclose( $f );
		}
	}
}
