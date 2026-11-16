<?php
// Temps màxim d'inactivitat permès (10 minuts = 600 segons)
$timeout = 600;

// Comprovar si l'usuari té sessió iniciada
if (!isset($_SESSION['usuari'])) {
    header('Location: login.php');
    exit;
}

// Comprovar timeout per inactivitat
if (isset($_SESSION['ultim_acces'])) {
    if ((time() - $_SESSION['ultim_acces']) > $timeout) {
        // Sessió caducada: buidem i destruïm
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header('Location: login.php?expirada=1');
        exit;
    }
}

// Actualitzem l'hora de l'últim accés a cada petició
$_SESSION['ultim_acces'] = time();