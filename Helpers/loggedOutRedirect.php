<?php

if (is_null($_SESSION["userId"])) {
	header("Location: http://localhost:9999/login.php");
}

?>