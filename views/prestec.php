<?php
$biblioteca->prestarMaterial((int)($_GET['material_id'] ?? 0), (int)($_GET['usuari_id'] ?? 0));
require __DIR__ . '/layout.php';
?><h1>Préstec realitzat</h1><p><a href="index.php?page=prestecs">Veure préstecs</a></p></main></body></html>
