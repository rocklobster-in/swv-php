<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\Swv\{ AbstractRule, Invalidity };

final class StepNumberRule extends AbstractRule {

	const RULE_NAME = 'stepnumber';


	/**
	 * Rule properties.
	 */
	public string $field;
	public string $error;
	public string $base;
	public string $interval;


	/**
	 * Constructor.
	 *
	 * @param iterable $properties Rule properties.
	 */
	public function __construct( iterable $properties = [] ) {
		$this->field = $properties[ 'field' ] ?? '';
		$this->error = $properties[ 'error' ] ?? '';
		$this->base = $properties[ 'base' ] ?? '';
		$this->interval = $properties[ 'interval' ] ?? '';
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

		$base = floatval( $this->base );
		$interval = floatval( $this->interval );

		if ( ! ( 0 < $interval ) ) {
			return true;
		}

		foreach ( $values as $value ) {
			$remainder = fmod( floatval( $value ) - $base, $interval );

			if (
				0.0 === round( abs( $remainder ), 6 ) or
				0.0 === round( abs( $remainder - $interval ), 6 )
			) {
				continue;
			}

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
			'base' => $this->base,
			'interval' => $this->interval,
		];
	}

}
