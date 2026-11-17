<?php
namespace App\Models;
use App\Interfaces\Reservable;
use App\Exceptions\MaterialNoTrobatException;
use App\Exceptions\MaterialNoDisponibleException;
use App\Exceptions\MaterialNoPrestatException;
use App\Exceptions\UsuariNoTrobatException;

class Biblioteca
{
    private array $materials = [];
    private array $usuaris = [];
    private array $prestecs = [];
    public function __construct(private string $nom) {}
    public function afegirMaterial(Material $material): void { $this->materials[$material->getId()] = $material; }
    public function eliminarMaterial(int $id): bool { if (!isset($this->materials[$id])) return false; unset($this->materials[$id]); return true; }
    public function cercarPerId(int $id): ?Material { return $this->materials[$id] ?? null; }
    public function cercarPerTitol(string $titol): array { return array_values(array_filter($this->materials, fn(Material $m) => stripos($m->getTitol(), $titol) !== false)); }
    public function cercarPerAutor(string $autor): array { return array_values(array_filter($this->materials, fn(Material $m) => stripos($m->getAutor(), $autor) !== false)); }
    public function llistarDisponibles(): array { return array_values(array_filter($this->materials, fn(Material $m) => $m->isDisponible())); }
    public function llistarPrestats(): array { return array_values(array_filter($this->materials, fn(Material $m) => !$m->isDisponible())); }
    public function llistarPerTipus(string $tipus): array { return array_values(array_filter($this->materials, fn(Material $m) => $m->getTipus() === $tipus)); }
    public function llistarPrestecsActius(): array { return array_values(array_filter($this->prestecs, fn(Prestec $p) => $p->estaActiu())); }
    public function llistarReserves(): array { return array_values(array_filter($this->materials, fn(Material $m) => $m instanceof Reservable && $m->estaReservat())); }
    public function llistarPrestecsUsuari(int $usuariId): array { return array_values(array_filter($this->prestecs, fn(Prestec $p) => $p->getUsuari()->id === $usuariId)); }
    public function afegirUsuari(Usuari $usuari): void { $this->usuaris[$usuari->id] = $usuari; }
    public function cercarUsuari(int|string $identificador): ?Usuari
    {
        if (is_int($identificador)) return $this->usuaris[$identificador] ?? null;
        foreach ($this->usuaris as $usuari) if ($usuari->nom === $identificador) return $usuari;
        return null;
    }
    public function prestarMaterial(int $materialId, int $usuariId, ?\DateTime $dataPrestec = null): Prestec
    {
        $material = $this->cercarPerId($materialId);
        $usuari = $this->cercarUsuari($usuariId);
        if (!$material) throw new MaterialNoTrobatException("No existeix cap material amb ID $materialId");
        if (!$usuari) throw new UsuariNoTrobatException("No existeix cap usuari amb ID $usuariId");
        if (!$material->isDisponible()) throw new MaterialNoDisponibleException($materialId, 'El material ja està prestat');
        if ($material instanceof Reservable && $material->estaReservat() && $material->getUsuariReserva() !== $usuari->nom) {
            throw new MaterialNoDisponibleException($materialId, 'El material està reservat per un altre usuari');
        }
        $material->prestar();
        if ($material instanceof Reservable && $material->getUsuariReserva() === $usuari->nom) $material->cancelarReserva();
        $prestec = new Prestec($material, $usuari, 14, $dataPrestec);
        $this->prestecs[] = $prestec; $usuari->afegirPrestec($material); $usuari->afegirNotificacio('Préstec realitzat');
        return $prestec;
    }
    public function retornarMaterial(int $materialId): float
    {
        foreach ($this->prestecs as $prestec) if ($prestec->getMaterial()->getId() === $materialId && $prestec->estaActiu()) {
            $prestec->retornar();
            $prestec->getMaterial()->retornar();
            $prestec->getUsuari()->eliminarPrestec($materialId);
            return $prestec->calcularMulta();
        }
        throw new MaterialNoPrestatException("El material amb ID $materialId no estava prestat");
    }
    public function reservarMaterial(int $materialId, int $usuariId): bool
    {
        $material = $this->cercarPerId($materialId); $usuari = $this->cercarUsuari($usuariId);
        if (!$material) throw new MaterialNoTrobatException("No existeix cap material amb ID $materialId");
        if (!$usuari) throw new UsuariNoTrobatException("No existeix cap usuari amb ID $usuariId");
        if (!$material instanceof Reservable) throw new MaterialNoDisponibleException($materialId, 'Les revistes no es poden reservar');
        if (!$material->reservar($usuari->nom)) throw new MaterialNoDisponibleException($materialId, 'El material ja està reservat');
        return true;
    }
    public function obtenirEstadistiques(): array
    {
        $perTipus = []; foreach (['Llibre', 'Revista', 'DVD'] as $tipus) $perTipus[$tipus] = count($this->llistarPerTipus($tipus));
        return ['total'=>count($this->materials), 'disponibles'=>count($this->llistarDisponibles()), 'prestats'=>count($this->llistarPrestats()), 'reservats'=>count($this->llistarReserves()), 'perTipus'=>$perTipus, 'multesPendents'=>array_sum(array_map(fn(Prestec $p) => $p->calcularMulta(), $this->llistarPrestecsActius()))];
    }
    public function getPrestecs(): array { return $this->prestecs; }
    public function __call(string $metode, array $arguments): mixed
    {
        $map = ['getLlibres'=>'Llibre', 'getRevistes'=>'Revista', 'getDVDs'=>'DVD'];
        if (isset($map[$metode])) return $this->llistarPerTipus($map[$metode]);
        if ($metode === 'getMaterials') return $this->materials;
        if ($metode === 'getUsuaris') return $this->usuaris;
        if ($metode === 'getNom') return $this->nom;
        throw new \BadMethodCallException("El mètode $metode no existeix");
    }
}
