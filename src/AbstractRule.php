<?php

namespace RockLobsterInc\Swv;

use RockLobsterInc\Swv\{ FormDataTreeInterface as FormDataTree };

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
	 * @param FormDataTree $form_data Form data.
	 * @param iterable $context Context.
	 */
	public function validate( FormDataTree $form_data, iterable $context ) {
		return true;
	}


	/**
	 * Returns an array that represents the rule properties.
	 *
	 * @return iterable Array of rule properties.
	 */
	public function toArray(): iterable {
		return [];
	}

}
