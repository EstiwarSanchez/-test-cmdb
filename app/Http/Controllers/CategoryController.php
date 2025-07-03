<?php

namespace App\Http\Controllers;

// Importa la interfaz del repositorio de categorías
use App\Interfaces\Repositories\CategoryRepositoryInterface;

// Controlador para manejar las categorías
class CategoryController extends Controller
{
    // Propiedad para almacenar la instancia del repositorio de categorías
    protected $categoryRepository;

    // Inyección de dependencias del repositorio de categorías
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    // Método para mostrar la lista de categorías
    public function index()
    {
        // Obtiene todas las categorías usando el repositorio
        $categories = $this->categoryRepository->all();

        // Retorna la vista 'categories.index' con las categorías
        return view('categories.index', [
            'categories' => $categories
        ]);
    }
}

