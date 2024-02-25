<?php
session_start();

echo "logging you out..... please wait....";

session_destroy();
header("Location: /php-tutorial/34_forum/index.php");
?>