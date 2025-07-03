<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CmdbRepositoryInterface;
use App\Interfaces\Services\AlephApiServiceInterface;

/**
 * Implementación concreta del repositorio de CMDB.
 * Utiliza el servicio de API Aleph para obtener y manipular los items de la CMDB.
 */
class CmdbRepository implements CmdbRepositoryInterface
{


    // Servicio para interactuar con la API de Aleph
    protected $apiService;
    // Clave para el caché de items CMDB (no utilizada actualmente)
    protected $cacheKey = 'cmdb';
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

    /**
     * Actualiza un item de CMDB existente usando la API.
     *
     * @param array $data
     * @param int $categoryId
     * @param string $id
     * @return mixed
     */
    public function updateCmdbItem(array $data, int $categoryId, string $id)
    {
        return $this->apiService->updateCmdbItem($data, $categoryId, $id);
    }

    /**
     * Elimina un item de CMDB por su identificador usando la API.
     *
     * @param string $id
     * @return mixed
     */
    public function deleteCmdbItem(string $id)
    {
        return $this->apiService->deleteCmdbItem($id);
    }

    /**
     * Activa o desactiva un item de CMDB según el estado recibido usando la API.
     *
     * @param int $categoryId
     * @param int $estado
     * @return mixed
     */
    public function deactivateCmdbItem(int $categoryId, int $estado)
    {
        return $this->apiService->deactivateCmdbItem($categoryId, $estado);
    }
}
