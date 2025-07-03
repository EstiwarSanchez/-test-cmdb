<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Services\AlephApiServiceInterface;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CmdbItemsExport;
use App\Imports\CmdbItemsImport;

class ImportExportController extends Controller
{
    protected $categoryRepository;
    protected $apiService;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        AlephApiServiceInterface $apiService
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->apiService = $apiService;
    }

    public function export($categoryId)
    {
        try {
            $fileName = "cmdb_items_category_{$categoryId}_" . now()->format('Ymd_His') . '.xlsx';
            return Excel::download(
                new CmdbItemsExport(
                    $this->apiService,
                    $this->categoryRepository,
                    $categoryId
                ),
                $fileName
            );

        } catch (\Exception $e) {
            Log::error("Error al exportar items CMDB: " . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al generar el archivo Excel. ' . $e->getMessage());
        }
    }

    public function import(ImportRequest $request, int $categoryId)
    {
        try {

            Excel::import(
                new CmdbItemsImport($this->apiService, $categoryId),
                $request->file('file')
            );

            return redirect()->route('categories.index')->with('success', 'Archivo importado correctamente.');
        } catch (\Exception $e) {
            \Log::error('Error importando archivo CMDB: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al importar archivo: ' . $e->getMessage());
        }
    }
}
