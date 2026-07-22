<?php

use PHPUnit\Framework\TestCase;
use RockLobsterInc\FormDataTree\FormDataTree;
use RockLobsterInc\Swv\InvalidityException;
use RockLobsterInc\Swv\Rules\EmailRule;

final class EmailRuleTest extends TestCase {

    public function testInvalidity(): void {
        $rule = new EmailRule( [
            'field' => 'the-field',
            'error' => 'Just another error message.',
        ] );

        $form_data = new FormDataTree( [
            'post' => [
                'the-field' => 'invalid email',
            ],
        ] );

        $this->expectException( InvalidityException::class );
        $this->expectExceptionMessage( 'Just another error message.' );

        $rule->validate( $form_data );
    }

    public function testValidity(): void {
        $rule = new EmailRule( [
            'field' => 'the-field',
        ] );

        $form_data = new FormDataTree( [
            'post' => [
                'the-field' => 'testing@example.com',
            ],
        ] );

        $result = $rule->validate( $form_data );

        $this->assertTrue( $result );
    }

}
