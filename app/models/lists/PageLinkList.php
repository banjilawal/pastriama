<?php

namespace app\models\lists;

use app\models\concretes\PageLink;
use app\pages\Exception;

class PageLinkList {

    private array $links;
    public function __construct () {
        $this->links = array();
    }

    public function getLinks (): PageLink|array {
        return $this->links;
    }

    public function addLinks (PageLink|array $links): void {
        foreach ($links as $link) {
            if ($link instanceof PageLink)
                $this->add($link);
        }
    }

    public function add (PageLink $link): void {
        $this->links[] = $link;
//        $destination = $link->getDestination();
//        if (array_key_exists($destination, $this->links))
//            throw new Exception('There is already a reference to ' . $link->getDestination());
//        $this->links[$destination] = $link;
    }

    public function removeLinks (PageLink|array $links): void {
        foreach ($links as $link) {
            if ($link instanceof PageLink)
                $this->remove($link);
        }
    }

    public function remove (PageLink $link): void {
        $destination = $link->getDestination();
        if (!array_key_exists($destination, $this->links))
            throw new Exception('Cannot remove link ' . $link->getDestination() . ' it does not exist in the collection.');
        unset($this->links[$destination]);
    }

    public function __toString (): string {
        $string = '';
        foreach ($this->links as $link) {
            $string .= $link . '<br>' . PHP_EOL;
        }
        return $string;
    }

    public function toList (): string {
        $elem= '<ul>';
        foreach ($this->links as $link) {
            $elem .= '<li>' . $link . '</li>';
        }
        $elem .= '</ul>';
        return $elem;
    }

    public function toTable (int $numColumns=4): string {
        $numRows = count($this->links) / $numColumns;

        $elem = '<table><thead><tr>';
        $elem .= str_repeat('<th></th>', $numColumns);
        $elem .= '</tr></thead><tbody>';

        $index = 0;
        foreach ($this->links as $link) {
            if ($index % $numColumns == 0)
                $elem .= '<tr>';
            else if ($index % $numColumns == ($numColumns - 1))
                $elem .= '<td>' . $link . '</td><</tr>';
            else
                $elem .= '<td>' . $link . '</td>';
            $index++;
        }
//        for ($index = 0; $index < count($this->links); $index++) {
//            $elem .= '<tr>';
//            if (($index + 1) % $columnCount == 0) {
//                $elem .= '</tr><tr>';
//            }
//        }
//
//        foreach ($this->links as $link) {
//            $elem .= '<tr><td>' . $link . '</td></tr>';
//        }
//        echo $columnCount . 'x' . $rowCount;
//        for ($rowIndex = 0; $rowIndex < $rowCount; $rowIndex++) {
//            $elem .= '<tr>';
//            echo $elem;
//            for ($columnIndex = 0; ($columnIndex % $columnCount) != 0; $columnIndex++) {
//                $elem .= '<td>' . $this->links[$columnIndex] . '</td>';
//                echo $columnIndex . ' ' .  $rowIndex . ' ' . $this->links . '<br>' . PHP_EOL;
//            }
//            $elem .= '</tr>';
//        }
        $elem .= '</tbody></table>';
        return $elem;
    }

//    private function getTableDimensions (int $columnCount=4): array {
//        $itemCount = count($this->links);
//        if (($itemCount % 4) === 0)
//            $columnCount = $itemCount % 4;
//        $rowCount = ceil(count($this->links) / $columnCount);
//        return [$columnCount, $rowCount];
//    }
}