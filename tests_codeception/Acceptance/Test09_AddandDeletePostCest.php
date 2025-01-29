<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test09_AddandDeletePostCest
{
    public function test(AcceptanceTester $I): void
    {
        $I->wantTo('compose and publish a new post on the homepage');

        // Zaloguj się i przejdź na stronę główną
        $I->amOnPage('/');
        $I->logIn();
        $I->seeCurrentUrlEquals('/');
        $I->see('Home');

        // dodanie posta z zdjeciem
        $newPostContent = 'This is a test post created by an automated test';
        $I->fillField('textarea[placeholder="Compose new post..."]', $newPostContent);
        $I->attachFile('input[type="file"]', 'cat2.jpeg');
        $I->click('button[type="submit"]');
        $I->wait(1);
        $I->see($newPostContent, '.post');

        //wejscie w post
        $I->seeElement('a[href*="/posts/10"]');
        $I->click('a[href*="/posts/10"]');
        $I->seeCurrentUrlMatches('~^/posts/10\?referer=home$~');
        $I->see('Post');

        //usuniecie posta
        $I->seeElement('#options-btn');
        $I->click('#options-btn');
        $I->wait(1);
        $I->click('//form[contains(@action, "/posts/10")]//button');
        $I->seeCurrentUrlEquals('/');
        $I->dontSeeElement('a[href*="/posts/10"]');
    }
}
