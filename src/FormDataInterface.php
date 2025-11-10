<?php

namespace RockLobsterInc\Swv;

/**
 * An interface that represents form submission data in the key/value pairs
 * format.
 */
interface FormDataInterface {

	/**
	 * Returns the first value associated with a given field name.
	 *
	 * @param string $name Field name.
	 */
	public function get( string $name );


	/**
	 * Returns true if the object has the value associated with a given field
	 * name.
	 *
	 * @param string $name Field name.
	 */
	public function has( string $name );

}
