<?php

namespace App\Domain\Inventario;

class Auto
{
    public function __construct(
        private int $id,
        private string $marca,
        private string $modelo,
        private ?int $anio = null,
        private ?string $version = null,
        private ?string $comentarios = null,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getMarca(): string
    {
        return $this->marca;
    }

    public function setMarca(string $marca): void
    {
        $this->marca = $marca;
    }

    public function getModelo(): string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): void
    {
        $this->modelo = $modelo;
    }

    public function getAnio(): ?int
    {
        return $this->anio;
    }

    public function setAnio(?int $anio): void
    {
        $this->anio = $anio;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): void
    {
        $this->version = $version;
    }

    public function getComentarios(): ?string
    {
        return $this->comentarios;
    }

    public function setComentarios(?string $comentarios): void
    {
        $this->comentarios = $comentarios;
    }
}
