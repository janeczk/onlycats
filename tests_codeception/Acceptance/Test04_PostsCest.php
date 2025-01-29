<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test04_PostsCest
{
    public function test(AcceptanceTester $I): void
    {
        $I->wantTo('view post details and interact with it');

        $I->amOnPage('/');
        $I->logIn();
        $I->seeCurrentUrlEquals('/');

        $I->see('Home');

        $I->seeElement('a[href*="/posts/1"]');
        $I->click('a[href*="/posts/1"]');

        $I->seeCurrentUrlMatches('~^/posts/1\?referer=home$~');

        $I->see('Post');

        //czy daje i zabiera like
        $I->seeElement('svg.like-icon');
        $likesCountText = $I->grabTextFrom('.likes-count');
        $likesCountBefore = is_numeric($likesCountText) ? (int)$likesCountText : 0;
        $I->click('svg.like-icon');
        $I->waitForText((string)($likesCountBefore + 1), 5, '.likes-count');
        $I->click('svg.like-icon');
        $I->waitForText((string)$likesCountBefore, 5, '.likes-count');

        //wstaw komentarz
        $commentText = 'This is a test comment';
        $I->fillField('input[name="text"]', $commentText);
        $I->seeElement('button[type="submit"]');
        $I->wait(1);
        $I->scrollTo('//button[@type="submit"]');
        $I->click("//form[contains(@action, 'comments')]//button[@type='submit']");

        //czy widac komentarz
        $I->waitForText($commentText, 5, '.text-gray-300');
        $I->see($commentText, '.text-gray-300');

        //czy usunie komentarz
        $I->seeElement('.text-gray-300 form button');
        $I->click('.text-gray-300 form button');
        $I->wait(1);
        $I->dontSee($commentText, '.text-gray-300');

        //edytowanie postu
        $I->seeElement('#options-btn');
        $I->click('#options-btn');
        $I->waitForElementVisible('a[href*="/posts/1/edit"]', 10);
        $I->click('a[href*="/posts/1/edit"]');
        $I->seeCurrentUrlEquals('/posts/1/edit');
        $I->see('Edit Post');

        $newPostText = 'This is an updated test post.';
        $I->fillField('textarea[name="content"]', $newPostText);
        $I->click('button[type="submit"]');
        $I->wait(1);

        //czy edytowano
        $I->seeCurrentUrlEquals('/posts/1');
        $I->see($newPostText);
    }
}
