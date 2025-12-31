<?php
abstract class BaseRepository
{
    protected string $baseQuery;
    abstract public function getAll(): array;
    abstract public function getByIds(array $ids): array;
    abstract public function getById(int $id): object;
    abstract public function create(object $data): object;
    abstract public function update(object $data): object;
    abstract public function delete(int $id): void;
}
