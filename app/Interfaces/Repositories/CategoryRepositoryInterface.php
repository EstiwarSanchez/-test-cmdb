<?php

namespace App\Interfaces\Repositories;

/**
 * Interfaz para el repositorio de categorías.
 * Define los métodos que deben implementar los repositorios concretos para manejar categorías y sus items CMDB.
 */
interface CategoryRepositoryInterface
{
    /**
     * Obtiene todas las categorías.
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
     * Busca una categoría por su ID.
     *
     * @param int $categoryId
     * @return mixed
     */
    public function find(int $categoryId);

    /**
     * Crea un nuevo item de CMDB en una categoría específica.
     *
     * @param array $data
     * @param int $categoryId
     * @return mixed
     */
    public function createCmdbItem(array $data, int $categoryId);
}
