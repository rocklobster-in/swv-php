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
	 * @return iterable Iterator of the values.
	 */
	public function get( string $name ): iterable;


	/**
	 * Returns the file objects associated with a given field name.
	 *
	 * @param string $name Field name.
	 * @return iterable Iterator of the file objects.
	 */
	public function getFiles( string $name ): iterable;

}
