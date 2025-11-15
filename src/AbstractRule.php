<?php

namespace RockLobsterInc\Swv;

/**
 * Abstract class that represents the base for all SWV rules.
 */
abstract class AbstractRule {

	/**
	 * Returns true if this rule matches the given context.
	 *
	 * @param iterable $context Context.
	 */
	public function matches( iterable $context ): bool {
		return true;
	}


	/**
	 * Validates the form data according to the logic defined by this rule.
	 *
	 * @param FormDataInterface $form_data Form data.
	 * @param iterable $context Context.
	 */
	public function validate( FormDataInterface $form_data, iterable $context ) {
		return true;
	}

}
