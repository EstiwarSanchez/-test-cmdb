<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Interfaces\Services\AlephApiServiceInterface;

class CmdbItemsImport implements ToCollection
{
    protected $categoryId;
    protected $apiService;

    public function __construct(AlephApiServiceInterface $apiService, int $categoryId)
    {
        $this->categoryId = $categoryId;
        $this->apiService = $apiService;
    }

    public function collection(Collection $rows)
    {
        $headers = $rows->shift(); // La primera fila es el encabezado

        foreach ($rows as $row) {
            $data = collect($headers)
                ->mapWithKeys(function ($key, $index) use ($row) {
                    $keyFormatted = strtolower(str_replace(' ', '_', $key));
                    return [$keyFormatted => $row[$index] ?? null];
                })
                ->except(['fecha_creacion'])
                ->toArray();

            if (
                empty($data['identificador']) || $data['identificador'] == 'null' ||
                empty($data['nombre']) || $data['nombre'] == 'null' ||
                empty($data['categoria_id']) || $data['categoria_id'] == 'null'
            ) {
                continue;
            }

            $this->apiService->createCmdbItem($data, $data['categoria_id']);
        }
    }
}
