<?php
require __DIR__ . '/layout.php';
$type = $_GET['type'] ?? null;
$materials = match ($type) {
    'llibre' => $biblioteca->getLlibres(),
    'revista' => $biblioteca->getRevistes(),
    'dvd' => $biblioteca->getDVDs(),
    default => $biblioteca->getMaterials(),
};
?>
<h1>Materials</h1><p><a href="index.php?page=materials">Tots</a> <a href="index.php?page=materials&type=llibre">Llibres</a> <a href="index.php?page=materials&type=revista">Revistes</a> <a href="index.php?page=materials&type=dvd">DVDs</a></p>
<table><tr><th>ID</th><th>Material</th><th>Acció</th></tr><?php foreach ($materials as $m): ?><tr><td><?= $m->getId() ?></td><td><?= htmlspecialchars((string)$m) ?></td><td><a href="index.php?page=material&id=<?= $m->getId() ?>">Detall</a></td></tr><?php endforeach; ?></table></main></body></html>
