<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
            $data = $request->all();
            $res = ['status'=>'errors','message'=>'errors'];
            if(!$data){
                return response()->json($res);
            }
            $result = Products::create($data);
            return response()->json(['status'=>'success','data'=>$result]);
    }
    public function getProduct(Request $request)
    {
        $data = Products::all();
        $res = ['status'=>'errors','message'=>'errors'];
        if(!$data){
            return response()->json($res);
        }
        return response()->json(['status'=>'success','data'=>$data]);
    }
    public function showProduct(Request $request ,$id)
    {
        $res = ['status'=>'errors','message'=>'errors'];
        $is_id = $id;
        if(!$is_id){
            return response()->json($res);
        }
        $data = Products::where('id',$is_id)->first();
        return response()->json(['status'=>'success','data'=>$data]);
    }
    public function updateProduct(Request $request, $id)
    {
        $res = ['status'=>'errors','message'=>'errors'];
        $is_id = $id;
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

    public function deleteProduct(Request $request , $id)
    {
        $data = Products::find($id);
        $res = ['status'=>'errors','message'=>'errors'];
        if(!$data){
            return response()->json($res);
        }
        $data->delete();
        return response()->json(['status'=>'success']);

    }
}
