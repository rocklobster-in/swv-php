<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\Swv\{ AbstractRule, Invalidity };

final class RequiredFileRule extends AbstractRule {

	const RULE_NAME = 'requiredfile';

	public function matches( $context ) {
		if ( false === parent::matches( $context ) ) {
			return false;
		}

		if ( empty( $context['file'] ) ) {
			return false;
		}

		return true;
	}

	public function validate( $context ) {
		$input = $this->get_default_upload()->tmp_name ?? '';
		$input = wpcf7_array_flatten( $input );
		$input = wpcf7_exclude_blank( $input );

		if ( empty( $input ) ) {
			return $this->create_error();
		}

		return true;
	}

}
