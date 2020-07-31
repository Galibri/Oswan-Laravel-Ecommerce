<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->has('type') && request()->input('type') == 'trash') {
            $productCategories = ProductCategory::onlyTrashed()->orderBy('created_at', 'desc')->paginate(8);
        } elseif (request()->has('type') && request()->input('type') == 'all') {
            $productCategories = ProductCategory::withTrashed()->orderBy('created_at', 'desc')->paginate(8);
        } else {
            $productCategories = ProductCategory::orderBy('created_at', 'desc')->paginate(8);
        }

        return view('admin.product-category.index', compact('productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $productCategory              = new ProductCategory();
        $productCategory->name        = $request->input('name');
        $productCategory->description = $request->input('description');

        // Slug generation
        $uniqueSlug = Str::slug($request->input('name'));
        $next       = 2;
        while (ProductCategory::where('slug', $uniqueSlug)->first()) {
            $uniqueSlug = Str::slug($request->input('name')) . '-' . $next;
            $next++;
        }
        $productCategory->slug = $uniqueSlug;

        // Thumbnail upload
        if ($request->has('thumbnail')) {
            $thumbnail     = $request->file('thumbnail');
            $path          = 'uploads/images/product-categories';
            $thumbnailName = time() . '_' . rand(100, 999) . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path($path), $thumbnailName);
            $productCategory->thumbnail = $thumbnailName;
        }

        if ($productCategory->save()) {
            return redirect()->route('admin.product-category.edit', $productCategory->id)->with('success', __('Product category added.'));
        }
        return redirect()->back()->with('error', __('Please try again.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory)
    {
        return view('admin.product-category.edit', compact('productCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $productCategory->name        = $request->input('name');
        $productCategory->description = $request->input('description');
        $productCategory->status      = $request->input('status');

        // Slug generation
        $uniqueSlug = Str::slug($request->input('name'));
        $next       = 2;
        while (ProductCategory::where('slug', $uniqueSlug)->first()) {

            if ($request->input('name') == $productCategory->name) {
                $uniqueSlug = $productCategory->slug;
                break;
            }

            // isDirty method to check if the model was changed after loaded
            // if ($productCategory->isDirty('name')) {
            //     $uniqueSlug = $productCategory->slug;
            //     break;
            // }

            $uniqueSlug = Str::slug($request->input('name')) . '-' . $next;

            $next++;
        }
        $productCategory->slug = $uniqueSlug;

        // Thumbnail upload
        if ($request->has('thumbnail')) {
            if ($productCategory->thumbnail) {
                File::delete($productCategory->thumbnail);
            }

            $thumbnail     = $request->file('thumbnail');
            $path          = 'uploads/images/product-categories';
            $thumbnailName = time() . '_' . rand(100, 999) . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path($path), $thumbnailName);
            $productCategory->thumbnail = $thumbnailName;
        }

        if ($productCategory->save()) {
            return redirect()->route('admin.product-category.edit', $productCategory->id)->with('success', __('Product category updated.'));
        }
        return redirect()->back()->with('error', __('Please try again.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory->delete()) {
            return redirect()->route('admin.product-category.index')->with('success', __('Product category deleted.'));
        }

        return redirect()->back()->with('error', __('Please try again.'));
    }
}