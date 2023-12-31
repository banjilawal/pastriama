<?php declare(strict_types=1);

namespace app\models\singletons;

use app\models\abstracts\Model;
use App\Models\Concretes\Invoice;
use App\Models\Concretes\User;
use App\Models\Lists\InvoiceList;
use DateTime;
use Exception;

class InvoiceCatalog extends Model {
    private static InvoiceList $invoices;

    private function __construct () {
        self::$invoices = new InvoiceList();
    }

    public static function getCatalog(): InvoiceCatalog {
        if (!isset(self::$invoices)) {
            self::$invoices = new InvoiceCatalog;
        }
        return self::$invoices;
    }

    private function __clone () {}
    private function __wakeup () {}

    /**
     * @throws Exception
     */
    public function addInvoice (Invoice $invoice): void {
        if (array_key_exists($invoice->getid(), self::$invoices)) {
            throw new Exception($invoice . ' is already recorded');
        }
        self::$invoices[$invoice->getId()] = $invoice;
    }

    public function filterByDate (DateTime $startDate, DateTime $endDate): InvoiceList {
        return self::$invoices->filterByDateRange($startDate, $endDate);
    }

    /**
     * @throws Exception
     */
    public static function userSearch (User $user, DateTime $startDate, DateTime $endDate): InvoiceList {
        return (self::$invoices->filterByDateRange($$startDate, $endDate))->filterByUser($user);
    }
}