<?php declare(strict_types=1);
namespace {
    require_once 'vendor/autoload.php';
    require_once 'constants.php';


    /**
     * @throws Exception
     */
    function sanitize_input ($data): string {
        if (!isset($data)) {
            Throw new \Exception($data . ' Cannot process null data');
        }
        $data = trim($data, " \t\n\r\0\x0B.");
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    function println (string $string) : string {
        return nl2br($string . PHP_EOL);
    }

    function yearSelector (
        DateTime $startYear,
        int $numberOfYears=5,
        string $id='expirationYear',
        string $label='Expiration Year'
    ): string {
        $currentYear= (int) date('Y');
        $elem = '<label for="' . $id . '">' . $label . '</label>'
            . '<select name=' . $id . '" id="' . $id . '">';
        for ($i = 0; $i < $numberOfYears; $i++) {
            $year = $currentYear + $i;
            $elem .= '<option value="' . $year . '">' . $year . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }
}