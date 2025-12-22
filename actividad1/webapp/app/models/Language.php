<?php

class Language
{
    private int $languageId;
    private string $name;
    private string $isoCode;

    public function __construct(int $languageId, string $name, string $code)
    {
        $this->languageId = $languageId;
        $this->name = $name;
        $this->isoCode = $code;
    }

    public function getPlatformId(): ?int
    {
        return $this->languageId;
    }

    public function setPlatformId(int $languageId)
    {
        $this->languageId = $languageId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    public function setIsoCode(string $code)
    {
        $this->isoCode = $code;
    }
}
