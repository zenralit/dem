<?php

include "db.php";

$id = $_GET['id'];

mysqli_query($conn,
"UPDATE cards SET status='deleted' WHERE id='$id'");

header("Location: cards.php");

?>