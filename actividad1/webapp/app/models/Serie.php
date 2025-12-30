<?php

class Serie
{
    private int $serieId;
    private string $title;

    public function __construct(int $serieId, string $title)
    {
        $this->serieId = $serieId;
        $this->title = $title;
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
}
