<?php

declare(strict_types=1);

namespace TestsCodeception\Support;

/**
 * Inherited Methods
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Define custom actions here
     */

    public function logIn(): void
    {
        $this->amOnPage('/');
        $this->seeCurrentUrlEquals('/');
        $this->fillField('email', 'john.doe@gmail.com');
        $this->fillField('password', 'secret');
        $this->waitForNextPage(fn () => $this->click('Log in'));
    }

    public function waitForNextPage(callable $action): void
    {
        // @phpstan-ignore function.alreadyNarrowedType
        if (method_exists($this, 'waitForJS')) {
            $this->waitForJS('return document.oldPage = "yes"');
        }

        $action();

        // @phpstan-ignore function.alreadyNarrowedType
        if (method_exists($this, 'waitForJS')) {
            $this->waitForJS('return document.oldPage !== "yes"');
        }
    }

    public function addCard(): void
    {
        $this->amOnPage('/add-card');
        $this->fillField('number', '2131231231231231');
        $this->fillField('name', 'JohnDoe');
        $this->fillField('expiration_date', '0132');
        $this->fillField('cvv', '111');
        $this->waitForNextPage(fn () => $this->click('Submit'));
        $this->see('DELETE CARD');
    }
}
