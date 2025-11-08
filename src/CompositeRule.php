<?php

namespace RockLobsterInc\SchemaWovenValidation;

/**
 * Abstract class that represents the root of all composite-type SWV rules.
 */
abstract class CompositeRule extends AbstractRule {

	/**
	 * Sub-rules of the rule.
	 */
	protected $rules = array();


	/**
	 * Adds a sub-rule to this composite rule.
	 *
	 * @param AbstractRule $rule Sub-rule to be added.
	 */
	public function addRule( AbstractRule $rule ) {
		$this->rules[] = $rule;

		return true;
	}

}
