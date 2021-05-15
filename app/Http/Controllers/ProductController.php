<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Product;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StorePostRequest;
use App\Imports\ContactsImport;
use App\Exports\ContactExport;
Use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
    {
        $products =auth()->user()->product;
        return response()->json([
           'Success'=>true,
           'Data'=> $products
        ],200);
    }

    public function show($id)
    {
        $product = auth()->user()->products()->find($id);
        if(!$product){
            return response()->json([
                'Success'=>false,
                'Data'=> 'Product with id'.$id.'not found',
            ],404);
    }
        return response()->json([
            'Success'=>true,
            'Data'=> $product->toArray(),
        ],202);
    }


    public function store(StorePostRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);
        return new ProductResource($product);
    }

    public function update(StorePostRequest $request, $id)
    {
        $product = Product::find($id);
        if (!$product){
             return response()->json([
                    'success'=>false,
                     'data'=>'Product with id'.$id.'not found',
                 ],404);
    }
        $product->fill($request->all());
        $product->save();
    
        if($product){
        return response()->json([
            'Success'=>true,
            'Message'=>'Product updated successfully',
            'data' => $product
            ],202);
        } else {
        return response()->json([
            'Success'=>false,
            'Message'=>'Product could not be updated',
            ],401);
        }

        $product = Product::update([
            'user_id' =>auth()->user()->id,
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return new ProductResource($product); 
    }

    public function destroy($id){
        $product = Product::find($id);

        if(!$product){
            return response()->json([
                'Success'=>false,
                'Message'=>'Product with id'.$id.'not found'
            ],404);
        } if($product->delete()){
            return response()->json([
                'Success'=>true,
                'Message'=>'Product deleted successfully'
            ]);
        } else {
            return response()->json([
                'Success'=>false,
                'Message'=>'Product could not be deleted'
            ],401);
        }
    }

}




