<?php

namespace App\Services;

use App\Http\Responses\ApiResponse;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;


class CartService
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

//   all cart
    public function getAllCart()
    {
        try {
            $cart = $this->cart->all();
            return $cart;
        } catch (Exception $e) {
            Log::error('Failed to fetch cart: ' . $e->getMessage());
            throw new Exception('Failed to fetch categories');
        }
    }

//    add to cart
    public function addCart($data)
    {
        DB::beginTransaction();
        try {
            Log::info('Creating new cart');
            $cart = Cart::where('product_id',$data['product_id'])->where('user_id',$data['user_id'])->first();
            if(!$cart){
                $data['amount'] = 1;
                $cart = $this->cart->create($data);
                DB::commit();
                return $cart;
            }else{
                $cart->amount = $data['amount'] + $cart->amount ?? 1;
                $cart->save();
                DB::commit();
                return $cart;
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create cart: ' . $e->getMessage());
            throw new Exception('Failed to create cart');
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
    public function updateCart($id,$data)
    {
        DB::beginTransaction();
        try {
            $cart = Cart::find($id);
            if(!$cart){
                return ApiResponse::error('Update to cart Error');
            }
            $cart->update(
                [
                    'amount' => $data['amount'],
                ]
            );
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete cart: ' . $e->getMessage());
            throw new Exception('Failed to delete cart');
        }
    }

    public function deleteCart(int $id)
    {
        DB::beginTransaction();
        try {
            $cart = $this->cart->findOrFail($id);
            $cart->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete cart: ' . $e->getMessage());
            throw new Exception('Failed to delete cart');
        }
    }
}
