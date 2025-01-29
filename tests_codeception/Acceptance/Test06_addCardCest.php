<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test06_addCardCest
{
    public function Test(AcceptanceTester $I): void
    {
        $I->wantTo('Adding and deleting card');

        $I->logIn();
        $I->addCard();
        $I->waitForNextPage(fn () => $I->click('Delete Card'));
        $I->see('The card has been successfully deleted!');
    }

}
