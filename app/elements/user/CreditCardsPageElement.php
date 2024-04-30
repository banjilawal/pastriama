<?php

namespace app\elements\user;

use app\enums\CreditCardProvider;
use app\enums\Month;
use app\models\collections\CreditCards;
use app\elements\Generate;
use app\elements\PageElement;
use app\test\NewEntityGenerator;
use DateTime;

class CreditCardsPageElement extends PageElement {

    private CreditCards $creditCards;
    private string $nameOnCard;

    /**
     * @param CreditCards $creditCards
     */
    public function __construct (CreditCards $creditCards, string $title) {
        parent::__construct($title);
        $this->nameOnCard = '';
        $this->creditCards = $creditCards;
    }

    public function getNameOnCard (): string {
        return $this->nameOnCard;
    }

    public function setNameOnCard (string $nameOnCard): void {
        $this->nameOnCard = $nameOnCard;
    }

    public function addCardForm (): string {
        return '<div class="popForm>'
            . '<form id="addCreditCardForm" name="addCreditCardForm" method="post" action="app/processors/processAddCardForm.php">'
                . '<fieldset name="cardInformationFieldset" id="cardInformationFieldset">'
                    . '<legend>Credit Card Information</legend>'
                    . '<div class="formElement">' . CreditCardProvider::selector() . '</div>'
                    . '<div class="formElement">'
                        . '<p>'
                            . '<label for="nameOnCard">Card Holder</label>'
                            . '<input type="text" id="nameOnCard" name="nameOnCard" size="100" required value="' . $this->nameOnCard . '">'
                        . '</p>'
                    . '</div>'
                    . '<div class="formElement">'
                        . '<p>'
                            . '<label for="number">Card Number</label>'
                            . '<input
                                type="text"
                                id="number"
                                name="number"
                                pattern="[0-9]{4,5}( [0-9]{4,5}){3,4}"
                                size="40"
                                required
                                title="Please enter the credit card number"'
                            . '>'
                        . '</p>'
                    . '</div>'
                    . '<div class="formElement">'
                        . '<p>'
                            . '<label for="cvn">CVN</label>'
                            . '<input
                                type="text"
                                id="cvn"
                                name="cvn"
                                pattern="[0-9]{3,4}"
                                size="4"
                                required
                                title="Please enter the 3-4 digit CVN number on the back of your card"'
                            . '>'
                        . '</p>'
                    . '</div>'
                . '<div class="formElement"><p>' . Month::selector()
                . ' ' . NewEntityGenerator::yearSelector(DateTime::createFromFormat('Y', date('Y')))
                . '</div>'
                . '<div class="formElement">'
                    . '<p>'
                        . '<input type="reset" name="cancelButton" id="cancelButton" value="Cancel">&nbsp'
                        . '<input type="submit" name=submitButton" id="submitButton" value="Submit">'
                    . '</p>'
                . '</div>'
                . '</fieldset>'
            . '</form>'
        . '</div>';
    }

    public function removeCardForm (): string {
        $elem = '';
        return $elem;
    }

    public function body (): string {
        return '<body><h1>Your Credit Cards</h1>'
            . '<div class="message" hidden><h3 class="message" hidden>' . $this->getStatusMessage() . '</h3></div>'
            . '<div class="dashboard">'
            . '<div class="dashboardItem">' . $this->creditCards->toTable() . '</div>'
            . '<div class="dashboardItem">' . $this->addCardForm() . '</div>'
            . '<div class="dashboardItem">' . $this->removeCardForm(). '</div>'
        . '</body>';
    }

    public function page (): string {
        return Generate::htmlHead($this->getTitle())
            . Generate::header()
            . Generate::navbar()
            . $this->body()
            . Generate::footer();
    }
}