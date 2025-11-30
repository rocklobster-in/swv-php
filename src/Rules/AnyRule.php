<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\FormDataTree\{ FormDataTreeInterface as FormDataTree };
use RockLobsterInc\Swv\{ CompositeRule, InvalidityException as Invalidity };

final class AnyRule extends CompositeRule {

	const RULE_NAME = 'any';


	/**
	 * Rule properties.
	 */
	public readonly string $field;
	public readonly string $error;


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
	 * @param FormDataTree $form_data Form data.
	 * @param iterable $context Optional context.
	 */
	public function validate( FormDataTree $form_data, iterable $context = [] ) {
		$any_valid = false;

		foreach ( $this->rules() as $rule ) {
			if ( $rule->matches( $context ) ) {
				try {
					$any_valid = $rule->validate( $form_data, $context );
				} catch ( Invalidity $error ) {
					// Do nothing.
				}
			}
		}

		if ( ! $any_valid ) {
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
