<?php $biblioteca->reservarMaterial((int)($_GET['material_id'] ?? 0), (int)($_GET['usuari_id'] ?? 0)); require __DIR__ . '/layout.php'; ?>
<h1>Reserva realitzada</h1><p><a href="index.php?page=reserves">Veure reserves</a></p></main></body></html>
