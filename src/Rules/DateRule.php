<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\Swv\{ AbstractRule, Invalidity, FormDataTreeInterface as FormDataTree };

final class DateRule extends AbstractRule {

	const RULE_NAME = 'date';


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
	 * Returns true if the given string is a valid Gregorian date in
	 * the YYYY-MM-DD format.
	 *
	 * @param string $value String to check.
	 */
	public static function isDate( string $value ): bool {
		$result = preg_match(
			'/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/',
			$value,
			$matches
		);

		if ( ! $result ) {
			return false;
		}

		return checkdate( $matches[ 2 ], $matches[ 3 ], $matches[ 1 ] );
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

		if ( empty( $context[ 'text' ] ) ) {
			return false;
		}

		return true;
	}


	/**
	 * Validates the form data according to the logic defined by this rule.
	 *
	 * @param FormDataTree $form_data Form data.
	 * @param iterable $context Context.
	 */
	public function validate( FormDataTree $form_data, iterable $context ) {
		$values = $form_data->getAll( $this->field );

		foreach ( $values as $value ) {
			if ( ! self::isDate( $value ) ) {
				throw new Invalidity( $this );
			}
		}

		return true;
	}


	/**
	 * Returns an array that represents the rule properties.
	 *
	 * @return iterable Array of rule properties.
	 */
	public function toArray(): iterable {
		return [
			'rule' => self::RULE_NAME,
			'field' => $this->field,
			'error' => $this->error,
		];
	}

}
