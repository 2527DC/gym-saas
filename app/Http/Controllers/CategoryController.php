<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage category')) {
            $categories = Category::where('parent_id', parentId())->orderBy('id', 'desc')->get();
            return view('category.index', compact('categories'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function create()
    {
        return view('category.create');
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create category')) {
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $category = new Category();
            $category->title = $request->title;
            $category->parent_id = parentId();
            $category->save();

            return redirect()->route('category.index')->with('success', __('Category successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $category = Category::find(decrypt($id));
        return view('category.edit', compact('category'));
    }


    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit category')) {
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $category = Category::find($id);
            $category->title = $request->title;
            $category->save();

            return redirect()->route('category.index')->with('success', __('Category successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }


    public function destroy($id)
    {
        if (\Auth::user()->can('delete category') ) {
            $category=Category::find($id);
            $category->delete();
            return redirect()->route('category.index')->with('success', __('Category successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
