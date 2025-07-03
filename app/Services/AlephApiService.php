<?php

namespace App\Services;

use App\Interfaces\Services\AlephApiServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AlephApiService implements AlephApiServiceInterface
{
    protected $baseUrl;
    protected $apiKey;


    public function __construct(string $baseUrl, string $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

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
            return collect($categories['categorias'])->firstWhere('id', $categoryId);
        } catch (\Exception $e) {
            Log::error("Error fetching categories: " . $e->getMessage());
            return [];
        }
    }

    public function createCmdbItem(array $data, int $categoryId)
    {
        try {
            if (isset($data['_token'])) {
                // Remove CSRF token if present
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

    private function handleResponse($response)
    {
        if ($response->successful()) {
            return $response->json();
        }

        Log::error("API request failed: " . $response->body());
        throw new \Exception("API request failed with status: " . $response->status());
    }
}
