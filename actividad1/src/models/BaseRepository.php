<?php
abstract class BaseRepository
{
    abstract public function getAll(): array;
    abstract public function getByIds(array $ids): array;
    abstract public function create(object $data): object;
    abstract public function update(object $data): object;
    abstract public function delete(int $id): void;
}
