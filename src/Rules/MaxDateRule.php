<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\Swv\{ AbstractRule, Invalidity };

final class MaxDateRule extends AbstractRule {

	const RULE_NAME = 'maxdate';


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
	 * @param FormDataInterface $form_data Form data.
	 * @param iterable $context Context.
	 */
	public function validate( FormDataInterface $form_data, iterable $context ) {
		$values = $form_data->getAll( $this->field );

		if ( ! DateRule::isDate( $this->threshold ) ) {
			return true;
		}

		foreach ( $values as $value ) {
			if ( DateRule::isDate( $value ) and $this->threshold < $value ) {
				throw new Invalidity( $this );
			}
		}

		return true;
	}

}
