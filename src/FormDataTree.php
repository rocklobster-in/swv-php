<?php

namespace RockLobsterInc\Swv;

/**
 * A class that implements FormDataInterface. Wraps the PHP superglobals.
 */
class FormDataTree implements FormDataInterface {

	/**
	 * Returns the values associated with a given field name.
	 *
	 * @param string $name Field name.
	 * @return array Single dimension array of the values.
	 */
	public function get( string $name ): array {
		$name_parts = dissolve_name( $name );

		if ( empty( $name_parts ) ) {
			return [];
		}

		$posted_value = $_POST;

		while ( $next = array_shift( $name_parts ) ) {
			if ( isset( $posted_value[ $next ] ) ) {
				$posted_value = $posted_value[ $next ];
			} else {
				return [];
			}
		}

		return array_flatten( $posted_value );
	}


	/**
	 * Returns the file objects associated with a given field name.
	 *
	 * @param string $name Field name.
	 * @return array Single dimension array of the StandardFile objects.
	 */
	public function getFiles( string $name ): array {
	}

}
