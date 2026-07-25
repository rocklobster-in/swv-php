<?php

use PHPUnit\Framework\TestCase;
use RockLobsterInc\FormDataTree\FormDataTree;
use RockLobsterInc\Swv\InvalidityException;
use RockLobsterInc\Swv\Rules\EmailRule;

final class EmailRuleTest extends TestCase {

    public function testInvalidity(): void {
        $rule = new EmailRule( [
            'field' => 'your-email',
            'error' => 'Just another error message.',
        ] );

        $form_data = new FormDataTree( [
            'post' => [
                'your-email' => 'invalid email',
            ],
        ] );

        $this->expectException( InvalidityException::class );
        $this->expectExceptionMessage( 'Just another error message.' );

        $rule->validate( $form_data );
    }

    public function testValidity(): void {
        $rule = new EmailRule( [
            'field' => 'your-email',
        ] );

        // Case 1: Field left blank.
        $form_data_1 = new FormDataTree( [
            'post' => [
                'your-email' => '',
            ],
        ] );

        $this->assertTrue( $rule->validate( $form_data_1 ) );

        // Case 2: Field with a valid email.
        $form_data_2 = new FormDataTree( [
            'post' => [
                'your-email' => 'testing@example.com',
            ],
        ] );

        $this->assertTrue( $rule->validate( $form_data_2 ) );
    }

}
