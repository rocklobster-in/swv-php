<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\Swv\{ AbstractRule, Invalidity, FormDataTreeInterface as FormDataTree };
use function RockLobsterInc\Swv\{ count_code_units };

final class MaxLengthRule extends AbstractRule {

	const RULE_NAME = 'maxlength';


	/**
	 * Rule properties.
	 */
	public string $field;
	public string $error;
	public string $threshold;


	/**
	 * Constructor.
	 *
	 * @param iterable $properties Rule properties.
	 */
	public function __construct( iterable $properties = [] ) {
		$this->field = $properties[ 'field' ] ?? '';
		$this->error = $properties[ 'error' ] ?? '';
		$this->threshold = $properties[ 'threshold' ] ?? '';
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

		if ( ! is_numeric( $this->threshold ) ) {
			return true;
		}

		$total = 0;

		foreach ( $values as $value ) {
			$length = count_code_units( $value );

			if ( false === $length ) { // mbstring is not loaded.
				return true;
			}

			$total += $length;
		}

		if ( (int) $this->threshold < $total ) {
			throw new Invalidity( $this );
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
			'threshold' => $this->threshold,
		];
	}

}
