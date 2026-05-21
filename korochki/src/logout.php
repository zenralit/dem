<?php
session_start();
session_destroy();
header("Location: auto.php");
exit();
?>