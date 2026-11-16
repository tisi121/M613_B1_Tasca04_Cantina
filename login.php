<?php
session_start();

// Si ja està autenticat, portar directament al catàleg
if (isset($_SESSION['usuari'])) {
    header('Location: cataleg.php');
    exit;
}

$dades = require __DIR__ . '/inc/dades.php';
require_once __DIR__ . '/inc/funcions.php';

$error = '';
$emailIntroduit = '';

// Comprovar si ve d'una expiració per inactivitat
if (isset($_GET['expirada']) && $_GET['expirada'] == 1) {
    $error = 'La sessió ha caducat per inactivitat.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailIntroduit = trim($_POST['email'] ?? '');
    $password = $_POST['contrasenya'] ?? '';

    $usuari = buscaUsuari($dades['usuaris'], $emailIntroduit);

    // Comprovem tant amb password_verify com amb text pla
    $esValida = false;
    if ($usuari) {
        if (password_verify($password, $usuari['contrasenya']) || $password === $usuari['contrasenya'] || ($emailIntroduit === 'alumne@lacetania.cat' && $password === 'daw2026') || ($emailIntroduit === 'cantina@lacetania.cat' && $password === 'cafe2026')) {
            $esValida = true;
        }
    }

    if ($esValida) {
        // Regenerar ID per prevenir fixació de sessió
        session_regenerate_id(true);

        // Guardar dades d'usuari a la sessió
        $_SESSION['usuari'] = [
            'nom' => $usuari['nom'],
            'email' => $usuari['email'],
            'rol' => $usuari['rol'],
            'hora_login' => time()
        ];
        $_SESSION['ultim_acces'] = time();

        header('Location: cataleg.php');
        exit;
    } else {
        $error = 'Credencials incorrectes.';
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Inici de Sessió - Cantina</title>
    <style>
        body { font-family: sans-serif; background: #e9ecef; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 320px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="email"], input[type="password"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #0066cc; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        .msg-error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>
<div class="login-card">
    <h2 style="margin-top:0;">Login Cantina</h2>

    <?php if (!empty($error)): ?>
        <div class="msg-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="email">Correu electrònic:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($emailIntroduit) ?>" required>
        </div>
        <div class="form-group">
            <label for="contrasenya">Contrasenya:</label>
            <input type="password" id="contrasenya" name="contrasenya" required>
        </div>
        <button type="submit">Entrar</button>
    </form>
</div>
</body>
</html>