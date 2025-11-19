<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\Swv\{ AbstractRule, Invalidity };

final class DayofweekRule extends AbstractRule {

	const RULE_NAME = 'dayofweek';


	/**
	 * Rule properties.
	 */
	public string $field;
	public string $error;
	public array $accept;


	/**
	 * Constructor.
	 *
	 * @param iterable $properties Rule properties.
	 */
	public function __construct( iterable $properties = [] ) {
		$this->field = $properties[ 'field' ] ?? '';
		$this->error = $properties[ 'error' ] ?? '';
		$this->accept = $properties[ 'accept' ] ?? [];
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
	 * @param FormDataInterface $form_data Form data.
	 * @param iterable $context Context.
	 */
	public function validate( FormDataInterface $form_data, iterable $context ) {
		$values = $form_data->getAll( $this->field );

		$acceptable_values = array_map( 'intval', $this->accept );

		foreach ( $values as $value ) {
			if ( DateRule::isDate( $value ) ) {
				$datetime = date_create_immutable( $value );
				$day_of_week = (int) $datetime->format( 'N' );

				if ( ! in_array( $day_of_week, $acceptable_values, true ) ) {
					throw new Invalidity( $this );
				}
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
			'accept' => $this->accept,
		];
	}

}
