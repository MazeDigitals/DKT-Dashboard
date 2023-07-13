<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Category,Product};

class ProductController extends Controller
{
    public function getCategory()
    {
        $category = Category::where('status',1)->get();
        return $this->response(true,$category,'Category fetch successfully',200);
    }

    public function getProducts($category_id){
        $category = Category::where('id',$category_id)->first();
        if(!$category){
            return $this->response(false,null,'Record Not Found',422);
        }
        $product = Product::where('category_id',$category->id)->where('status',1)->paginate(10);
        return $this->response(true,$product,'Product fetch successfully',200);
    }

    public function getProduct($id){
        $product = Product::where('id',$id)->where('status',1)->get();
        if(!$product){
            return $this->response(false,null,'Record Not Found',422);
        }
        return $this->response(true,$product,'Product fetch successfully',200);
    }
}
