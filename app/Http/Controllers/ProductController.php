<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;


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
        try{
            if (!isset($incomingFields['discount'])) {
                $incomingFields['discount'] = 0;
            }
    
            $product = Product::create($incomingFields);
            $postToRequestToAnotherServer = Http::post('http://127.0.0.1:8001/product', $incomingFields);
            Log::info(__METHOD__ . " Error",[$postToRequestToAnotherServer]);
    
            if ($postToRequestToAnotherServer->failed()) {
                return response()->json(['error' => 'Failed to send product to another server'], 500);
            }
            $products=Product::paginate(7);
            return view('product',['products'=>$products]);

        }catch(ValidationException $e){
            dd($e);
            
        }catch(Exception $e){
            dd($e);
        }

        
    }

    public function GetAllProducts(Request $request)
    {
        $products = Product::paginate(7);
        
        return view('product',compact('products'));
        // return response()->json($products);
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
