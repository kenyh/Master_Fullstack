<?php

class Serie
{
    private ?int $serieId;
    private string $title;
    private string $synopsis;
    private int $platformId;
    private int $directorId;
    private ?string $platform; //No merece la pena crear un objeto Platform
    private ?string $director;
    private array $audioLanguageNames = [];
    private array $subtitleLanguageNames = [];
    private array $audioLanguageIds = [];
    private array $subtitleLanguageIds = [];

    private array $actorIds = [];
    private array $actorNames = [];

    public function __construct(
        ?int $serieId,
        string $title,
        string $synopsis,
        int $platformId,
        int $directorId,
        array $audioLanguageIds,
        array $subtitleLanguageIds,
        array $actorIds = [],
        array $audioLanguageNames = [],
        array $subtitleLanguageNames = [],
        array $actorNames = [],
        ?string $platform = null,
        ?string $director = null
    ) {
        $this->serieId = $serieId;
        $this->title = $title;
        $this->synopsis = $synopsis;
        $this->platformId = $platformId;
        $this->directorId = $directorId;
        $this->platform = $platform;
        $this->director = $director;

        $this->audioLanguageIds = $audioLanguageIds;
        $this->subtitleLanguageIds = $subtitleLanguageIds;
        $this->actorIds = $actorIds;
        $this->audioLanguageNames = $audioLanguageNames;
        $this->subtitleLanguageNames = $subtitleLanguageNames;
        $this->actorNames = $actorNames;
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

    public function getSynopsis(): string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis)
    {
        $this->synopsis = $synopsis;
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

    public function getAudioLanguageIds(): array
    {
        return $this->audioLanguageIds;
    }
    public function setAudioLanguageIds(array $audioLanguageIds)
    {
        $this->audioLanguageIds = $audioLanguageIds;
    }
    public function getSubtitleLanguageIds(): array
    {
        return $this->subtitleLanguageIds;
    }
    public function setSubtitleLanguageIds(array $subtitleLanguageIds)
    {
        $this->subtitleLanguageIds = $subtitleLanguageIds;
    }
    public function getAudioLanguageNames(): array
    {
        return $this->audioLanguageNames;
    }
    public function setAudioLanguageNames(array $audioLanguageNames)
    {
        $this->audioLanguageNames = $audioLanguageNames;
    }
    public function getSubtitleLanguageNames(): array
    {
        return $this->subtitleLanguageNames;
    }
    public function setSubtitleLanguageNames(array $subtitleLanguageNames)
    {
        $this->subtitleLanguageNames = $subtitleLanguageNames;
    }

    public function getActorIds(): array
    {
        return $this->actorIds;
    }

    public function setActorIds(array $actorIds)
    {
        $this->actorIds = $actorIds;
    }

    public function getActorNames(): array
    {
        return $this->actorNames;
    }

    public function setActorNames(array $actorNames)
    {
        $this->actorNames = $actorNames;
    }
}
