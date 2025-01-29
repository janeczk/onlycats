<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test13_ChangePasswordCest
{
    // tests
    public function Test(AcceptanceTester $I): void
    {
        $I->wantTo('Change user password successfully');

        $I->logIn();
        $I->amOnPage('/profile/edit');
        $I->fillField('Current Password', 'secret');
        $I->fillField('New Password', 'newSecurePassword456@');
        $I->fillField('Confirm Password', 'newSecurePassword456@');
        $I->click('button[type=submit]');
    }
}
