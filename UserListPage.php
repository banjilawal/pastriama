<?php declare(strict_types=1);

require_once 'WebPage.php';

use app\models\lists\UserList;
use app\test\ListGenerator;

class UserListPage extends WebPage {
    private UserList $userList;

    public function __construct (Userlist $userList, string $title) {
        parent::__construct($title);
        $this->userList = $userList;
    }

    public function getUserList (): UserList {
        return $this->userList;
    }
}

$users = null;
try {
    $users = ListGenerator::userList(30);
} catch (Exception $e) {}

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