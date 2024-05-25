<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'thumbnail' => 'required',
            'price' => 'required|numeric',
            'quantity'=> 'required|numeric',
            'product_unit' => 'required',
            'categories_id' => 'required',
        ];
        $request->validate($rules);
        $data = $request->all();
        $res = ['status'=>'errors','message'=>'errors'];
        if(!$data){
            return response()->json($res);
        }
        $result = Products::create($data);
        return response()->json(['status'=>'success','data'=>$result]);
    }
    public function index(Request $request)
    {
        $data = Products::all();
        $res = ['status'=>'errors','message'=>'errors'];
        if(!$data){
            return response()->json($res);
        }
        return response()->json(['status'=>'success','data'=>$data]);
    }
//    public function index()
//    {
//        try {
//            $users = $this->productService->getAllProducts();
//            return ApiResponse::success($users);
//        } catch (\Exception $e) {
//            Log::error('Failed to fetch users: ' . $e->getMessage());
//            return ApiResponse::error('Failed to fetch users', 500);
//        }
//    }

    public function edit(Request $request ,$id)
    {
        $res = ['status'=>'errors','message'=>'errors'];
        $is_id = $id;
        if(!$is_id){
            return response()->json($res);
        }
        $data = Products::where('id',$is_id)->first();
        return response()->json(['status'=>'success','data'=>$data]);
    }
    public function update(Request $request, $id)
    {
        $res = ['status'=>'errors','message'=>'errors'];
        $is_id = $id;
        $rules = [
            'name' => 'required',
            'thumbnail' => 'required',
            'price' => 'required|numeric',
            'quantity'=> 'required|numeric',
            'product_unit' => 'required',
            'categories_id' => 'required',
        ];
        $request->validate($rules);
        $data = $request->all();
        if(!$is_id){
            return response()->json($res);
        }
        $result = Products::where('id',$is_id)->first();
        if(!$result){
            return response()->json($res);
        }
        $result->update($data);
        return response()->json(['status'=>'success','data'=>$result]);
    }

    public function delete(Request $request , $id)
    {
        $data = Products::find($id);
        $res = ['status'=>'errors','message'=>'errors'];
        if(!$data){
            return response()->json($res);
        }
        $data->delete();
        return response()->json(['status'=>'success']);
    }
    public function addToCart(Request $request){
        $res = ['status'=>'errors','message'=>'errors'];
//        $user_id = Auth::user();
//        if (!$user_id) {
//            return response()->json($res, 200);
//        }
            $data = $request->all();
            if(!$data){
                return response()->json($res);
            }
            $cart = Cart::create($data);
            return response()->json(['status'=>'success']);
    }
    public function getToCart(Request $request){
        $res = ['status'=>'errors','message'=>'errors'];
//        $user_id = Auth::user();
//        if (!$user_id) {
//            return response()->json($res, 200);
//        }
        $carts = Cart::all();
        if(!$carts){
            return response()->json($res);
        }
        return response()->json(['status'=>'success','data'=>$carts]);
    }
    public function delToCart(Request $request) {
        $res = ['status' => 'errors', 'message' => 'Cart not found'];
        $cart = Cart::find($request->id);
        if (!$cart) {
            return response()->json($res);
        }
        $cart->delete();
        return response()->json(['status' => 'success', 'message' => 'Cart item deleted successfully']);
    }
    public function updateToCart(Request $request)
    {
        $res = ['status' => 'errors', 'message' => 'Cart not found'];
        $cart = Cart::where('product_id',$request->id)->first();
        if (!$cart) {
            return response()->json($res);
        }
        $cart->update([
            'amount'=>$request->amount,
        ]);
        return response()->json(['status' => 'success', 'message' => 'Cart item deleted successfully']);
    }
}
