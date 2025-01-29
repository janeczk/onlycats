<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test08_subscribeCounterCest
{
    // tests

    public function Test(AcceptanceTester $I): void
    {
        $I->wantTo('Subscribe an user and check if counter rised');

        $I->logIn();
        $I->addCard();

        $I->amOnPage('/@u0002');
        $I->click('SUBSCRIBE');
        $I->seeCurrentUrlEquals('/@u0002');
        $I->see('1');
    }

}
