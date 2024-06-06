<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\CategoryService;
use App\Http\Responses\ApiResponse;
use http\Env\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Exceptions\CategoryNotFoundException;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\Category\StoreCategoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        try {
            $categories = $this->categoryService->getAllCategories();
            return ApiResponse::success($categories);
        } catch (\Exception $e) {
            Log::error('Failed to fetch categories: ' . $e->getMessage());
            return ApiResponse::error('Failed to fetch categories', 500);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = $this->categoryService->createCategory($request->validated());
            return ApiResponse::success($category, 'Category created successfully', 201);
        } catch (\Exception $e) {
            Log::error('Failed to create category: ' . $e->getMessage());
            return ApiResponse::error('Failed to create category', 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $category = $this->categoryService->updateCategory($id, $request->all());
            return ApiResponse::success($category, 'Category updated successfully');
        } catch (ModelNotFoundException $e) {
            $exception = new CategoryNotFoundException();
            return $exception->render(request());
        } catch (\Exception $e) {
            Log::error('Failed to update category: ' . $e->getMessage());
            return ApiResponse::error('Failed to update category', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            return ApiResponse::success([], 'Category deleted successfully');
        } catch (ModelNotFoundException $e) {
            $exception = new CategoryNotFoundException();
            return $exception->render(request());
        } catch (\Exception $e) {
            Log::error('Failed to delete category: ' . $e->getMessage());
            return ApiResponse::error('Failed to delete category', 500);
        }
    }
}
