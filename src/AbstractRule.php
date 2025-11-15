<?php

namespace RockLobsterInc\Swv;

/**
 * Abstract class that represents the base for all SWV rules.
 */
abstract class AbstractRule {

	/**
	 * Properties of the rule.
	 */
	protected array $properties = array();


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
	public function matches( iterable $context ): bool {
		return true;
	}


	/**
	 * Validates with this rule's logic.
	 *
	 * @param FormDataInterface $form_data Form data.
	 * @param array $context Context.
	 */
	public function validate( FormDataInterface $form_data, iterable $context ) {
		return true;
	}

}
