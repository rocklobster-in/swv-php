<?php

namespace RockLobsterInc\Swv;

/**
 * Class that represents a standard file data in $_FILES.
 */
class File implements FileInterface {

	private string $name;
	private int $size;
	private string $temporaryFilePath;
	private int $error;


	/**
	 * Constructor.
	 *
	 * @param array $properties Properties of the object.
	 */
	public function __construct( array $properties = [] ) {
		$this->name = $properties[ 'name' ];
		$this->size = $properties[ 'size' ];
		$this->temporaryFilePath = $properties[ 'temporaryFilePath' ];
		$this->error = $properties[ 'error' ];
	}


	/**
	 * Walks through an array and creates File objects if there are
	 * necessary properties.
	 *
	 * @param mixed $array Where to walk.
	 */
	public static function walkToFindSelf( mixed $array ) {
		if (
			isset( $array[ 'name' ] ) and is_scalar( $array[ 'name' ] ) and
			isset( $array[ 'size' ] ) and is_scalar( $array[ 'size' ] ) and
			isset( $array[ 'tmp_name' ] ) and is_scalar( $array[ 'tmp_name' ] ) and
			isset( $array[ 'error' ] ) and is_scalar( $array[ 'error' ] )
		) {
			return new self( [
				'name' => $array[ 'name' ],
				'size' => $array[ 'size' ],
				'temporaryFilePath' => $array[ 'tmp_name' ],
				'error' => $array[ 'error' ],
			] );
		}

		if ( is_array( $array ) ) {
			return array_map( 'self::walkToFindSelf', $array );
		}
	}


	/**
	 * Creates a tree structure based on the $_FILES superglobal. A terminal
	 * node of the tree must be a File object.
	 *
	 * @return array Tree created based on $_FILES.
	 */
	public static function buildTreeFromSuperglobal(): array {
		static $output = [];

		if ( ! empty( $output ) ) {
			return $output;
		}

		foreach ( $_FILES as $name => $props ) {
			$in_process_array = [];

			foreach ( $props as $key => $value ) {
				$in_process_array[] = scalar_to_map( $key, $value );
			}

			$in_process_array = array_replace_recursive( ...$in_process_array );

			$output[ $name ] = self::walkToFindSelf( $in_process_array );
		}

		return $output;
	}


	/**
	 * Returns the original name of the file on the client machine.
	 */
	public function name(): string {
		return $this->name;
	}


	/**
	 * Returns the size, in bytes, of the file.
	 */
	public function size(): int {
		return $this->size;
	}


	/**
	 * Returns the full path of the file in which the uploaded file was
	 * stored on the server.
	 */
	public function temporaryFilePath(): string {
		return $this->temporaryFilePath;
	}


	/**
	 * Returns the error code associated with this file upload.
	 */
	public function error(): int {
		return $this->error;
	}

}
