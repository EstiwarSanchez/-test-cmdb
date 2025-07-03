<?php

namespace App\Interfaces\Repositories;

interface CategoryRepositoryInterface
{
    public function all();
    public function getCmdbItemsByCategory(int $categoryId);
    public function find(int $categoryId);
    public function createCmdbItem(array $data, int $categoryId);
}
