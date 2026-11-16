<?php
session_start();

// Buidar totes les variables de sessió
$_SESSION = [];

// Esborrar la cookie de sessió si existeix
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruir la sessió
session_destroy();

header('Location: login.php');
exit;