<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Auth;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('manage product')) {
            $products = Product::where('parent_id', parentId())->orderBy('id', 'desc')->get();
            return view('product.index', compact('products'));
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create product')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'price' => 'required',
            ]);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $product = new Product();
            $product->parent_id = parentId();
            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->discount = $request->discount ?? 0;
            $product->save();

            return redirect()->back()->with('success', 'Product created successfully');
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function show($id)
    {
        $product = Product::find(decrypt($id));
        $setting = settings();
        return view('product.show', compact('product', 'setting'));
    }

    public function edit($id)
    {
        $product = Product::find(decrypt($id));
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->can('create product')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'price' => 'required',
                'discount' => 'required'
            ]);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $product = Product::find($id);
            $product->parent_id = parentId();
            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->discount = $request->discount;
            $product->save();

            return redirect()->back()->with('success', 'Product updated successfully');
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete product')) {
            $product = Product::find($id);
            $product->delete();
            return redirect()->back()->with('success', 'Product deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Permission denied');
        }
    }
}
