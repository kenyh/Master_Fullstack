<?php
abstract class AbstractController
{
    protected BaseRepository $repository;
    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public abstract function list();
    public abstract function create();
    public abstract function read();
    public abstract function update();
    public abstract function delete();
}
