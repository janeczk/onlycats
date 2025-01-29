<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test01_RegistrationCest
{
    public function test(AcceptanceTester $I): void
    {
        $I->wantTo('register a new user');
        $I->amOnPage('/register');

        $I->fillField('name', 'Test User');
        $I->fillField('username', '@testuser');
        $I->fillField('email', 'testuser@example.com');
        $I->fillField('password', 'password');
        $I->fillField('password_confirmation', 'password');

        $I->click('Register');

        $I->seeCurrentUrlEquals('/');
        $I->see('Home');
        $I->see('LOG OUT');
    }
}
