<?php

namespace App\Interfaces\Repositories;

interface CmdbRepositoryInterface
{
    public function all();
    public function getCmdbItemsByCategory(int $categoryId);
    public function createCmdbItem(array $data, int $categoryId);
    public function updateCmdbItem(array $data, int $categoryId, string $id);
    public function deleteCmdbItem(string $id);
    public function deactivateCmdbItem(int $categoryId, int $estado);
}
