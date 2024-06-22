<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //index
    public function index(Request $request) {

        // get product by request user id
        $products = Product::with('user')->where('user_id', $request->user()->id)->get();

        // $products = Product::with('user')->whereHas('user', function($query) use ($request) {

        //     $query->where('roles', 'restaurant');
        // })->get();

        return response()->json([

            'status' => 'success',
            'message' => 'Products data retrieved successfully',
            'data'=> $products
        ]);
    }

    // get product by user id
    public function getProductByUserId(Request $request) {

        $products = Product::white('user')->where('user_id', $request->user_id)->get();

        return response()->json([

            'status' => 'success',
            'message' => 'Products data retrieved successfully',
            'data'=> $products
        ]);
    }

    // store
    public function store(Request $request) {

        $request->validate([

            'name' => 'required|string',
            'description' => 'required|string',
            'price'=> 'required|integer',
            'stock'=> 'required|integer',
            'is_available'=> 'required|boolean',
            'is_favorite'=> 'required|boolean',
            'image' => 'required|image',
        ]);

        $user = $request->user();
        $request->merge(['user_id' => $user->id]);

        $data = $request->all();

        $product = Product::create($data);

        // check if image is available
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/products', $image_name); //('destination') $image_name

            $product->image = $image_name;
            $product->save();
        }

        return response()->json([

            'status' => 'success',
            'message' => 'Product created successfully',
            'data'=> $product
        ]);
    }

    // update
    public function update(Request $request, $id) {


        $request->validate([

            'name' => 'required|string',
            'description' => 'required|string',
            'price'=> 'required|integer',
            'stock'=> 'required|integer',
            'is_available'=> 'required|boolean',
            'is_favorite' => 'required|boolean',
        ]);

        $product = Product::find($id);

        if (!$product) {

            return response()->json([

                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }

        $data = $request->all();

        // // check if image is available
        // if ($request->hasFile('image')) {

        //     $image = $request->file('image');
        //     $image_name = time() .'.'. $image->getClientOriginalExtension();
        //     $image->move('uploads/products', $image_name);

        //     $data['image'] = $image_name;
        // }

        $product->update($data);

        return response()->json([

            'status' => 'success',
            'message'=> 'Product updated successfully',
            'data'=> $product
        ]);
    }

    // destroy
    public function destroy($id) {

        $product = Product::find($id);

        if (!$product) {

            return response()->json([

                'stats' => 'error',
                'message' => 'Product not found',
            ], 404);
        }

        $product->delete();

        return response()->json([

            'status' => 'success',
            'message' => 'Product deleted successfully',
        ]);
    }
}
