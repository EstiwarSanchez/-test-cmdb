<?php

namespace App\Http\Controllers;

use App\Interfaces\Repositories\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->all();
        return view('categories.index', [
            'categories' => $categories
        ]);
    }
}
