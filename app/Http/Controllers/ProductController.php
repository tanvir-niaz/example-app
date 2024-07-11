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

        $product = Product::create($incomingFields);

        return response()->json($product, 201);
    }

    public function index(Request $request)
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function getProductById($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json($product, 200);
    }

    public function updateProductById(Request $request, $id)
    {
        $incomingFields = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount' => ['numeric', 'min:0'],
            'quantity' => ['required', 'numeric', 'min:0']
        ]);

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

    public function deleteProductById($id){
        $product=Product::find($id);
        if(!$product){
            return reponse()->json("Product not found ",401);
        }
        $product->delete();
        return response()->json("Product deleted successfuly",201);
    }
}
