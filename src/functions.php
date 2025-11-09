<?php

namespace RockLobsterInc\Swv;


/**
 * Converts multi-dimensional array to a flat array.
 *
 * @param mixed $input Array or item of array.
 * @return array Flatten array.
 */
function array_flatten( mixed $input ): array {
	if ( ! is_array( $input ) ) {
		return array( $input );
	}

	return array_reduce( $input, static function ( $carry, $item ) {
		return array_merge( $carry, array_flatten( $item ) );
	}, array() );
}
