<?php require __DIR__ . '/layout.php'; $s = $biblioteca->obtenirEstadistiques(); ?>
<h1>Estadístiques</h1>
<ul>
    <li>Total: <?= $s['total'] ?></li>
    <li>Disponibles: <?= $s['disponibles'] ?></li>
    <li>Prestats: <?= $s['prestats'] ?></li>
    <li>Reservats: <?= $s['reservats'] ?></li>
    <li>Multes pendents: <?= number_format($s['multesPendents'], 2, ',', '.') ?> €</li>
</ul>
<h2>Materials per tipus</h2>
<ul>
    <?php foreach ($s['perTipus'] as $tipus => $total): ?>
        <li><?= htmlspecialchars($tipus) ?>: <?= $total ?></li>
    <?php endforeach; ?>
</ul>
</main></body></html>
