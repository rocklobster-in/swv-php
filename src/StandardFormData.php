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

}
