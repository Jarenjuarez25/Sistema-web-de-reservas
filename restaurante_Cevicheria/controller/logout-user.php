<?php
session_start();
session_destroy();
header("Location: /restaurante_Cevicheria/index.php");
exit();
?>
