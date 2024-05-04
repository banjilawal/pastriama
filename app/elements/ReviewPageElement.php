<?php

namespace app\elements;

use app\interfaces\Dashboard;
use app\models\concretes\review;
use app\elements\PageElement;
use app\utils\AssemblePage;
use Exception;

class ReviewPageElement extends PageElement implements Dashboard {

    private review $review;
    private string $dashboardHeading;

    /**
     * @param review $review
     */
    public function __construct (review $review) {
        parent::__construct($review->getTitle());
        $this->review = $review;
        $this->dashboardHeading = '';
    }

    public function getDashboardHeading (): string {
        return $this->dashboardHeading;
    }

    public function setDashboardHeading (string $dashboardHeading): void {
        $this->dashboardHeading = $dashboardHeading;
    }

    public function dashboard (): string {
        return
            '<div class="dashboard">'
            . $this->encapsulate('div', $this->dashboardHeading, 'dashboardHeading')
            . $this->encapsulate('div', '<h3>SHOW_AVERAGE_PRODUCT_RATING</h3>', 'dashboardItem')
            . $this->encapsulate('div', $this->review->toTable(), 'dashboardItem')
//            . $this->encapsulate('div', ($this->review->getPastry)addToCartForm(), 'dashboardItem')
//            . $this->encapsulate('div', $this->addOneClickBuyForm(), 'dashboardItem')
            . '</div>';
    }

    public function mainSection (): string {
        return '<main>' . '<h2>' . $this->getMainSectionHeading() . '</h2>' . $this->dashboard() . '</main>';
    }

    public function body (): string {
        return '';
        //return '<body>' . '<h1>' . $this->getBodyHeading() . '</h1>' . $this->mainSection() . '</body>';
    }

    public function page (): string {
        return AssemblePage::assemble($this);
    }
}