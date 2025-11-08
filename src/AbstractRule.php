<?php

namespace RockLobsterInc\SchemaWovenValidation;

/**
 * Abstract class that represents the root of all SWV rules.
 */
abstract class AbstractRule {

	/**
	 * Properties of the rule.
	 */
	protected $properties = array();


	/**
	 * Constructor.
	 *
	 * @param array $properties Properties of the rule.
	 */
	public function __construct( array $properties = [] ) {
		$this->properties = $properties;
	}


	/**
	 * Returns true if this rule matches the given context.
	 *
	 * @param array $context Context.
	 */
	public function matches( array $context ) {
		return true;
	}


	/**
	 * Validates with this rule's logic.
	 *
	 * @param array $context Context.
	 */
	public function validate( array $context ) {
		return true;
	}

}
