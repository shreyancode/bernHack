<?php
session_start();
session_destroy();

header("Location: /bernhack/frontend/login.html");
exit();

?>