<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test12_viewProfileCest
{
    public function viewProfilePage(AcceptanceTester $I): void
    {
        $I->wantTo('View the profile page of a user and validate the content');


        $I->logIn();


        $I->amOnPage('/profile');

        $I->see('John Doe');
        $I->see('@u0001');
        $I->see('Hello. Im Joe and I love cats!');


        $I->see('0 Subscriptions');

        $I->see('Edit Background Photo', 'label');
        $I->see('EDIT PROFILE', 'a');
        $I->see('Post', 'button');


        $I->scrollTo(['css' => '.flex.bg-gray-100']);

        $I->see('John Doe');
        $I->see('#small #cute #ilovemycat');
        $I->seeElement('img');
    }
}
