<?php declare(strict_types=1);

namespace app\models\concretes;

use app\enums\MailingCategory;
use app\enums\State;
use app\interfaces\Identifiable;
use app\models\abstracts\Address;


class PostalAddress extends Address implements Identifiable {
    private int $id;
    private string $street;
    private string $city;
    private State  $state;
    private Zipcode  $zipcode;
    private MailingCategory $mailingCategory;

    /**
     * @param int $id
     * @param string $street
     * @param string $city
     * @param State $state
     * @param Zipcode $zipcode
     * @param MailingCategory $mailingCategory
     */
    public function __construct (
        int $id,
        string $street,
        string $city,
        State $state,
        Zipcode $zipcode,
        MailingCategory $mailingCategory=MailingCategory::DEFAULT_MAILING_ADDRESS
    ) {
        parent::__construct();
        $this->id = $id;
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->zipcode = $zipcode;
        $this->mailingCategory = $mailingCategory;
    }

    public function getId (): int {
        return $this->id;
    }

    public function getStreet (): string {
        return $this->street;
    }

    public function getCity (): string {
        return $this->city;
    }

    public function getState (): State {
        return $this->state;
    }

    public function getZipcode (): Zipcode {
        return $this->zipcode;
    }

    public function getMailingCategory (): MailingCategory {
        return $this->mailingCategory;
    }

    public function setId (int $id): void {
        $this->id = $id;
    }

    public function setStreet (string $street): void {
        $this->street = $street;
    }

    public function setCity (string $city): void {
        $this->city = $city;
    }

    public function setState (State $state): void {
        $this->state = $state;
    }

    public function setZipcode (Zipcode $zipcode): void {
        $this->zipcode = $zipcode;
    }

    public function setMailingCategory (MailingCategory $category): void {
        $this->mailingCategory = $category;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof PostalAddress) {
            return parent::equals($object)
                && $this->street === $object->getStreet()
                && $this->city === $object->getCity()
                && $this->state === $object->getState()
                && $this->zipcode->equals($object->getZipcode());
        }
        return false;
    }

    public function __toString (): string {
        return  $this->street . ' ' . $this->city . ', ' . $this->state->code() . ' ' . $this->zipcode;
    }

//    public function toRow (): string {
//        return '<tr>'
//            . '<td>street</td>' . '<td>' . $this->street . '</td>'
//            . '<td>city</td>' . '<td>' . $this->city . '</td>'
//            . '<td>state</td>' . '<td>' . $this->state->code() . '</td>'
//            . '<td>zipcode</td>' . '<td>' . $this->zipcode . '</td>'
//            . '</tr>';
//    }

    public function toTable (): string {
        return '<table  id="postalAddressTable>'
            . '<thead>'
            . '<tr>'
            .   '<th>Street</th>'
            .   '<th>City</th>'
            .   '<th>State</th>'
            .   '<th>Zip</th>'
            .   '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->street . '</td>'
            . '<td>' . $this->city . '</td>'
            . '<td>' . $this->state->code() . '</td>'
            . '<td>' . $this->zipcode . '</td>'
            . '</tr>'
            . '</tbody>'
            . '</table>';
    }
}