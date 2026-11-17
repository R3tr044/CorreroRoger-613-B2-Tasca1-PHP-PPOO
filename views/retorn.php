<?php $multa = $biblioteca->retornarMaterial((int)($_GET['material_id'] ?? 0)); require __DIR__ . '/layout.php'; ?>
<h1>Retorn realitzat</h1><p>Multa: <?= number_format($multa, 2, ',', '.') ?> €</p></main></body></html>
