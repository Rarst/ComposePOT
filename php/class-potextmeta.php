<?php

namespace Rarst\ComposePOT;

/**
 * Adds metadata from a WordPress theme or plugin to POT file
 */
class PotExtMeta {

	var $headers = array(
		'Plugin Name',
		'Theme Name',
		'Plugin URI',
		'Theme URI',
		'Description',
		'Author',
		'Author URI',
		'Tags',
	);


	/**
	 * @deprecated
	 */
	function usage() {
		fwrite( STDERR, "Usage: php pot-ext-meta.php EXT POT\n" );
		fwrite( STDERR, "Adds metadata from a WordPress theme or plugin file EXT to POT file\n" );
		exit( 1 );
	}

	/**
	 * @param string $ext_filename
	 *
	 * @return string
	 */
	function load_from_file( $ext_filename ) {
		$source = MakePOT::get_first_lines( $ext_filename );
		$pot    = '';
		foreach ( $this->headers as $header ) {
			$string = MakePOT::get_addon_header( $header, $source );
			if ( ! $string ) {
				continue;
			}
			$args  = array(
				'singular'           => $string,
				'extracted_comments' => $header . ' of the plugin/theme',
			);
			$entry = new Translation_Entry( $args );
			$pot .= "\n" . PO::export_entry( $entry ) . "\n";
		}

		return $pot;
	}

	/**
	 * @param string     $ext_filename
	 * @param string     $pot_filename
	 * @param null|array $headers
	 *
	 * @return bool
	 */
	function append( $ext_filename, $pot_filename, $headers = null ) {
		if ( $headers ) {
			$this->headers = (array) $headers;
		}
		if ( is_dir( $ext_filename ) ) {
			$pot = implode( '', array_map( array( $this, 'load_from_file' ), glob( "$ext_filename/*.php" ) ) );
		} else {
			$pot = $this->load_from_file( $ext_filename );
		}
		$potf = '-' == $pot_filename ? STDOUT : fopen( $pot_filename, 'a' );
		if ( ! $potf ) {
			return false;
		}
		fwrite( $potf, $pot );
		if ( '-' != $pot_filename ) {
			fclose( $potf );
		}

		return true;
	}
}
