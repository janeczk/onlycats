<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test02_LoginCest
{
    public function test(AcceptanceTester $I): void
    {
        $I->wantTo('login with existing user');

        $I->amOnPage('/');

        $I->fillField('email', 'john.doe@gmail.com');
        $I->fillField('password', 'secret');

        $I->waitForNextPage(fn () => $I->click('Log in'));
        $I->see('Home');
        $I->see('Log out', 'nav');
        $I->dontSee('Log in');
    }
}
