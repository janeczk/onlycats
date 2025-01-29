<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test15_DeleteAccountCest
{
    public function Test(AcceptanceTester $I): void
    {
        $I->wantTo('Delete an account successfully');

        $I->logIn();

        $I->amOnPage('/profile/edit');

        $I->scrollTo('section.space-y-6');
        $I->see('Delete Account');


        $I->click('//button[contains(text(), "Delete Account")]', 'section.space-y-6');

        $I->waitForElementVisible('//h2[contains(text(), "Are you sure you want to delete your account?")]', 5);

        $I->see('Are you sure you want to delete your account?');
        $I->see('Once your account is deleted, all of its resources and data will be permanently deleted.');

        $I->fillField('input[placeholder="Password"]', 'secret');

        $I->click('#delete-account-button');


    }
}
