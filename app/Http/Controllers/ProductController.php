<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function createProduct(Request $request)
    {
        $incomingFields = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount' => ['numeric', 'min:0'],
            'quantity' => ['required', 'numeric', 'min:0'] 
        ]);

        
        if (!isset($incomingFields['discount'])) {
            $incomingFields['discount'] = 0;
        }
        // var_dump($incomingFields);
        
        $product = Product::create([
            'name' => $incomingFields['name'],
            'price' => $incomingFields['price'],
            'discount' => $incomingFields['discount'],
            'quantity' => $incomingFields['quantity']
        ]);

        return response()->json($product, 201);
    }

    public function getProducts(){
        $products=Product::all();
        return response()->json($products,200);
    }

    public function getProductById($id){
        // var_dump($id);
        $product=Product::find($id);
        return response()->json($product,200);
    }

    public function updateProductById(Request $request, $product_id)
    {
        var_dump((int)$product_id);
        $incomingField = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount' => ['numeric', 'min:0'],
            'quantity' => ['required', 'numeric', 'min:0'] 
        ]);
        $product=Product::find($product_id);
        var_dump($product);
        try {
            $product = Product::findOrFail($id);

            $product->update($incomingFields);

            return response()->json(['message' => 'Product updated successfully'], 202);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product'], 500);
        }
    }

    

}
