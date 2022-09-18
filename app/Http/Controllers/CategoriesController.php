<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryUpdateValid;
use App\Http\Requests\CategoryValidation;
use App\Models\Categories;
use App\Models\Course;
use App\Models\SubCategory;
use Exception;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function viewCategories()
    {
        try {
            $title = "view_categories";
            return view('admin.view_categories', compact('title'));
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function mainCategories()
    {
        try {
            $title = "view_categories";
            $categories = Categories::orderByDesc('created_at')->simplePaginate(10);
            return view('admin.main_categories', compact('title', 'categories'));
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function subCategories()
    {
        try {
            $title = "view_categories";
            $categories = SubCategory::with('category')->simplePaginate(10);
            return view('admin.sub_categories', compact('title', 'categories'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function createMainCategories()
    {
        try {
            $title = "create_categories";
            return view('admin.create_main_c', compact('title'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function storeMainCategories(CategoryValidation $request)
    {
        try {
            $request->validated();
            $name = $request->name;
            $value = Str::slug($name);

            $c = new Categories;
            $c->name = $name;
            $c->value = $value;
            $c->save();

            return redirect()->route('admin_main_categories')->with('status', 'Category has been created');
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function storeDeleteCategories(Categories $category)
    {
        try {
            if (isAdmin()) {
                $category->delete();
                $all_sub = $category->subCategories;
                if ($all_sub) {
                    foreach ($all_sub as $s_c) {
                        $s_c->delete();
                    }
                }
                return redirect()->route('admin_main_categories')->with('status', 'Category has deleted');
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function storeEditCategories(Categories $c)
    {
        try {
            if (isAdmin()) {
                $title = 'edit_category';
                return view('admin.edit-c', compact('c', 'title'));
            }
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function storeUpdateCategories(CategoryUpdateValid $request, Categories $c)
    {
        try {
            $request->validated();
            $name = $request->name;
            $value = Str::slug($name);

            $c->name = $name;
            $c->value = $value;
            $c->save();

            return back()->with('status', 'Category has been updated');
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function showCategory($category)
    {
        try {
            $c = Categories::where('value', $category)->first();
            if (!$c) {
                abort(404);
            }

            $courses = Course::with(['user:id,name', 'course_image', 'price'])->where('categories_selection', $category)->where('status', 'published')->where('is_deleted',null)->select('id', 'user_id', 'categories_selection', 'slug', 'course_title')->orderByDesc('created_at')
                ->simplePaginate();
            $title = $category;
            $desc = "";
            switch (strtolower($title)) {
                case 'engineering':
                    $desc = __('description.engineering');
                    break;
                case 'it':
                    $desc = __('description.it');
                    break;
                case 'designing':
                    $desc = __('description.designing');
                    break;
                case 'photography':
                    $desc = __('description.photography');
                    break;
                case 'accounting-and-finance':
                    $desc = __('description.accounting_and_finance');
                    break;

                default:
                    $desc = __('description.default');
                    break;
            }
            return view(config("setting.show_blade"), compact('c', 'courses', 'title', 'desc'));
        } catch (Exception $e) {
            return back()->with('error', 'this action cannot be done now please try again');
        }
    }
}
