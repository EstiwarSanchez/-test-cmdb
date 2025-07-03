<?php

namespace App\Interfaces\Services;

/**
 * Interfaz para el servicio de integración con la API de Aleph.
 * Define los métodos que deben implementar los servicios concretos para interactuar con la API de Aleph,
 * permitiendo operaciones sobre categorías y items de la CMDB.
 */
interface AlephApiServiceInterface
{
    /**
     * Obtiene todas las categorías desde la API de Aleph.
     *
     * @return mixed
     */
    public function getCategories();

    /**
     * Busca una categoría por su ID en la API de Aleph.
     *
     * @param int $categoryId
     * @return mixed
     */
    public function find(int $categoryId);

    /**
     * Obtiene los items de CMDB asociados a una categoría específica desde la API.
     *
     * @param int $categoryId
     * @return mixed
     */
    public function getCmdbItemsByCategory(int $categoryId);

    /**
     * Crea un nuevo item de CMDB en una categoría específica usando la API.
     *
     * @param array $data
     * @param int $categoryId
     * @return mixed
     */
    public function createCmdbItem(array $data, int $categoryId);

    /**
     * Actualiza un item de CMDB existente usando la API.
     *
     * @param array $data
     * @param int $categoryId
     * @param string $id
     * @return mixed
     */
    public function updateCmdbItem(array $data, int $categoryId, string $id);

    /**
     * Elimina un item de CMDB por su identificador usando la API.
     *
     * @param string $id
     * @return mixed
     */
    public function deleteCmdbItem(string $id);

    /**
     * Activa o desactiva un item de CMDB según el estado recibido usando la API.
     *
     * @param int $categoryId
     * @param int $estado
     * @return mixed
     */
    public function deactivateCmdbItem(int $categoryId, int $estado);
}
