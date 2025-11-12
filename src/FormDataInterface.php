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
	 */
	public function get( string $name );


	/**
	 * Returns the file objects associated with a given field name.
	 *
	 * @param string $name Field name.
	 */
	public function getFiles( string $name );

}
