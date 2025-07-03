<?php

namespace App\Interfaces\Services;

interface AlephApiServiceInterface
{
    public function getCategories();
    public function find(int $categoryId);

    public function getCmdbItemsByCategory(int $categoryId);
    public function createCmdbItem(array $data, int $categoryId);
    public function updateCmdbItem(array $data, int $categoryId, string $id);
    public function deleteCmdbItem(string $id);
    public function deactivateCmdbItem(int $categoryId, int $estado);
}
