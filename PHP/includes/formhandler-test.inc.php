<?php

session_start();

session_unset();

session_destroy();

header("Location: ../../HTML/restaurant-LiChun-project.php");
exit();
// Кнопка выхода из сесси в admin_dashboard