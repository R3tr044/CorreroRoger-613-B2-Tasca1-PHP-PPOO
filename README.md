# Sistema de Gestió de Biblioteca Digital

Projecte de PHP orientat a objectes del mòdul M0613-B2.

## Instal·lació i execució

```text
composer install
php -S localhost:8000
```

Obre `http://localhost:8000/index.php`. Les dades inicials es guarden a la sessió; `index.php?page=reset` les reinicia.

## URLs

- `?page=inici`: resum.
- `?page=materials` i `&type=llibre|revista|dvd`: llistats i filtres.
- `?page=material&id=X`: detall i auditoria.
- `?page=usuaris` i `?page=usuari&id=X`: usuaris i perfil.
- `?page=prestec&material_id=X&usuari_id=Y`: crea un préstec.
- `?page=retorn&material_id=X`: retorna un material i calcula la multa.
- `?page=prestecs`: préstecs actius.
- `?page=reserva&material_id=X&usuari_id=Y` i `?page=reserves`: reserves.
- `?page=estadistiques` i `?page=auditoria`: informació del sistema.
- `?page=demo_magic`, `demo_serialization`, `demo_exceptions` i `demo_autoload`: demostracions.

El projecte usa namespaces PSR-4, classes abstractes, herència, una interfície, un trait, excepcions personalitzades i serialització de la sessió.

Vídeo de demostració: pendent d'afegir.
