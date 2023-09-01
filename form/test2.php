<?php     
    echo '<p>referer: '; # . print_r($_SERVER) . '</p>'; 
    echo $_SERVER['PHP_SELF'];
echo "<br>";
echo $_SERVER['SERVER_NAME'];
echo "<br>";
echo $_SERVER['HTTP_HOST'];
echo "<br>";
echo $_SERVER['HTTP_REFERER'];
echo print_r($_SERVER);
?>

