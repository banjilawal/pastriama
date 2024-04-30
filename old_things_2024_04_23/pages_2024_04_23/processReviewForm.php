<?php declare(strict_types=1);

use app\models\concretes\NewReview;
use app\utils\SerialNumber;

if (empty(session_id())) {
    session_start();
}

require_once 'bootstrap.php';

$inventoryItem = unserialize($_SESSION['inventoryItem']);
$reviewsCatalog = unserialize($_SESSION['reviewsCatalog']);
$user = unserialize($_SESSION['user']);

$reviewTitle = null;
$rating = null;
$comment = null;
try {
    $reviewTitle = sanitize_input($_POST['reviewTitle']);
} catch (Exception $e) {
    echo $e;
}
try {
    $rating = (int)sanitize_input($_POST['rating']);
} catch (Exception $e) {
    echo $e;
}
try {
    $comment = sanitize_input($_POST['comment']);
} catch (Exception $e) {
    echo $e;
}

try {
    $reviewsCatalog->add(new NewReview(
            SerialNumber::nextReviewId(),
            $user,
            $inventoryItem->getPastry(),
            $rating,
            $reviewTitle,
            $comment,
            new DateTime()
        )
    );
} catch (Exception $e) {
    echo $e;
}
$_SESSION['reviewsCatalog'] = serialize($reviewsCatalog);
$_SESSION['reviewThankYouMessage'] = 'Thank you for your review ' . $user->printName();
header("Location: inventoryItemPage.php");
//exit; // Ensure that subsequent code is not executed