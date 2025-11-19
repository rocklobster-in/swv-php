<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\Swv\{ CompositeRule, Invalidity };

final class AllRule extends CompositeRule {

	const RULE_NAME = 'all';


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

		return true;
	}


	/**
	 * Validates the form data according to the logic defined by this rule.
	 *
	 * @param FormDataInterface $form_data Form data.
	 * @param iterable $context Context.
	 */
	public function validate( FormDataInterface $form_data, iterable $context ) {
		foreach ( $this->rules() as $rule ) {
			if ( $rule->matches( $context ) ) {
				try {
					$rule->validate( $form_data, $context );
				} catch ( Invalidity $error ) {
					if ( '' === $error->getMessage() ) {
						$error->setMessage( $this->error );
					}

					throw $error;
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
		$rules = [];

		foreach ( $this->rules() as $rule ) {
			$rules[] = $rule->toArray();
		}

		return [
			'rule' => self::RULE_NAME,
			'field' => $this->field,
			'error' => $this->error,
			'rules' => $rules,
		];
	}

}
