<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;


class CategoryService
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Hàm lấy ra thông tin của tất cả danh mục
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     * CreatedBy: youngbachhh (27/05/2024)
     */
    public function getAllCategories(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            Log::info('Fetching all categories');

            $categories = $this->category::withCount('products')
                ->leftJoin('products', 'categories.id', '=', 'products.category_id')
                ->leftJoin('order_details', 'products.id', '=', 'order_details.product_id')
                ->select(
                    'categories.*',
                    DB::raw('COALESCE(SUM(products.price * order_details.quantity), 0) as revenue'),
                    DB::raw('COUNT(products.id) as products_count')
                )
                ->groupBy('categories.id')
                ->get();

            return $categories;
        } catch (Exception $e) {
            Log::error('Failed to fetch categories: ' . $e->getMessage());
            throw new Exception('Failed to fetch categories');
        }
    }

    /**
     * Hàm tạo mới một danh mục
     *
     * @param array $data
     * @return Category
     * @throws ModelNotFoundException
     * CreatedBy: youngbachhh (27/05/2024)
     */
    public function createCategory(array $data): Category
    {
        DB::beginTransaction();
        try {
            Log::info('Creating new category');
            $category = $this->category->create($data);
            DB::commit();
            return $category;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create category: ' . $e->getMessage());
            throw new Exception('Failed to create category');
        }
    }

    /**
     * Hàm cập nhật thông tin của một danh mục
     *
     * @param int $id
     * @param array $data
     * @return Category
     * @throws ModelNotFoundException
     * CreatedBy: youngbachhh (27/05/2024)
     */
    public function updateCategory(int $id, array $data): Category
    {
        DB::beginTransaction();
        try {
            Log::info("Updating category with ID: $id");
            $category = $this->category->findOrFail($id);
            $category->update($data);
            DB::commit();
            return $category;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update category: ' . $e->getMessage());
            throw new Exception('Failed to update category');
        }
    }

    public function getProductCountByCategory(int $id): int
    {
        try {
            Log::info("Fetching product count for category with ID: $id");
            return $this->category->findOrFail($id)->products()->count();
        } catch (Exception $e) {
            Log::error('Failed to fetch product count: ' . $e->getMessage());
            throw new Exception('Failed to fetch product count');
        }
    }
}
