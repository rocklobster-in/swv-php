<?php

namespace RockLobsterInc\Swv;

/**
 * An interface that represents form submission data in the key/value pairs
 * format.
 */
interface FormDataInterface {

	/**
	 * Returns the values associated with a given field name.
	 *
	 * @param string $name Field name.
	 * @return array Single dimension array of the values.
	 */
	public function get( string $name ): array;


	/**
	 * Returns the file objects associated with a given field name.
	 *
	 * @param string $name Field name.
	 * @return array Single dimension array of the values.
	 */
	public function getFiles( string $name ): array;

}
