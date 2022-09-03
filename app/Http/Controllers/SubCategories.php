<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryUpdateValidation;
use App\Http\Requests\SubCategoryValidation;
use App\Models\Categories;
use App\Models\SubCategory;
use Illuminate\Support\Str;

class SubCategories extends Controller
{

    public function createSubCategories()
    {
        try {
            $title = "create_s_categories";
            $categories = Categories::all();
            return view('admin.create_sub_c', compact('title', 'categories'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function storeSubCategories(SubCategoryValidation $request)
    {
        try {
            $request->validated();

            $name = $request->name;
            $value = Str::slug($name);

            $category = Categories::where('value', $request->sub_c)->first();
            if ($category) {
                $category_id = $category->id;
            } else {
                abort(403);
            }
            $c = new SubCategory;
            $c->name = $name;
            $c->value = $value;
            $c->categories_id = $category_id;
            $c->save();

            return redirect()->route('admin_sub_categories')->with('status', 'SubCategory has been created');
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function storeDeleteCategories(SubCategory $category)
    {
        try {
            if (isAdmin()) {
                $category->delete();
                return redirect()->route('admin_sub_categories')->with('status', 'Category has deleted');
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function storeEditCategories(SubCategory $c)
    {

        try {
            if (isAdmin()) {
                $title = 'edit_category';
                $categories = Categories::all();
                return view('admin.edit-sub-c', compact('c', 'title', 'categories'));
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function storeUpdateCategories(SubCategoryUpdateValidation $request, SubCategory $c)
    {
        try {
            $request->validated();
            $category = Categories::where('value', $request->sub_c)->first();
            if ($category) {
                $category_id = $category->id;
            } else {
                abort(403);
            }
            $name = $request->name;
            $value = Str::slug($name);

            $c->name = $name;
            $c->value = $value;
            $c->categories_id = $category_id;
            $c->save();

            return back()->with('status', 'Category has been updated');
        } catch (\Throwable $th) {
            return back();
        }
    }
}
