<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\FormDataTree\{ FormDataTreeInterface as FormDataTree };
use RockLobsterInc\Swv\{ AbstractRule, InvalidityException as Invalidity };
use function RockLobsterInc\Functions\{ array_flatten };

final class MaxDateRule extends AbstractRule {

	const RULE_NAME = 'maxdate';


	/**
	 * Rule properties.
	 */
	public readonly string $field;
	public readonly string $error;
	public readonly string $threshold;


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
	 * @param iterable $context Optional context.
	 */
	public function validate( FormDataTree $form_data, iterable $context = [] ) {
		$values = $form_data->getAll( $this->field );
		$values = array_flatten( $values );

		if ( empty( $values ) or ! DateRule::isDate( $this->threshold ) ) {
			return true;
		}

		foreach ( $values as $value ) {
			if ( DateRule::isDate( $value ) and $this->threshold < $value ) {
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
			'threshold' => $this->threshold,
		];
	}

}
