<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\Swv\{ AbstractRule, Invalidity };

final class RequiredFileRule extends AbstractRule {

	const RULE_NAME = 'requiredfile';


	/**
	 * Rule properties.
	 */
	public string $field;
	public string $error;


	/**
	 * Constructor.
	 *
	 * @param iterable $properties Rule properties.
	 */
	public function __construct( iterable $properties = [] ) {
		$this->field = $properties[ 'field' ] ?? '';
		$this->error = $properties[ 'error' ] ?? '';
	}


	/**
	 * Returns true if this rule matches the given context.
	 *
	 * @param iterable $context Context.
	 */
	public function matches( iterable $context ): bool {
		if ( false === parent::matches( $context ) ) {
			return false;
		}

		if ( empty( $context[ 'file' ] ) ) {
			return false;
		}

		return true;
	}


	/**
	 * Validates the form data according to the logic defined by this rule.
	 *
	 * @param FormDataInterface $form_data Form data.
	 * @param iterable $context Context.
	 */
	public function validate( FormDataInterface $form_data, iterable $context ) {
		$files = $form_data->getAllFiles( $this->field );

		$tmp_names = array_reduce( $files, static function ( $carry, $item ) {
			$carry[] = $item->temporaryFilePath();
			return $carry;
		}, [] );

		if ( empty( $tmp_names ) ) {
			throw new Invalidity( $this );
		}

		return true;
	}

}
