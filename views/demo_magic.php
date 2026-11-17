<?php
require __DIR__ . '/layout.php';
$llibre = $biblioteca->getLlibres()[0];
$usuari = $biblioteca->cercarUsuari(1);
?>
<h1>Mètodes màgics</h1>
<p><?= htmlspecialchars((string)$llibre) ?></p>
<p>Nom de la biblioteca amb __call: <?= htmlspecialchars($biblioteca->getNom()) ?></p>
<p>Títol amb __call: <?= htmlspecialchars($biblioteca->getLlibres()[0]->getTitol()) ?></p>
<p>Email amb __get: <?= htmlspecialchars($usuari->email) ?></p>
<?php
$emailOriginal = $usuari->email;
$usuari->email = 'anna.nova@mail.com';
?>
<p>Email modificat amb __set: <?= htmlspecialchars($usuari->email) ?></p>
<?php try { $usuari->nom = 'No permès'; } catch (\LogicException $e) { ?>
<p>__set no permès: <?= htmlspecialchars($e->getMessage()) ?></p>
<?php } ?>
<?php try { $biblioteca->metodeInexistent(); } catch (\BadMethodCallException $e) { ?>
<p>Mètode inexistent: <?= htmlspecialchars($e->getMessage()) ?></p>
<?php } $usuari->email = $emailOriginal; ?>
</main></body></html>
