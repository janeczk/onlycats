<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test05_subscribeUserCest
{
    // tests

    public function Test(AcceptanceTester $I): void
    {
        $I->wantTo('Subscribe an user and check if hes on the list');

        $I->logIn();
        $I->addCard();

        $I->amOnPage('/@u0002');
        $I->click('SUBSCRIBE');
        $I->seeCurrentUrlEquals('/@u0002');
        $I->see('NO POSTS');
        $I->amOnPage('/dashboard');
        $I->seeCurrentUrlEquals('/dashboard');
        $I->see('Subscribed');
        $I->click('Subscribed');
        $I->see('Mark Wilson');
    }

}
