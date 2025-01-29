<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test00_HomepageCest
{
    public function test(AcceptanceTester $I): void
    {
        $I->wantTo('ensure the login page elements are displayed');

        $I->amOnPage('/');

        $I->see('Email');
        $I->see('Password');
        $I->see('Log in');
        $I->seeLink('Forgot your password?');
        $I->seeLink('Register now!');
    }

}
