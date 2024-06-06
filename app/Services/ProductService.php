<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Storage;
class ProductService
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Hàm lấy ra thông tin của tất cả sản phẩm
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws Exception
     * CreatedBy: youngbachhh (27/05/2024)
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
     * Hàm lấy ra thông tin của sản phẩm theo id
     *
     * @param int $id
     * @return Product
     * @throws ModelNotFoundException
     * CreatedBy: youngbachhh (27/05/2024)
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
     * Hàm tạo mới một sản phẩm
     *
     * @param array $data
     * @return Product
     * @throws Exception
     * CreatedBy: youngbachhh (27/05/2024)
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
                'product_unit' => @$data['product_unit'],
                'category_id' => $data['category_id'],
                'description' => @$data['description'],
                'is_featured' => @$data['is_featured'],
                'is_new_arrival' => @$data['is_new_arrival'],
                'reviews' => @$data['reviews'],
                'commission_rate' => @$data['commission_rate'],
                'discount_id' => @$data['discount_id'],
            ]);

            if($product){
                $imagesArray =json_decode($data['images'], true);
                Log::info("{$data['images']}");
                foreach ($imagesArray as $item) {
                    $fileData = $item['data'];
                    $file = base64_decode($fileData);
                    $filename = 'image_' . time() . '_' . uniqid() . '.jpg'; // Thêm một chuỗi duy nhất vào tên tệp tin
                    $path = 'public/images/' . $filename;
                    // Lưu file vào thư mục "storage/app/public/images"
                    Storage::put($path, $file);
                    $url = Storage::url($path);
                    Log::info("File ảnh đã được lưu: {$url}");
                    $image = new ProductImage();
                    $image->product_id = $product->id;
                    $image->image_path = $path;
                    $image->save();
                }
            }
            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to create product: {$e->getMessage()}");
            throw new Exception('Failed to create product');
        }
    }

    /**
     * Hàm cập nhật thông tin của sản phẩm
     *
     * @param int $id
     * @param array $data
     * @return Product
     * @throws ModelNotFoundException
     * @throws Exception
     * CreatedBy: youngbachhh (27/05/2024)
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
     * Hàm xóa một sản phẩm
     *
     * @param int $id
     * @throws ModelNotFoundException
     * @throws Exception
     * CreatedBy: youngbachhh (27/05/2024)
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
