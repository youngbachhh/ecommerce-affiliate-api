<?php
namespace App\Services;

use App\Models\Products;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService{

    public function getAllProducts()
    {
        return Products::all();
    }
}

?>
