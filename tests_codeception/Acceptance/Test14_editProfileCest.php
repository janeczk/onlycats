<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test14_editProfileCest
{
    // tests
    public function Test(AcceptanceTester $I): void
    {


        $I->wantTo('Update profile information and check if changes are saved');

        $I->logIn();
        $I->amOnPage('/profile/edit');
        $I->fillField('Name', 'Will Doe');
        $I->fillField('Email', 'will.doe@gmail.com');
        $I->fillField('Username', '@u0009');
        $I->fillField('Bio', 'Hello, I love cats too!!');
        $I->click('button[type=submit]');



        $I->seeInField('Name', 'Will Doe');
        $I->seeInField('Email', 'will.doe@gmail.com');
        $I->seeInField('Username', '@u0009');
        $I->seeInField('Bio', 'Hello, I love cats too!!');


        $I->amOnPage('/profile');
        $I->seeCurrentUrlEquals('/profile');

        $I->see('Will Doe');
        $I->see('@u0009');
        $I->see('Hello, I love cats too!!');
    }
}
