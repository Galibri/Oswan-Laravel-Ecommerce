<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('type') && request()->input('type') == 'trash') {
            $products = Product::onlyTrashed()->latest()->paginate(8);
        } elseif (request()->has('type') && request()->input('type') == 'all') {
            $products = Product::withTrashed()->latest()->paginate(8);
        } else {
            $products = Product::latest()->paginate(8);
        }

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands            = Brand::whereStatus(true)->latest()->get();
        $productCategories = ProductCategory::whereStatus(true)->latest()->get();
        return view('admin.product.create', compact('brands', 'productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required',
            'price'       => 'required',
            'category_id' => 'required',
            'brand_id'    => 'required',
            'qty'         => 'required'
        ]);

        dd(request()->all());

        $product        = new Product();
        $product->title = $request->input('title');

        $uniqueSlug = Str::slug($request->input('title'));
        $next       = 2;
        while (Product::where('slug', $uniqueSlug)->first()) {
            $uniqueSlug = Str::slug($request->input('title')) . '-' . $next;
            $next++;
        }

        $product->slug                = $uniqueSlug;
        $product->product_category_id = $request->input('product_category_id');
        $product->brand_id            = $request->input('brand_id');

        $product->description       = $request->input('description');
        $product->short_description = $request->input('short_description');
        $product->price             = $request->input('price');
        $product->selling_price     = $request->input('selling_price');

        $product->rpm       = $request->input('rpm');
        $product->model     = $request->input('model');
        $product->fuel_type = $request->input('fuel_type');
        $product->cc        = $request->input('cc');

        $product->sku     = $request->input('sku');
        $product->qty     = $request->input('qty');
        $product->virtual = $request->input('virtual');
        $product->status  = $request->input('status');

        if ($request->has('thumbnail')) {
            $thumbnail     = $request->file('thumbnail');
            $path          = 'uploads/images/products';
            $thumbnailName = time() . '_' . rand(100, 999) . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path($path), $thumbnailName);
            $product->thumbnail = $thumbnailName;
        }

        if ($product->save()) {

            return redirect()->route('admin.product.index', $product->id)->with('success', __('Product'));
        }
        return redirect()->back()->with('error', __('Please try again.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}