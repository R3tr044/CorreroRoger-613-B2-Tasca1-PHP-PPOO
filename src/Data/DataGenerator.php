<?php
namespace App\Data;
use App\Models\Biblioteca;
use App\Models\Llibre;
use App\Models\Revista;
use App\Models\DVD;
use App\Models\Usuari;

class DataGenerator
{
    public static function crear(): Biblioteca
    {
        $b = new Biblioteca('Biblioteca Digital');
        foreach ([
            new Llibre(1, 'El nom de la rosa', 'Umberto Eco', 1980, 512),
            new Llibre(2, '1984', 'George Orwell', 1949, 328),
            new Llibre(3, 'Dune', 'Frank Herbert', 1965, 688),
            new Llibre(4, 'La plaça del Diamant', 'Mercè Rodoreda', 1962, 240),
            new Revista(5, 'National Geographic', 'Diversos autors', 2024, 125),
            new Revista(6, 'Muy Interesante', 'Diversos autors', 2024, 490),
            new Revista(7, 'Nature', 'Diversos autors', 2024, 830),
            new DVD(8, 'Matrix', 'Lana i Lilly Wachowski', 1999, 136),
            new DVD(9, 'Interstellar', 'Christopher Nolan', 2014, 169),
            new DVD(10, 'El viatge de Chihiro', 'Hayao Miyazaki', 2001, 125),
        ] as $material) $b->afegirMaterial($material);
        foreach ([
            new Usuari(1, 'Anna Puig', 'anna@mail.com'),
            new Usuari(2, 'Joan Serra', 'joan@mail.com'),
            new Usuari(3, 'Maria Soler', 'maria@mail.com'),
            new Usuari(4, 'Pau Vidal', 'pau@mail.com'),
        ] as $usuari) $b->afegirUsuari($usuari);
        $b->prestarMaterial(1, 1, (new \DateTime())->modify('-20 days'));
        $b->prestarMaterial(8, 2);
        $b->reservarMaterial(3, 3);
        return $b;
    }
}
