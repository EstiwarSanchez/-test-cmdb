<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCmdbRequest;
use App\Http\Requests\UpdateCmdbRequest;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\CmdbRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CmdbController extends Controller
{
    protected $cmdbRepository;
    protected $categoryRepository;

    public function __construct(CmdbRepositoryInterface $cmdbRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->cmdbRepository = $cmdbRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function create(int $categoryId)
    {
        try {
            $categories = $this->categoryRepository->all();
            $category = collect($categories['categorias'])->firstWhere('id', $categoryId);
            return view('cmdb.create', [
                'category' => $category
            ]);
        } catch (\Exception $e) {
            Log::error("CmdbController failed: " . $e->getMessage());
        }

    }

    public function store(StoreCmdbRequest $request, int $categoryId)
    {
        try {
            $this->cmdbRepository->createCmdbItem($request->all(), $categoryId);
            return redirect()->route('categories.index')->with('success', 'CMDB guardado correctamente.');
        } catch (\Exception $e) {
            Log::error("CmdbController failed: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al guardar CMDB']);
        }
    }

    public function show(int $categoryId)
    {
        try {
            $cmdbItems = $this->cmdbRepository->getCmdbItemsByCategory($categoryId);
            return view('cmdb.show', [
                'cmdbItems' => $cmdbItems,
                'categoryId' => $categoryId
            ]);
        } catch (\Exception $e) {
            Log::error("CmdbController failed: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al obtener los items de CMDB']);
        }
    }

    public function edit(int $categoryId)
    {
        try {
            $cmdbItems = $this->cmdbRepository->getCmdbItemsByCategory($categoryId);
            return view('cmdb.edit', [
                'cmdbItems' => $cmdbItems,
                'categoryId' => $categoryId
            ]);
        } catch (\Exception $e) {
            Log::error("CmdbController failed: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al editar el item de CMDB']);
        }
    }

    public function update(UpdateCmdbRequest $request, int $categoryId, string $id)
    {
        try {
            $this->cmdbRepository->updateCmdbItem($request->all(), $categoryId, $id);
            return redirect()->route('categories.index')->with('success', 'CMDB actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error("CmdbController failed: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al actualizar CMDB']);
        }
    }

    public function destroy(int $categoryId, string $id)
    {
        try {
            $this->cmdbRepository->deleteCmdbItem($id);
            return redirect()->route('categories.index')->with('success', 'CMDB eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error("CmdbController failed: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al eliminar CMDB']);
        }
    }

    public function deactivate(int $categoryId, int $estado)
    {
        try {
            $message = $estado == 0 ? 'CMDB desactivado correctamente' : 'CMDB activado correctamente';
            $this->cmdbRepository->deactivateCmdbItem($categoryId, $estado);
            return redirect()->route('categories.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error("CmdbController failed: " . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al desactivar CMDB']);
        }
    }

}
