<?php

namespace pages;

use app\models\collections\InvoiceItems;
use app\models\concretes\Pastry;

class Table {


    public function products (InvoiceItems $products): string {
        $elem = '<table id=">'
            . '<thead>'
            . '<tr>'
            . '<th>ID</th>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '<th>Quantity</th>'
            . '<th>Cost</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->list as $id => $item) {
            $elem .= $this->list[$id]->toRow();
        }
//            $elem .= '<tr onclick="send(' . $id . ')">'
//                . '<td>' . $id . '</td>'
//                . '<td>' . $item->getPastry()->getImgTag() . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
//                . '<td>' . $item->getPastry()->getName() . '</td>'
//                . '<td>' . $item->getPastry()->getDescription() . '</td>'
//                . '<td>' . number_format($item->getPastry()->getPrice(), 2) . '</td>'
//                . '<td>' .  '</td>'
//                . '<td>' . $pastry->getReveiws(
//                    DateTime::createFromFormat('Y-m-d', '2020-01-01'),
//                    DateTime::createFromFormat('Y-m-d', '2029-01-01')
//                )->getAverageRating() . '</td>'
//                . '</tr>';
//        }
        $elem .= '</tbody></table>';
        return $elem;
//        foreach ($this->items as $item) {
////            echo $item . '<br>' . PHP_EOL;
//            $elem .= $item->toRow();
//        }
//        $elem .= '<tr><td>Tax</td><td>' . number_format($this->getTax(), 2) . '</td></tr>'
//            . '<tr><td>Total</td><td>' . number_format($this->getTotalCharge(), 2)  . '</td></tr>'
//            . '</tbody></table>';
//        return $elem;
    }


}