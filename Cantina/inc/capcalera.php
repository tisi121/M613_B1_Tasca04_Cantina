<?php
// Assegurem que el cistell existeix per comptar unitats
$cistellActual = $_SESSION['cistell'] ?? [];
$numUnitats = unitatsCistell($cistellActual);
$missatgeFlash = llegeixMissatge();
$nomUsuari = $_SESSION['usuari']['nom'] ?? '';
$rolUsuari = $_SESSION['usuari']['rol'] ?? '';
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantina de l'Institut</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; background-color: #f7f9fa; color: #333; }
        header { background: #fff; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        nav { display: flex; justify-content: space-between; align-items: center; }
        nav a { margin-right: 15px; text-decoration: none; color: #0066cc; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        .flash { background: #d4edda; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb; }
        .danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        table { width: 100%; border-collapse: collapse; background: #fff; margin-top: 15px; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f1f3f5; }
        .btn { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 14px; }
        .btn-primary { background: #0066cc; color: #fff; }
        .btn-danger { background: #dc3545; color: #fff; }
        .btn-success { background: #28a745; color: #fff; }
    </style>
</head>
<body>
<header>
    <nav>
        <div>
            <a href="cataleg.php">Catàleg</a>
            <a href="cistell.php">Cistell (<?= $numUnitats ?>)</a>
            <?php if ($rolUsuari === 'admin'): ?>
                <a href="admin.php" style="color: #6f42c1;">[Admin]</a>
            <?php endif; ?>
        </div>
        <div>
            Hola, <strong><?= htmlspecialchars($nomUsuari) ?></strong> | 
            <a href="logout.php" style="color: #dc3545;">Tancar sessió</a>
        </div>
    </nav>
</header>

<?php if ($missatgeFlash): ?>
    <div class="flash">
        <?= htmlspecialchars($missatgeFlash) ?>
    </div>
<?php endif; ?>