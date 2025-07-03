<?php

namespace App\Services;

use App\Interfaces\Services\AlephApiServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Servicio para interactuar con la API de Aleph.
 * Implementa operaciones CRUD sobre categorías e items de la CMDB.
 */
class AlephApiService implements AlephApiServiceInterface
{
    // URL base de la API de Aleph
    protected $baseUrl;
    // API Key para autenticación
    protected $apiKey;

    /**
     * Constructor: recibe la URL base y la API Key.
     */
    public function __construct(string $baseUrl, string $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * Obtiene todas las categorías desde la API.
     */
    public function getCategories()
    {
        try {
            $response = Http::asForm()->post(
                "{$this->baseUrl}/get_categorias",
                [
                    'api_key' => $this->apiKey,
                ]
            );

            return $this->handleResponse($response);
        } catch (\Exception $e) {
            Log::error("Error fetching categories: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca una categoría por su ID desde la API.
     */
    public function find(int $categoryId)
    {
        try {
            $response = Http::asForm()->post(
                "{$this->baseUrl}/get_categorias",
                [
                    'api_key' => $this->apiKey,
                ]
            );

            $categories = $this->handleResponse($response);
            // Busca la categoría específica en la respuesta
            return collect($categories['categorias'])->firstWhere('id', $categoryId);
        } catch (\Exception $e) {
            Log::error("Error fetching categories: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Crea un nuevo item de CMDB en una categoría específica usando la API.
     */
    public function createCmdbItem(array $data, int $categoryId)
    {
        try {
            if (isset($data['_token'])) {
                // Elimina el token CSRF si está presente
                unset($data['_token']);
            }
            $data['categoria_id'] = $categoryId;
            $data['api_key'] = $this->apiKey;

            $response = Http::asForm()->post(
                "{$this->baseUrl}/insert_cmdb",
                $data
            );

            return $this->handleResponse($response);
        } catch (\Exception $e) {
            Log::error("Error fetching categories: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Actualiza un item de CMDB existente usando la API.
     */
    public function updateCmdbItem(array $data, int $categoryId, string $id)
    {
        try {
            unset($data['_token']);
            $data['identificador'] = $id;
            $data['categoria_id'] = $categoryId;
            $data['api_key'] = $this->apiKey;

            $response = Http::asForm()->post(
                "{$this->baseUrl}/insert_cmdb",
                $data
            );

            return $this->handleResponse($response);
        } catch (\Exception $e) {
            Log::error("Error updating CMDB item: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Activa o desactiva un item de CMDB según el estado recibido usando la API.
     */
    public function deactivateCmdbItem(int $categoryId, int $estado)
    {
        try {
            $data = [
                'api_key' => $this->apiKey,
                'categoria_id' => $categoryId,
                'activado' => $estado,
            ];

            $response = Http::asForm()->post(
                "{$this->baseUrl}/update_activado_cmdb",
                $data
            );

            return $this->handleResponse($response);
        } catch (\Exception $e) {
            Log::error("Error updating CMDB item: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Elimina un item de CMDB por su identificador usando la API.
     */
    public function deleteCmdbItem(string $id)
    {
        try {
            $data = [
                'api_key' => $this->apiKey,
                'identificador' => $id,
            ];

            $response = Http::asForm()->post(
                "{$this->baseUrl}/delete_cmdb",
                $data
            );

            return $this->handleResponse($response);
        } catch (\Exception $e) {
            Log::error("Error updating CMDB item: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene los items de CMDB asociados a una categoría específica desde la API.
     */
    public function getCmdbItemsByCategory(int $categoryId)
    {
       try {
            $response = Http::asForm()->post(
                "{$this->baseUrl}/get_cmdb",
                [
                    'api_key' => $this->apiKey,
                    'categoria_id' => $categoryId,
                ]
            );

            return $this->handleResponse($response);
        } catch (\Exception $e) {
            Log::error("Error fetching categories: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Maneja la respuesta de la API.
     * Lanza excepción si la respuesta no es exitosa.
     */
    private function handleResponse($response)
    {
        if ($response->successful()) {
            return $response->json();
        }

        Log::error("API request failed: " . $response->body());
        throw new \Exception("API request failed with status: " . $response->status());
    }
}
