<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\Swv\{ CompositeRule, Invalidity };

class AnyRule extends CompositeRule {

	const RULE_NAME = 'any';

	public function matches( $context ) {
		if ( false === parent::matches( $context ) ) {
			return false;
		}

		return true;
	}

	public function validate( $context ) {
		foreach ( $this->rules() as $rule ) {
			if ( $rule->matches( $context ) ) {
				$result = $rule->validate( $context );

				if ( ! is_wp_error( $result ) ) {
					return true;
				}
			}
		}

		return $this->create_error();
	}

}
