<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\FormDataTree\{ FormDataTreeInterface as FormDataTree };
use RockLobsterInc\Swv\{ AbstractRule, InvalidityException as Invalidity };

final class TelRule extends AbstractRule {

	const RULE_NAME = 'tel';


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
	 * Returns true if the given string is a well-formed telephone number.
	 *
	 * @param string $value String to check.
	 */
	public static function isTel( string $value ): bool {
		$value = preg_replace( '/[#*].*$/', '', $value ); // Remove extension.
		$value = preg_replace( '%[()/.*#\s-]+%', '', $value );

		$is_international = (
			'+' === substr( $value, 0, 1 ) ||
			'00' === substr( $value, 0, 2 )
		);

		if ( $is_international ) {
			$value = '+' . preg_replace( '/^[+0]+/', '', $value );
		}

		if ( ! preg_match( '/^[+]?[0-9]+$/', $value ) ) {
			return false;
		}

		if ( ! ( 5 < strlen( $value ) and strlen( $value ) < 16 ) ) {
			return false;
		}

		return true;
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

		if ( empty( $values ) ) {
			return true;
		}

		foreach ( $values as $value ) {
			if ( ! self::isTel( $value ) ) {
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
