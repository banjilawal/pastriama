<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\Entity;

class PageLink extends Entity {

    private string $destination;
    private string $text;


    /**
     * @param string $text
     * @param string $destination
     */
    public function __construct (int $id, string $destination, string $text) {
        parent::__construct($id);
        $this->text = $text;
        $this->destination = $destination;
    }

    public function getText (): string {
        return $this->text;
    }

    public function getDestination (): string {
        return $this->destination;
    }

    public function setText (string $text): void {
        $this->text = $text;
    }

    public function setDestination (string $destination): void {
        $this->destination = $destination;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof  PageLink) {
            return $this->destination === $object->getDestination() && $this->getText();
        }
        return false;
    }

    public function __toString (): string {
        return '<a href="' . $this->destination . '">' . $this->text . '</a>';
    }

    public function embed (string $openingTag, string $closingTag): string {
        return $openingTag . $this . $closingTag;
    }

    public function createFile () {

    }
}