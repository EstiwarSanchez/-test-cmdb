<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CmdbRepositoryInterface;
use App\Interfaces\Services\AlephApiServiceInterface;
use App\Traits\Cacheable;
use Illuminate\Support\Facades\Cache;

class CmdbRepository implements CmdbRepositoryInterface
{
    use Cacheable;

    protected $apiService;
    protected $cacheKey = 'cmdb';
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

    public function createCmdbItem(array $data, int $categoryId)
    {
        return $this->apiService->createCmdbItem($data, $categoryId);
    }

    public function updateCmdbItem(array $data, int $categoryId, string $id)
    {
        return $this->apiService->updateCmdbItem($data, $categoryId, $id);
    }

    public function deleteCmdbItem(string $id)
    {
        return $this->apiService->deleteCmdbItem($id);
    }

    public function deactivateCmdbItem(int $categoryId, int $estado)
    {
        return $this->apiService->deactivateCmdbItem($categoryId, $estado);
    }
}
