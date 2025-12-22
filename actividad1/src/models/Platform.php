<?php

class Platform
{
    private int $platformId;
    private string $name;

    public function __construct(int $platformId, string $name)
    {
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
