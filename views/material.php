<?php require __DIR__ . '/layout.php'; $material = $biblioteca->cercarPerId((int)($_GET['id'] ?? 0)); ?>
<h1><?= $material ? htmlspecialchars((string)$material) : 'Material no trobat' ?></h1>
<?php if ($material): ?><h2>Historial</h2><ul><?php foreach ($material->obtenirHistorial() as $accio): ?><li><?= htmlspecialchars($accio['data'].' - '.$accio['accio'].' '.$accio['detalls']) ?></li><?php endforeach; ?></ul><?php endif; ?></main></body></html>
