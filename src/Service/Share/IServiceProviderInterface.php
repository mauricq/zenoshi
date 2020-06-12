<?php


namespace App\Service\Share;


use App\Entity\EntityProvider;

interface IServiceProviderInterface
{
    public function save(EntityProvider $entityProvider): ? EntityProvider;
    public function delete(string $value): void;
    public function getAll(): array;
    public function filterOneBy(string $value = ''): array;
    public function filterBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?array;
    public function getClass(): string;

}