<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductService
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Fetch all products
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function getAllProducts(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            Log::info('Fetching all products');
            return $this->product->all();
        } catch (Exception $e) {
            Log::error('Failed to fetch products: ' . $e->getMessage());
            throw new Exception('Failed to fetch products');
        }
    }

    /**
     * Fetch a product by ID
     *
     * @param int $id
     * @return Product
     * @throws ModelNotFoundException
     */
    public function getProductById(int $id): Product
    {
        Log::info("Fetching product with ID: $id");
        $product = $this->product->find($id);

        if (!$product) {
            Log::warning("Product with ID: $id not found");
            throw new ModelNotFoundException("Product not found");
        }

        return $product;
    }

    /**
     * Create a new product
     *
     * @param array $data
     * @return Product
     * @throws Exception
     */
    public function createProduct(array $data): Product
    {
        DB::beginTransaction();

        try {
            Log::info("Creating a new product with name: {$data['name']}");
            $product = $this->product->create([
                'name' => $data['name'],
                'price' => $data['price'],
                'quantity' => $data['quantity'],
                'product_unit' => $data['product_unit'],
                'categories_id' => $data['categories_id'],
            ]);

            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to create product: {$e->getMessage()}");
            throw new Exception('Failed to create product');
        }
    }

    /**
     * Update a product
     *
     * @param int $id
     * @param array $data
     * @return Product
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function updateProduct(int $id, array $data): Product
    {
        DB::beginTransaction();

        try {
            $product = $this->getProductById($id);

            Log::info("Updating product with ID: $id");
            $product->update($data);

            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to update product: {$e->getMessage()}");
            throw new Exception('Failed to update product');
        }
    }

    /**
     * Delete a product
     *
     * @param int $id
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function deleteProduct(int $id): void
    {
        DB::beginTransaction();

        try {
            $product = $this->getProductById($id);

            Log::info("Deleting product with ID: $id");
            $product->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to delete product: {$e->getMessage()}");
            throw new Exception('Failed to delete product');
        }
    }
}
