<?php
// Busca un usuari per email; retorna l'array de l'usuari o null
function buscaUsuari(array $usuaris, string $email): ?array {
    foreach ($usuaris as $u) {
        if (strcasecmp($u['email'], $email) === 0) {
            return $u;
        }
    }
    return null;
}

// Retorna el total d'unitats físiques que hi ha al cistell
function unitatsCistell(array $cistell): int {
    return array_sum($cistell);
}

// Retorna l'import econòmic total del cistell
function totalCistell(array $cistell, array $productes): float {
    $total = 0.0;
    foreach ($cistell as $id => $quantitat) {
        if (isset($productes[$id])) {
            $total += $productes[$id]['preu'] * $quantitat;
        }
    }
    return $total;
}

// Guarda un missatge temporal (flash) a la sessió
function afegeixMissatge(string $text): void {
    $_SESSION['flash_msg'] = $text;
}

// Llegeix el missatge flash i l'elimina de la sessió immediatament
function llegeixMissatge(): ?string {
    if (isset($_SESSION['flash_msg'])) {
        $msg = $_SESSION['flash_msg'];
        unset($_SESSION['flash_msg']);
        return $msg;
    }
    return null;
}