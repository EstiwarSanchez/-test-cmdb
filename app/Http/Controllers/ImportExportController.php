<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Services\AlephApiServiceInterface;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CmdbItemsExport;
use App\Imports\CmdbItemsImport;

/**
 * Controlador para importar y exportar items de CMDB.
 */
class ImportExportController extends Controller
{
    protected $categoryRepository;
    protected $apiService;

    /**
     * Constructor: inyecta dependencias de repositorio de categorías y servicio API.
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        AlephApiServiceInterface $apiService
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->apiService = $apiService;
    }

    /**
     * Exporta los items de una categoría específica a un archivo Excel.
     *
     * @param int $categoryId
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function export($categoryId)
    {
        try {
            // Genera el nombre del archivo con timestamp
            $fileName = "cmdb_items_category_{$categoryId}_" . now()->format('Ymd_His') . '.xlsx';
            // Descarga el archivo Excel usando la exportación personalizada
            return Excel::download(
                new CmdbItemsExport(
                    $this->apiService,
                    $this->categoryRepository,
                    $categoryId
                ),
                $fileName
            );

        } catch (\Exception $e) {
            // Registra el error y retorna con mensaje de error
            Log::error("Error al exportar items CMDB: " . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al generar el archivo Excel. ' . $e->getMessage());
        }
    }

    /**
     * Importa items de CMDB desde un archivo Excel para una categoría específica.
     *
     * @param ImportRequest $request
     * @param int $categoryId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(ImportRequest $request, int $categoryId)
    {
        try {
            // Importa los datos usando la importación personalizada
            Excel::import(
                new CmdbItemsImport($this->apiService, $categoryId),
                $request->file('file')
            );

            // Redirige con mensaje de éxito
            return redirect()->route('categories.index')->with('success', 'Archivo importado correctamente.');
        } catch (\Exception $e) {
            // Registra el error y retorna con mensaje de error
            \Log::error('Error importando archivo CMDB: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al importar archivo: ' . $e->getMessage());
        }
    }
}

