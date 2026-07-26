<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RockLobsterInc\FormDataTree\FormDataTree;
use RockLobsterInc\Swv\InvalidityException;

final class EmailRuleTest extends TestCase {

    public static string $rule_class = '\RockLobsterInc\Swv\Rules\EmailRule';

    public static function validValueProvider(): array {
        return [
            'blank' => [ '' ],
            'valid' => [ 'testing@example.com' ],
        ];
    }

    public static function invalidValueProvider(): array {
        return [
            'invalid' => [ 'invalid email' ],
        ];
    }

    #[ DataProvider( 'validValueProvider' ) ]
    public function testValidity( $field_value ): void {
        $rule = new self::$rule_class( [
            'field' => 'the-field-name',
        ] );

        $form_data = new FormDataTree( [
            'post' => [
                'the-field-name' => $field_value,
            ],
        ] );

        $this->assertTrue( $rule->validate( $form_data ) );
    }

    #[ DataProvider( 'invalidValueProvider' ) ]
    public function testInvalidity( $field_value ): void {
        $rule = new self::$rule_class( [
            'field' => 'the-field-name',
            'error' => 'Just another error message.',
        ] );

        $form_data = new FormDataTree( [
            'post' => [
                'the-field-name' => $field_value,
            ],
        ] );

        $this->expectException( InvalidityException::class );
        $this->expectExceptionMessage( 'Just another error message.' );

        $rule->validate( $form_data );
    }

}
