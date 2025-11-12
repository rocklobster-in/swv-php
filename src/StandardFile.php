<?php

namespace RockLobsterInc\Swv;

/**
 * Class that represents a standard file data in $_FILES.
 */
class StandardFile implements FileInterface {

	private string $name;
	private int $size;
	private int $error;


	/**
	 * Constructor.
	 *
	 * @param array $properties Properties of the object.
	 */
	public function __construct( array $properties = [] ) {
		$this->name = $properties[ 'name' ];
		$this->size = $properties[ 'size' ];
		$this->error = $properties[ 'error' ];
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
	 * Returns the error code associated with this file upload.
	 */
	public function error(): int {
		return $this->error;
	}

}
