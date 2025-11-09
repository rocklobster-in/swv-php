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


/**
 * Strips surrounding whitespaces.
 *
 * @param string $input Input text.
 * @return string Output text.
 */
function strip_whitespaces( string $input ): string {
	$whitespaces = '\x09-\x0D\x20\x85\xA0\x{1680}\x{180E}\x{2000}-\x{200A}\x{2028}\x{2029}\x{202F}\x{205F}\x{3000}\x{FEFF}';

	$input = preg_replace(
		sprintf( '/^[%s]+/u', $whitespaces ),
		'',
		$input
	);

	$input = preg_replace(
		sprintf( '/[%s]+$/u', $whitespaces ),
		'',
		$input
	);

	return $input;
}


/**
 * Excludes unset or blank text values from the given array.
 *
 * @param array $input The array.
 * @return array Array without blank text values.
 */
function exclude_blank( array $input ): array {
	return array_filter( $input, static function ( $item ) {
		return isset( $item ) && '' !== strip_whitespaces( $item );
	} );
}
