<?php

class Serie
{
    private int $serieId;
    private string $title;
    private int $platformId;
    private int $directorId;
    private ?string $platform;
    private ?string $director;

    public function __construct(int $serieId, string $title, int $platformId, int $directorId, ?string $platform = null, ?string $director = null)
    {
        $this->serieId = $serieId;
        $this->title = $title;
        $this->platformId = $platformId;
        $this->directorId = $directorId;
        $this->platform = $platform;
        $this->director = $director;
    }

    public function getSerieId(): ?int
    {
        return $this->serieId;
    }

    public function setSerieId(int $serieId)
    {
        $this->serieId = $serieId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getPlatformId(): int
    {
        return $this->platformId;
    }

    public function setPlatformId(int $platformId)
    {
        $this->platformId = $platformId;
    }

    public function getDirectorId(): int
    {
        return $this->directorId;
    }

    public function setDirectorId(int $directorId)
    {
        $this->directorId = $directorId;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(?string $platform)
    {
        $this->platform = $platform;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(?string $director)
    {
        $this->director = $director;
    }
}
