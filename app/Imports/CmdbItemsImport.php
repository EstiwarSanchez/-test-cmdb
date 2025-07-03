<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Interfaces\Services\AlephApiServiceInterface;

class CmdbItemsImport implements ToCollection
{
    // ID de la categoría a la que se importarán los items
    protected $categoryId;
    // Servicio para interactuar con la API de Aleph
    protected $apiService;

    /**
     * Constructor: recibe el servicio de API y el ID de la categoría.
     */
    public function __construct(AlephApiServiceInterface $apiService, int $categoryId)
    {
        $this->categoryId = $categoryId;
        $this->apiService = $apiService;
    }

    /**
     * Procesa la colección de filas importadas desde el archivo Excel.
     *
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        // Obtiene la primera fila como encabezados
        $headers = $rows->shift(); // La primera fila es el encabezado

        // Itera sobre cada fila de datos
        foreach ($rows as $row) {
            // Combina encabezados y valores en un array asociativo
            $data = collect($headers)
                ->mapWithKeys(function ($key, $index) use ($row) {
                    // Formatea el nombre del campo a snake_case
                    $keyFormatted = strtolower(str_replace(' ', '_', $key));
                    return [$keyFormatted => $row[$index] ?? null];
                })
                // Excluye el campo 'fecha_creacion' si existe
                ->except(['fecha_creacion'])
                ->toArray();

            // Valida que los campos obligatorios no estén vacíos o sean 'null'
            if (
                empty($data['identificador']) || $data['identificador'] == 'null' ||
                empty($data['nombre']) || $data['nombre'] == 'null' ||
                empty($data['categoria_id']) || $data['categoria_id'] == 'null'
            ) {
                continue;
            }

            // Llama al servicio para crear el item en la CMDB
            $this->apiService->createCmdbItem($data, $data['categoria_id']);
        }
    }
}
