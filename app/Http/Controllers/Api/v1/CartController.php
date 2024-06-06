<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\ProductNotFoundException;
use App\Services\CartService;
use App\Http\Responses\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function getToCart(){
        try {
            $cart = $this->cartService->getAllCart();
//            $total = 0;
//            foreach ($cart as $item){
//                $amount = $item['amount'];
//                $price = (int)$item['product']['price']
//            }
            return ApiResponse::success($cart);
        } catch (\Exception $e) {
            Log::error('Failed to fetch cart: ' . $e->getMessage());
            return ApiResponse::error('Failed to fetch cart', 500);
        }
    }
    public function addToCart(Request $request){

        try {
            $cart = $this->cartService->addCart($request->all());
            return ApiResponse::success($cart);
        } catch (\Exception $e) {
            Log::error('Failed to fetch cart: ' . $e->getMessage());
            return ApiResponse::error('Failed to fetch cart', 500);
        }
    }
    public function updateToCart($id, Request $request)
    {
        try {
            $cart = $this->cartService->updateCart($id, $request->all());
            return ApiResponse::success($cart, 'Cart updated successfully');
        } catch (ModelNotFoundException $e) {
            $exception = new ProductNotFoundException();
            return $exception->render(request());
        } catch (\Exception $e) {
            Log::error('Failed to update cart: ' . $e->getMessage());
            return ApiResponse::error('Failed to update cart', 500);
        }
    }
    public function deleteCart($id)
    {
        try {
            $this->cartService->deleteCart($id);
            return ApiResponse::success("","Success delete cart");
        }catch(\Exception $e){
            Log::error('Failed to fetch cart: ' . $e->getMessage());
            return ApiResponse::error('Failed to delete cart', 500);
        }
    }
}
