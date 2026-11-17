<?php
namespace App\Models;

class Prestec
{
    private \DateTime $dataPrestec;
    private ?\DateTime $dataRetorn = null;

    public function __construct(
        private Material $material,
        private Usuari $usuari,
        private int $diesLimitPrestec = 14,
        ?\DateTime $dataPrestec = null
    ) { $this->dataPrestec = $dataPrestec ?? new \DateTime(); }

    public function retornar(): void { $this->dataRetorn = new \DateTime(); }
    public function estaActiu(): bool { return $this->dataRetorn === null; }
    public function calcularDiesRetard(): int
    {
        $final = $this->dataRetorn ?? new \DateTime();
        $dies = (int)$this->dataPrestec->diff($final)->format('%r%a') - $this->diesLimitPrestec;
        return max(0, $dies);
    }
    public function calcularMulta(): float { return $this->material->calcularMulta($this->calcularDiesRetard()); }
    public function estaVencut(): bool { return $this->calcularDiesRetard() > 0; }
    public function getDiesPendents(): int
    {
        $final = new \DateTime();
        return $this->diesLimitPrestec - (int)$this->dataPrestec->diff($final)->format('%r%a');
    }
    public function getMaterial(): Material { return $this->material; }
    public function getUsuari(): Usuari { return $this->usuari; }
    public function getDataPrestec(): \DateTime { return $this->dataPrestec; }
    public function getDataRetorn(): ?\DateTime { return $this->dataRetorn; }
    public function getDiesLimitPrestec(): int { return $this->diesLimitPrestec; }
}
