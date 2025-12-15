<?php

namespace App\Domain\Usuarios;

class Usuario
{
    public function __construct(
        private int $id,
        private string $nombre,
        private string $email,
        private string $role,
        private bool $activo,
        private ?string $secret2FA = null,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function isActivo(): bool
    {
        return $this->activo;
    }

    public function activar(): void
    {
        $this->activo = true;
    }

    public function desactivar(): void
    {
        $this->activo = false;
    }

    public function getSecret2FA(): ?string
    {
        return $this->secret2FA;
    }

    public function setSecret2FA(?string $secret): void
    {
        $this->secret2FA = $secret;
    }
}
