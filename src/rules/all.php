<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\Swv\{ CompositeRule, Invalidity };

class AllRule extends CompositeRule {

	const RULE_NAME = 'all';

	public function matches( iterable $context ): bool {
		if ( false === parent::matches( $context ) ) {
			return false;
		}

		return true;
	}

	public function validate( FormDataInterface $form_data, iterable $context ) {
		foreach ( $this->rules() as $rule ) {
			if ( $rule->matches( $context ) ) {
				try {
					$rule->validate( $form_data, $context );
				} catch ( Invalidity $error ) {
					throw $error;
				}
			}
		}

		return true;
	}

}
