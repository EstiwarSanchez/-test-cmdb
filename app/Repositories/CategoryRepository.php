<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Services\AlephApiServiceInterface;


/**
 * Implementación concreta del repositorio de categorías.
 * Utiliza el servicio de API Aleph para obtener y manipular categorías y sus items CMDB.
 */
class CategoryRepository implements CategoryRepositoryInterface
{
    // Servicio para interactuar con la API de Aleph
    protected $apiService;
    // Clave para el caché de categorías (no utilizada actualmente)
    protected $cacheKey = 'categories';
    // Tiempo de vida del caché en segundos (no utilizado actualmente)
    protected $cacheTtl = 3600; // 1 hora

    /**
     * Constructor: inyecta el servicio de API de Aleph.
     */
    public function __construct(AlephApiServiceInterface $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Obtiene todas las categorías desde la API.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->apiService->getCategories();
    }

    /**
     * Obtiene los items de CMDB asociados a una categoría específica.
     *
     * @param int $categoryId
     * @return mixed
     */
    public function getCmdbItemsByCategory(int $categoryId)
    {
        return $this->apiService->getCmdbItemsByCategory($categoryId);
    }

    /**
     * Busca una categoría por su ID usando la API.
     *
     * @param int $categoryId
     * @return mixed
     */
    public function find(int $categoryId)
    {
        return $this->apiService->find($categoryId);
    }

    /**
     * Crea un nuevo item de CMDB en una categoría específica usando la API.
     *
     * @param array $data
     * @param int $categoryId
     * @return mixed
     */
    public function createCmdbItem(array $data, int $categoryId)
    {
        return $this->apiService->createCmdbItem($data, $categoryId);
    }
}
