<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Services\AlephApiServiceInterface;
use Illuminate\Support\Facades\Cache;

class CategoryRepository implements CategoryRepositoryInterface
{

    protected $apiService;
    protected $cacheKey = 'categories';
    protected $cacheTtl = 3600; // 1 hora

    public function __construct(AlephApiServiceInterface $apiService)
    {
        $this->apiService = $apiService;
    }

    public function all()
    {
        return $this->apiService->getCategories();
    }

    public function getCmdbItemsByCategory(int $categoryId)
    {
        return $this->apiService->getCmdbItemsByCategory($categoryId);
    }

    public function find(int $categoryId)
    {
        return $this->apiService->find($categoryId);
    }

    public function createCmdbItem(array $data, int $categoryId)
    {
        return $this->apiService->createCmdbItem($data, $categoryId);
    }
}
