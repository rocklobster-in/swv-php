<?php

namespace RockLobsterInc\Swv;

/**
 * A class that implements FormDataInterface. Wraps the PHP superglobals.
 */
class FormData implements FormDataInterface {

	/**
	 * Returns the values associated with a given field name.
	 *
	 * @param string $name Field name.
	 * @return array|string The value(s) associated with the field name.
	 */
	public function get( string $name ): array|string {
		if ( isset( $_FILES[ $name ] ) ) {
			return $_FILES[ $name ];
		}

		if ( isset( $_POST[ $name ] ) ) {
			return $_POST[ $name ];
		}
	}


	/**
	 * Returns true if the object has the value associated with a given field
	 * name.
	 *
	 * @param string $name Field name.
	 */
	public function has( string $name ): bool {
		return isset( $_FILES[ $name ] ) || isset( $_POST[ $name ] );
	}

}
