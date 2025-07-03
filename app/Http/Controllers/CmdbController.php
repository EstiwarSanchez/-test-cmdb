<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCmdbRequest;
use App\Http\Requests\UpdateCmdbRequest;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\CmdbRepositoryInterface;
use Illuminate\Support\Facades\Log;

// Controlador para gestionar operaciones CRUD sobre CMDB
class CmdbController extends Controller
{
    // Repositorio para operaciones sobre CMDB
    protected $cmdbRepository;
    // Repositorio para operaciones sobre categorías
    protected $categoryRepository;

    // Inyección de dependencias de los repositorios
    public function __construct(CmdbRepositoryInterface $cmdbRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->cmdbRepository = $cmdbRepository;
        $this->categoryRepository = $categoryRepository;
    }

    // Muestra el formulario para crear un nuevo item de CMDB en una categoría específica
    public function create(int $categoryId)
    {
        try {
            $categories = $this->categoryRepository->all();
            // Busca la categoría correspondiente por ID
            $category = collect($categories['categorias'])->firstWhere('id', $categoryId);
            return view('cmdb.create', [
                'category' => $category
            ]);
        } catch (\Exception $e) {
            // Registra el error en el log
            Log::error("CmdbController failed: " . $e->getMessage());
        }
    }

    // Almacena un nuevo item de CMDB en la base de datos
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

    // Muestra los items de CMDB de una categoría específica
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

    // Muestra el formulario para editar los items de CMDB de una categoría
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

    // Actualiza un item de CMDB existente
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

    // Elimina un item de CMDB
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

    // Activa o desactiva un item de CMDB según el estado recibido
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
