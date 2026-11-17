<?php require __DIR__ . '/layout.php'; ?>
<h1><?= htmlspecialchars($biblioteca->getNom()) ?></h1>
<?php $stats = $biblioteca->obtenirEstadistiques(); ?>
<p>Total: <?= $stats['total'] ?> · Disponibles: <?= $stats['disponibles'] ?> · Prestats: <?= $stats['prestats'] ?></p>
<p><a href="index.php?page=materials">Veure materials</a> · <a href="index.php?page=estadistiques">Estadístiques</a></p>
</main></body></html>
