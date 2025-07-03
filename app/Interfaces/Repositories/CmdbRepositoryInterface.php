<?php

namespace App\Interfaces\Repositories;

/**
 * Interfaz para el repositorio de CMDB.
 * Define los métodos que deben implementar los repositorios concretos para manejar operaciones sobre los items de la CMDB.
 */
interface CmdbRepositoryInterface
{
    /**
     * Obtiene todos los items de la CMDB.
     *
     * @return mixed
     */
    public function all();

    /**
     * Obtiene los items de CMDB asociados a una categoría específica.
     *
     * @param int $categoryId
     * @return mixed
     */
    public function getCmdbItemsByCategory(int $categoryId);

    /**
     * Crea un nuevo item de CMDB en una categoría específica.
     *
     * @param array $data
     * @param int $categoryId
     * @return mixed
     */
    public function createCmdbItem(array $data, int $categoryId);

    /**
     * Actualiza un item de CMDB existente.
     *
     * @param array $data
     * @param int $categoryId
     * @param string $id
     * @return mixed
     */
    public function updateCmdbItem(array $data, int $categoryId, string $id);

    /**
     * Elimina un item de CMDB por su identificador.
     *
     * @param string $id
     * @return mixed
     */
    public function deleteCmdbItem(string $id);

    /**
     * Activa o desactiva un item de CMDB según el estado recibido.
     *
     * @param int $categoryId
     * @param int $estado
     * @return mixed
     */
    public function deactivateCmdbItem(int $categoryId, int $estado);
}
