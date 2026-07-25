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

        $form_data = new FormDataTree( [
            'post' => [
                'your-date' => '2026-07-24',
            ],
        ] );

        $result = $rule->validate( $form_data );

        $this->assertTrue( $result );
    }

}
