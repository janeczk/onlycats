<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test03_NavigationCest
{
    public function test(AcceptanceTester $I): void
    {
        $I->wantTo('see my homepage and verify nav links');

        $I->amOnPage('/login');

        $I->logIn();

        $I->seeCurrentUrlEquals('/');

        $I->see('HOME');

        $I->seeLink('Home', 'http://localhost:8888');
        $I->seeLink('Subscribe', '/dashboard');
        $I->seeLink('Add Card', '/add-card?from=add-card');
        $I->seeLink('Profile', '/profile');
        $I->seeLink('Log Out', '#');
    }
}
