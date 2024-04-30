<?php declare(strict_types=1);

namespace old_things_2024_04_23\pages_2024_04_23;
require_once 'WebPage.php';

use app\models\collections\Users;
use app\test\ListGenerator;

class UserListPage extends WebPage {
    private Users $userList;

    public function __construct (Users $userList, string $title) {
        parent::__construct($title);
        $this->userList = $userList;
    }

    public function getUserList (): Users {
        return $this->userList;
    }
}

$users = null;
try {
    $users = ListGenerator::users(30);
} catch (Exception $e) {
}

$page = new UserListPage($users, 'Test Users');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        <?php echo $page->getTitle(); ?>
    </title>
</head>
<body>
<header>
</header>
<main>
    <?php
    echo $page->getUserList()->toTable();
    ?>
</main>
<footer>
</footer>
</body>
</html>