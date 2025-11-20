<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\Swv\{ AbstractRule, InvalidityException as Invalidity, FormDataTreeInterface as FormDataTree };

final class UrlRule extends AbstractRule {

	const RULE_NAME = 'url';

	const ALLOWED_PROTOCOLS = [ 'http', 'https' ];


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
	 * Returns true if the given string is a well-formed URL.
	 *
	 * @param string $value String to check.
	 */
	public static function isUrl( string $value ): bool {
		$scheme = parse_url( $value, PHP_URL_SCHEME );

		return $scheme && in_array( $scheme, self::ALLOWED_PROTOCOLS, true );
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
			if ( ! self::isUrl( $value ) ) {
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
