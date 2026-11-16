<?php
session_start();

if (isset($_SESSION['usuari'])) {
    header('Location: cataleg.php');
} else {
    header('Location: login.php');
}
exit;