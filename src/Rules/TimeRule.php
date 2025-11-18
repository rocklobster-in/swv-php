<?php

namespace RockLobsterInc\Swv\Rules;

use RockLobsterInc\Swv\{ AbstractRule, Invalidity };
use function RockLobsterInc\Swv\{ strip_whitespaces, exclude_blank };

final class TimeRule extends AbstractRule {

	const RULE_NAME = 'time';


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
	 * Returns true if the given string is a valid time.
	 *
	 * @link https://html.spec.whatwg.org/multipage/input.html#time-state-(type=time)
	 *
	 * @param string $value String to check.
	 */
	public static function isTime( string $value ): bool {
		$time_pattern = '/^([0-9]{2})\:([0-9]{2})(?:\:([0-9]{2}))?$/';

		if ( ! preg_match( $time_pattern, $value, $matches ) ) {
			return false;
		}

		$hour = (int) $matches[1];
		$minute = (int) $matches[2];
		$second = empty( $matches[3] ) ? 0 : (int) $matches[3];

		return (
			0 <= $hour && $hour <= 23 &&
			0 <= $minute && $minute <= 59 &&
			0 <= $second && $second <= 59
		);
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
	 * @param FormDataInterface $form_data Form data.
	 * @param iterable $context Context.
	 */
	public function validate( FormDataInterface $form_data, iterable $context ) {
		$values = $form_data->getAll( $this->field );
		$values = strip_whitespaces( $values );
		$values = exclude_blank( $values );

		foreach ( $values as $value ) {
			if ( ! self::isTime( $value ) ) {
				throw new Invalidity( $this );
			}
		}

		return true;
	}

}
