<?php

require __DIR__ . '/../vendor/autoload.php';

class MockFormDataTree extends \RockLobsterInc\FormDataTree\FormDataTree {

    public readonly array $mockPost;
    public readonly array $mockFiles;

    public function __construct( array $mock ) {
        $this->mockPost = $mock[ 'post' ] ?? [];
        $this->mockFiles = $mock[ 'files' ] ?? [];
    }

	public function getAll( string $name ): iterable {
		$name_parts = dissolve_name( $name );

		if ( empty( $name_parts ) ) {
			return [];
		}

		$posted_value = $this->mockPost;

		while ( $next = array_shift( $name_parts ) ) {
			if (
				preg_match( '/^[0-9]*$/', $next ) or
				! isset( $posted_value[ $next ] )
			) {
				return [];
			}

			$posted_value = $posted_value[ $next ];
		}

		if ( ! is_array( $posted_value ) ) {
			$posted_value = [ $posted_value ];
		}

		$posted_value = strip_whitespaces( $posted_value );
		$posted_value = exclude_blank( $posted_value );

		return $posted_value;
	}

	public function getAllFiles( string $name ): iterable {
		$name_parts = dissolve_name( $name );

		if ( empty( $name_parts ) ) {
			return [];
		}

		$files_tree = $this->mockFiles;

		while ( $next = array_shift( $name_parts ) ) {
			if (
				preg_match( '/^[0-9]*$/', $next ) or
				! isset( $files_tree[ $next ] )
			) {
				return [];
			}

			$files_tree = $files_tree[ $next ];
		}

		if ( ! is_array( $files_tree ) ) {
			$files_tree = [ $files_tree ];
		}

		$files_tree = exclude_blank( $files_tree );

		return $files_tree;
	}

}
