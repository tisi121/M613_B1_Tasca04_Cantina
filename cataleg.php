<?php
session_start();

require_once __DIR__ . '/inc/protegeix.php';
$dades = require __DIR__ . '/inc/dades.php';
require_once __DIR__ . '/inc/funcions.php';

// Inicialitzar el cistell si no existeix
if (!isset($_SESSION['cistell'])) {
    $_SESSION['cistell'] = [];
}

// Processament de la compra
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $quantitat = isset($_POST['quantitat']) ? (int)$_POST['quantitat'] : 0;

    // Validació estricta: l'ID ha d'existir i la quantitat entre 1 i 5
    if (isset($dades['productes'][$id]) && $quantitat >= 1 && $quantitat <= 5) {
        $nomProd = $dades['productes'][$id]['nom'];

        // Si ja existeix al cistell en sumem la quantitat
        if (isset($_SESSION['cistell'][$id])) {
            $_SESSION['cistell'][$id] += $quantitat;
        } else {
            $_SESSION['cistell'][$id] = $quantitat;
        }

        // Missatge Flash i redirecció per evitar reenviament de formulari
        afegeixMissatge("S'han afegit $quantitat x $nomProd al cistell.");
        header('Location: cataleg.php');
        exit;
    }
}

require_once __DIR__ . '/inc/capcalera.php';
?>

<h2>Catàleg de Productes</h2>

<table>
    <thead>
        <tr>
            <th>Producte</th>
            <th>Preu</th>
            <th style="width: 220px;">Acció</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dades['productes'] as $id => $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['nom']) ?></td>
                <td><?= number_format($p['preu'], 2, ',', '.') ?> €</td>
                <td>
                    <form action="" method="post" style="display:flex; gap:8px; align-items:center;">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="number" name="quantitat" value="1" min="1" max="5" style="width: 50px; padding: 4px;">
                        <button type="submit" class="btn btn-primary">Afegir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/inc/peu.php'; ?>