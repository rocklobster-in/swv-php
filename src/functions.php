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
		return [ $input ];
	}

	return array_reduce( $input, static function ( $carry, $item ) {
		return array_merge( $carry, array_flatten( $item ) );
	}, [] );
}


/**
 * Strips surrounding whitespaces.
 *
 * @param string|array $input Input text or array of text.
 * @return string|array Output text or array of text.
 */
function strip_whitespaces( string|array $input ): string|array {
	if ( is_array( $input ) ) {
		return array_map( 'strip_whitespaces', $input );
	}

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
 * Converts all newline characters into line feed (LF).
 *
 * @param string|array $input Input text or array of text.
 * @return string|array Output text or array of text.
 */
function canonicalize_newline( string|array $input ): string|array {
	if ( is_array( $input ) ) {
		return array_map( 'canonicalize_newline', $input );
	}

	return str_replace( [ "\r\n", "\r", "\n" ], "\n", $input );
}


/**
 * Excludes unset or blank text values from the given array.
 *
 * @param array $input The array.
 * @return array Array without blank text values.
 */
function exclude_blank( array $input ): array {
	return array_reduce( $input, static function ( $carry, $item ) {
		if ( is_array( $item ) ) {
			$carry = array_merge( $carry, exclude_blank( $item ) );
		} elseif ( isset( $item ) and '' !== $item ) {
			$carry[] = $item;
		}

		return $carry;
	}, [] );
}


/**
 * Returns components of the given name.
 *
 * @param string $name Field name, such as 'abc', 'abc[de]', or 'abc[]'.
 * @return array Single dimension array of name components.
 */
function dissolve_name( string $name ): array {
	$name = trim( $name );

	if ( '' === $name ) {
		return [];
	}

	$first_bracket = strpos( $name, '[' );

	if ( false === $first_bracket ) {
		return [ $name ];
	}

	$core = trim( substr( $name, 0, $first_bracket ) );

	if ( '' === $core ) {
		return [];
	}

	$dimensions = substr( $name, $first_bracket );

	preg_match_all( '/\[(.*?)\]/', $dimensions, $matches );

	return array_map( 'trim', [ $core, ...$matches[1] ] );
}


/**
 * Converts a scalar value into a map with a specified key. The original
 * array structure will be preserved.
 *
 * @param string $key Map key.
 * @param mixed $value Original value.
 * @return array Array.
 */
function scalar_to_map( string $key, mixed $value ): array {
	if ( is_scalar( $value ) ) {
		return [ $key => $value ];
	}

	if ( is_array( $value ) ) {
		return array_map( static function ( $item ) use ( $key ) {
			return scalar_to_map( $key, $item );
		}, $value );
	}

	return [];
}


/**
 * Returns the number of code units in a string.
 *
 * @link http://www.w3.org/TR/html5/infrastructure.html#code-unit-length
 *
 * @param string $input Input string in the UTF-8 encoding.
 * @return int|false The number of code units, or false if mbstring is
 *                   not available.
 */
function count_code_units( string $input ): int|bool {
	if ( ! extension_loaded( 'mbstring' ) ) {
		return false;
	}

	if ( '' === $input ) {
		return 0;
	}

	$input = canonicalize_newline( $input );
	$input = mb_convert_encoding( $input, 'UTF-16', 'UTF-8' );

	return intdiv( mb_strlen( $input, '8bit' ), 2 );
}
