<?php

use PHPUnit\Framework\TestCase;
use RockLobsterInc\FormDataTree\FormDataTree;
use RockLobsterInc\Swv\InvalidityException;
use RockLobsterInc\Swv\Rules\DateRule;

final class DateRuleTest extends TestCase {

    public function testInvalidity(): void {
        $rule = new DateRule( [
            'field' => 'your-date',
            'error' => 'Just another error message.',
        ] );

        $form_data = new FormDataTree( [
            'post' => [
                'your-date' => 'invalid date',
            ],
        ] );

        $this->expectException( InvalidityException::class );
        $this->expectExceptionMessage( 'Just another error message.' );

        $rule->validate( $form_data );
    }

    public function testValidity(): void {
        $rule = new DateRule( [
            'field' => 'your-date',
        ] );

        // Case 1: Field left blank.
        $form_data_1 = new FormDataTree( [
            'post' => [
                'your-date' => '',
            ],
        ] );

        $this->assertTrue( $rule->validate( $form_data_1 ) );

        // Case 2: Field with a valid email.
        $form_data_2 = new FormDataTree( [
            'post' => [
                'your-date' => '2026-07-24',
            ],
        ] );

        $this->assertTrue( $rule->validate( $form_data_2 ) );
    }

}
