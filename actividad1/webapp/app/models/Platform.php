<?php
require_once __DIR__ . "/errors/ValidationException.php";

class Platform
{
    private ?int $platformId;
    private string $name;

    public function __construct(?int $platformId, string $name)
    {
        //En este punto $name nunca es null por el tipado
        $name = trim($name);
        if (strlen($name) < 2) throw new ValidationException("El largo del nombre debe tener como mínimo dos caracteres.");
        $this->platformId = $platformId;
        $this->name = $name;
    }

    public function getPlatformId(): ?int
    {
        return $this->platformId;
    }

    public function setPlatformId(int $platformId)
    {
        $this->platformId = $platformId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}
