<?php
session_start();
session_destroy();
header("Location: ../Presentation/backend.php");
exit;
