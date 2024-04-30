<?php

namespace app\elements;

use app\interfaces\Dashboard;
use app\models\concretes\NewOrder;
use app\models\concretes\NewReview;
use app\elements\PageElement;
use app\utils\AssemblePage;

class OrderPageElement extends PageElement implements Dashboard {

    private NewOrder $order;
    private string $dashboardHeading;

    /**
     * @param NewOrder $order
 */
    public function __construct (NewOrder $order) {
        parent::__construct($order->__toString());
        $this->order = $order;
        $this->dashboardHeading = '';
    }

    public function getDashboardHeading (): string {
        return $this->dashboardHeading;
    }

    public function setDashboardHeading (string $dashboardHeading): void {
        $this->dashboardHeading = $dashboardHeading;
    }

    public function dashboard (): string {
        // TODO: Implement dashboard() method.
    }

    public function mainSection (): string {
        return '<main>' . '<h2>' . $this->getMainSectionHeading() . '</h2>' . $this->dashboard() . '</main>';
    }

    public function body (): string {
        return '';
    }

    public function page (): string {
        return AssemblePage::assemble($this);
    }
}