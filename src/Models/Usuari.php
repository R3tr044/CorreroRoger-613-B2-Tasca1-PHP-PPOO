<?php
namespace App\Models;
use App\Exceptions\EmailInvalidException;

class Usuari
{
    private int $id;
    private string $nom;
    private string $email;
    private array $materialsPrestats = [];
    private \DateTime $dataRegistre;
    private array $notificacions = [];

    public function __construct(int $id, string $nom, string $email)
    {
        if (!$this->validarEmail($email)) throw new EmailInvalidException('El format de l’email no és vàlid');
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->dataRegistre = new \DateTime();
    }

    public function __get(string $propietat): mixed
    {
        return in_array($propietat, ['id', 'nom', 'email', 'dataRegistre'], true) ? $this->{$propietat} : null;
    }
    public function __set(string $propietat, mixed $valor): void
    {
        if ($propietat !== 'email') throw new \LogicException('Només es pot modificar l’email');
        if (!is_string($valor) || !$this->validarEmail($valor)) throw new EmailInvalidException('El format de l’email no és vàlid');
        $this->email = $valor;
    }
    public function __sleep(): array { return ['id', 'nom', 'email', 'materialsPrestats', 'dataRegistre']; }
    public function __wakeup(): void { $this->notificacions = []; }
    public function __toString(): string { return "{$this->nom} <{$this->email}> - {$this->getNumeroMaterialsPrestats()} préstecs"; }
    public function afegirPrestec(Material $material): void { $this->materialsPrestats[$material->getId()] = $material; }
    public function eliminarPrestec(int $materialId): void { unset($this->materialsPrestats[$materialId]); }
    public function getMaterialsPrestats(): array { return array_values($this->materialsPrestats); }
    public function getNumeroMaterialsPrestats(): int { return count($this->materialsPrestats); }
    public function afegirNotificacio(string $missatge): void { $this->notificacions[] = $missatge; }
    public function obtenirNotificacions(): array { $resultat = $this->notificacions; $this->notificacions = []; return $resultat; }
    private function validarEmail(string $email): bool { return filter_var($email, FILTER_VALIDATE_EMAIL) !== false; }
}
