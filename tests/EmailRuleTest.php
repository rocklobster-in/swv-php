<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RockLobsterInc\FormDataTree\FormDataTree;
use RockLobsterInc\Swv\InvalidityException;
use RockLobsterInc\Swv\Rules\EmailRule;

final class EmailRuleTest extends TestCase {

    public static function invalidValueProvider(): array {
        return [
            'invalid' => [ 'invalid email' ],
        ];
    }

    #[ DataProvider( 'invalidValueProvider' ) ]
    public function testInvalidity( $field_value ): void {
        $rule = new EmailRule( [
            'field' => 'your-email',
            'error' => 'Just another error message.',
        ] );

        $form_data = new FormDataTree( [
            'post' => [
                'your-email' => $field_value,
            ],
        ] );

        $this->expectException( InvalidityException::class );
        $this->expectExceptionMessage( 'Just another error message.' );

        $rule->validate( $form_data );
    }

    public static function validValueProvider(): array {
        return [
            'blank' => [ '' ],
            'valid' => [ 'testing@example.com' ],
        ];
    }

    #[ DataProvider( 'validValueProvider' ) ]
    public function testValidity( $field_value ): void {
        $rule = new EmailRule( [
            'field' => 'your-email',
        ] );

        $form_data = new FormDataTree( [
            'post' => [
                'your-email' => $field_value,
            ],
        ] );

        $this->assertTrue( $rule->validate( $form_data ) );
    }

}
