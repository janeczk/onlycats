<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test07_subscribeAndUnsubscribeUserCest
{
    // tests
    public function Test(AcceptanceTester $I): void
    {
        $I->wantTo('Subscribe an user and unsubscribe');

        $I->logIn();
        $I->addCard();

        $I->amOnPage('/@u0002');
        $I->click('SUBSCRIBE');
        $I->seeCurrentUrlEquals('/@u0002');
        $I->see('NO POSTS');
        $I->click('Unsubscribe');
        $I->see('Are you sure');
        $I->click('Yes');
        $I->seeCurrentUrlEquals('/@u0002');
        $I->see('Lorem Ipsum');
    }

}
