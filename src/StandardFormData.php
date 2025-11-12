<?php

namespace RockLobsterInc\Swv;

/**
 * A class that implements FormDataInterface. Wraps the PHP superglobals.
 */
class StandardFormData implements FormDataInterface {

	/**
	 * Returns the values associated with a given field name.
	 *
	 * @param string $name Field name.
	 * @return array Single dimension array of the values.
	 */
	public function get( string $name ): array {
	}


	/**
	 * Returns the file objects associated with a given field name.
	 *
	 * @param string $name Field name.
	 * @return array Single dimension array of the StandardFile objects.
	 */
	public function getFiles( string $name ): array {
	}


	/**
	 * Returns parts of a given name.
	 *
	 * @param string $name Field name.
	 * @return array Single dimension array of name parts.
	 */
	private function dissolve( string $name ): array {
		$first_bracket = strpos( $name, '[' );

		if ( false === $first_bracket ) {
			return [ $name ];
		}

		$core = substr( $name, 0, $first_bracket );
		$dimensions = substr( $name, $first_bracket );

		preg_match_all( '/\[(.*?)\]/', $dimensions, $matches );

		return [ $core, ...$matches[1] ];
	}

}
