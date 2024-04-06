<?php declare(strict_types=1);
    namespace app\oldpages;

    require_once '..\..\bootstrap.php';

    use app\test\GenerateTestPastries;

    class OldProductPage {}


    const IMAGE_WIDTH = 90;
    const IMAGE_HEIGHT = 100;

    const DASHBOARD_IMAGE_WIDTH = 350;
    const DASHBOARD_IMAGE_HEIGHT = 400;

    $pastryList = null;
    try {
        $pastryList = GenerateTestPastries::pastryList();
    } catch (\Exception $e) {
    }
    $_SESSION['pastries'] = serialize($pastryList);

    //echo $pastryList->toDashboard(DASHBOARD_IMAGE_WIDTH, DASHBOARD_IMAGE_HEIGHT);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title>Welcome to Pastriama. Get fresh, hometown pastries delivered to you today or when ever you like</title>
    </head>
    <body>
        <header>
            <h1>Welcome to Pastriama. Get fresh, hometown pastries delivered to you today or when ever you like</h1>
        </header>
        <main>
            <?php
                echo $pastryList->toTable(IMAGE_HEIGHT, IMAGE_WIDTH);
               // echo $pastryList->toDashboard(DASHBOARD_IMAGE_WIDTH, DASHBOARD_IMAGE_HEIGHT);
            ?>

            <script>
                function rowClickHandler(row) {
                    var data = row.childNodes[0];
                    var cell = row.cells[0];
                    alert(cell);
                    var cookie = document.cookie = "array-index=" + cell.innerHTML; // + "; max-age=5";

                    location.href = "PastryPage.php";
                }
            </script>
        </main>
        <footer>
        </footer>
    </body>
</html>