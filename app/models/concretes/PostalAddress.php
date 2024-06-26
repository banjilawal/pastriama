<?php declare(strict_types=1);

namespace app\models\concretes;

use app\enums\MailingCategory;
use app\enums\State;
use app\interfaces\adapters\GetId;
use app\models\abstracts\Address;


class PostalAddress extends Address implements GetId {
    private int $id;
    private string $street;
    private string $city;
    private State  $state;
    private Zipcode  $zipcode;
    private MailingCategory $mailingCategory;
    private int $totalDeliveries;

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
        $this->totalDeliveries = 0;
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

    public function getTotalDeliveries (): int {
        return $this->totalDeliveries;
    }

    public function setMailingCategory (MailingCategory $category): void {
        $this->mailingCategory = $category;
    }

    public function incrementTotalDeliveries (): void {
        $this->totalDeliveries++;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof PostalAddress) {
            return parent::equals($object)
                && $this->id === $object->getId()
                && $this->street === $object->getStreet()
                && $this->city === $object->getCity()
                && $this->state === $object->getState()
                && $this->zipcode->equals($object->getZipcode())
                && $this->totalDeliveries === $object->getTotalDeliveries();
        }
        return false;
    }

    public function __toString (): string {
        return  $this->street . ' ' . $this->city . ', ' . $this->state->value . ' ' . $this->zipcode;
    }
}