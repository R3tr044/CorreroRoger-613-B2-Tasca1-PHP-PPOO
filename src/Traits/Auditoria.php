<?php
namespace App\Traits;

trait Auditoria
{
    private array $historial = [];

    public function registrarAccio(string $accio, string $detalls = ''): void
    {
        $this->historial[] = [
            'data' => date('Y-m-d H:i:s'),
            'accio' => $accio,
            'detalls' => $detalls,
        ];
    }

    public function obtenirHistorial(): array { return $this->historial; }
    public function obtenirUltimaAccio(): ?array { return $this->historial ? end($this->historial) : null; }
    public function netejarHistorial(): void { $this->historial = []; }
}
