<?php

namespace RockLobsterInc\Swv;

/**
 * A class that implements FormDataTreeInterface. Wraps the PHP superglobals.
 */
class FormDataTree implements FormDataTreeInterface {

	/**
	 * Returns the values associated with a given field name.
	 *
	 * @param string $name Field name.
	 * @return iterable Iterator of the values.
	 */
	public function getAll( string $name ): iterable {
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

		$posted_value = array_flatten( $posted_value );
		$posted_value = strip_whitespaces( $posted_value );
		$posted_value = exclude_blank( $posted_value );

		return $posted_value;
	}


	/**
	 * Returns the file objects associated with a given field name.
	 *
	 * @param string $name Field name.
	 * @return iterable Iterator of the FileInterface objects.
	 */
	public function getAllFiles( string $name ): iterable {
		$name_parts = dissolve_name( $name );

		if ( empty( $name_parts ) ) {
			return [];
		}

		$files_tree = File::buildTreeFromSuperglobal();

		while ( $next = array_shift( $name_parts ) ) {
			if ( isset( $files_tree[ $next ] ) ) {
				$files_tree = $files_tree[ $next ];
			} else {
				return [];
			}
		}

		return array_values( array_filter(
			array_flatten( $files_tree ),
			static function ( $item ) {
				return (
					$item instanceof FileInterface &&
					'' !== $item->name() &&
					0 !== $item->size() &&
					'' !== $item->temporaryFilePath()
				);
			}
		) );
	}

}
