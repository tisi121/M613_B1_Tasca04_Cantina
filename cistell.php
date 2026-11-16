<?php
session_start();

require_once __DIR__ . '/inc/protegeix.php';
$dades = require __DIR__ . '/inc/dades.php';
require_once __DIR__ . '/inc/funcions.php';

if (!isset($_SESSION['cistell'])) {
    $_SESSION['cistell'] = [];
}
if (!isset($_SESSION['comandes'])) {
    $_SESSION['comandes'] = [];
}

// Processament d'accions (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accio = $_POST['accio'] ?? '';

    // 1. Treure un producte del cistell
    if ($accio === 'treure' && isset($_POST['id'])) {
        $id = (int)$_POST['id'];
        unset($_SESSION['cistell'][$id]);
        header('Location: cistell.php');
        exit;
    }

    // 2. Buidar tot el cistell
    if ($accio === 'buidar') {
        $_SESSION['cistell'] = [];
        header('Location: cistell.php');
        exit;
    }

    // 3. Finalitzar comanda
    if ($accio === 'finalitzar' && !empty($_SESSION['cistell'])) {
        $total = totalCistell($_SESSION['cistell'], $dades['productes']);
        
        // Guardem la comanda a l'historial de la sessió
        $_SESSION['comandes'][] = [
            'hora' => date('H:i:s'),
            'total' => $total,
            'linies' => $_SESSION['cistell']
        ];

        // Buidem el cistell
        $_SESSION['cistell'] = [];

        // Missatge Flash
        afegeixMissatge("Comanda enviada: " . number_format($total, 2, ',', '.') . " €");
        header('Location: cistell.php');
        exit;
    }
}

$totalPagar = totalCistell($_SESSION['cistell'], $dades['productes']);

require_once __DIR__ . '/inc/capcalera.php';
?>

<h2>El teu Cistell</h2>

<?php if (empty($_SESSION['cistell'])): ?>
    <div style="background:#fff; padding:20px; border-radius:8px;">
        <p>El cistell és buit.</p>
        <p><a href="cataleg.php" class="btn btn-primary">Anar al Catàleg</a></p>
    </div>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Producte</th>
                <th>Preu unitat</th>
                <th>Quantitat</th>
                <th>Subtotal</th>
                <th>Acció</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cistell'] as $id => $quantitat): ?>
                <?php 
                    $prod = $dades['productes'][$id] ?? null;
                    if (!$prod) continue;
                    $subtotal = $prod['preu'] * $quantitat;
                ?>
                <tr>
                    <td><?= htmlspecialchars($prod['nom']) ?></td>
                    <td><?= number_format($prod['preu'], 2, ',', '.') ?> €</td>
                    <td><?= $quantitat ?></td>
                    <td><?= number_format($subtotal, 2, ',', '.') ?> €</td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="accio" value="treure">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <button type="submit" class="btn btn-danger">Treure</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align: right;">Total:</th>
                <th colspan="2"><?= number_format($totalPagar, 2, ',', '.') ?> €</th>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 20px; display: flex; gap: 10px;">
        <form action="" method="post">
            <input type="hidden" name="accio" value="buidar">
            <button type="submit" class="btn btn-danger">Buidar el cistell</button>
        </form>

        <form action="" method="post">
            <input type="hidden" name="accio" value="finalitzar">
            <button type="submit" class="btn btn-success">Finalitzar comanda</button>
        </form>
    </div>
<?php endif; ?>

<!-- Llista de comandes realitzades a la sessió -->
<?php if (!empty($_SESSION['comandes'])): ?>
    <h3 style="margin-top: 40px;">Comandes fetes en aquesta sessió</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Hora</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['comandes'] as $num => $cmd): ?>
                <tr>
                    <td><?= $num + 1 ?></td>
                    <td><?= htmlspecialchars($cmd['hora']) ?></td>
                    <td><?= number_format($cmd['total'], 2, ',', '.') ?> €</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once __DIR__ . '/inc/peu.php'; ?>