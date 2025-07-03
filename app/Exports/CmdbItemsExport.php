<?php

namespace App\Exports;

use App\Interfaces\Services\AlephApiServiceInterface;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CmdbItemsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $apiService;
    protected $categoryRepository;
    protected $categoryId;
    protected $cmdbItems;
    protected $dynamicFields;

    public function __construct(
        AlephApiServiceInterface $apiService,
        CategoryRepositoryInterface $categoryRepository,
        string $categoryId
    ) {
        $this->apiService = $apiService;
        $this->categoryRepository = $categoryRepository;
        $this->categoryId = $categoryId;

        // Obtener categoría y campos dinámicos
        $this->loadCategoryData();

        // Obtener items CMDB
        $this->loadCmdbItems();
    }

    protected function loadCategoryData()
    {
        try {
            $category = $this->categoryRepository->find($this->categoryId);
            $this->dynamicFields = $category['campos_cmdb'] ?? [];

            if (empty($this->dynamicFields)) {
                \Log::warning("No se encontraron campos dinámicos para la categoría: {$this->categoryId}");
            }
        } catch (\Exception $e) {
            \Log::error("Error al cargar datos de categoría: " . $e->getMessage());
            $this->dynamicFields = [];
        }
    }

    protected function loadCmdbItems()
    {
        try {
            $items = $this->apiService->getCmdbItemsByCategory($this->categoryId);

            if (empty($items)) {
                \Log::warning("No se encontraron items CMDB para la categoría: {$this->categoryId}");
                $this->cmdbItems = collect();
                return;
            }

             $this->cmdbItems = collect($items['cmdb']);

            \Log::info("Items cargados para exportación: " . $this->cmdbItems->count());

        } catch (\Exception $e) {
            \Log::error("Error al cargar items CMDB: " . $e->getMessage());
            $this->cmdbItems = collect();
        }
    }

    public function collection()
    {
        return $this->cmdbItems;
    }

    public function headings(): array
    {
        // Tomamos las claves del primer ítem de la colección
        return $this->cmdbItems->first()
            ? array_keys($this->cmdbItems->first())
            : [];
    }

    public function map($item): array
    {
        return array_values($item);
    }


    public function styles(Worksheet $sheet)
    {
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'FFD9D9D9']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => false, // Evitar que los encabezados se partan en 2 líneas
            ]
        ];

        // Número de columnas dinámico
        $lastColumn = chr(65 + count($this->headings()) - 1);

        return [
            1 => $headerStyle,
            'A2:' . $lastColumn . '1000' => [
                'alignment' => [
                    'wrapText' => true // Solo para el contenido
                ]
            ]
        ];
    }

    public function title(): string
    {
        $category = $this->categoryRepository->find($this->categoryId);
        return 'Items CMDB - ' . ($category['name'] ?? 'Categoría ' . $this->categoryId);
    }
}
