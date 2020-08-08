<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BrandExport;
use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('type') && request()->input('type') == 'trash') {
            $brands = Brand::onlyTrashed()->latest()->paginate(8);
        } elseif (request()->has('type') && request()->input('type') == 'all') {
            $brands = Brand::withTrashed()->latest()->paginate(8);
        } else {
            $brands = Brand::latest()->paginate(8);
        }

        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
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

        $brand              = new Brand();
        $brand->name        = $request->input('name');
        $brand->description = $request->input('description');

        // Slug generation
        $uniqueSlug = Str::slug($request->input('name'));
        $next       = 2;
        while (Brand::where('slug', $uniqueSlug)->first()) {
            $uniqueSlug = Str::slug($request->input('name')) . '-' . $next;
            $next++;
        }
        $brand->slug = $uniqueSlug;

        // Thumbnail upload
        if ($request->has('thumbnail')) {
            $thumbnail     = $request->file('thumbnail');
            $path          = 'uploads/images/product-brands';
            $thumbnailName = time() . '_' . rand(100, 999) . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path($path), $thumbnailName);
            $brand->thumbnail = $thumbnailName;
        }

        if ($brand->save()) {
            return redirect()->route('admin.brand.edit', $brand->id)->with('success', __('Product brand added.'));
        }
        return redirect()->back()->with('error', __('Please try again.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return view('admin.brand.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Brand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $brand->name        = $request->input('name');
        $brand->description = $request->input('description');

        // Slug generation
        $uniqueSlug = Str::slug($request->input('name'));
        $next       = 2;
        while (Brand::where('slug', $uniqueSlug)->first()) {
            if ($brand->name == $request->input('name')) {
                $uniqueSlug = $brand->slug;
                break;
            }
            $uniqueSlug = Str::slug($request->input('name')) . '-' . $next;
            $next++;
        }
        $brand->slug = $uniqueSlug;

        // Thumbnail upload
        if ($request->has('thumbnail')) {
            if ($brand->thumbnail) {
                File::delete($brand->thumbnail);
            }
            $thumbnail     = $request->file('thumbnail');
            $path          = 'uploads/images/product-brands';
            $thumbnailName = time() . '_' . rand(100, 999) . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path($path), $thumbnailName);
            $brand->thumbnail = $thumbnailName;
        }

        if ($brand->save()) {
            return redirect()->route('admin.brand.edit', $brand->id)->with('success', __('Product brand added.'));
        }
        return redirect()->back()->with('error', __('Please try again.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        if ($brand->delete()) {
            return redirect()->back()->with('success', __('Product brand deleted.'));
        }

        return redirect()->back()->with('error', __('Please try again.'));
    }

    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->find($id);
        if ($brand) {
            if ($brand->restore()) {
                return redirect()->back()->with('success', __('Brand restored.'));
            }
            return redirect()->back()->with('error', __('Please try again.'));
        }
        return redirect()->back()->with('error', __('No brand to restore.'));
    }

    public function force_delete($id)
    {
        $brand = Brand::onlyTrashed()->find($id);
        if ($brand) {
            if ($brand->thumbnail) {
                File::delete($brand->thumbnail);
            }

            if ($brand->forceDelete()) {
                return redirect()->back()->with('success', __('Brand permanently deleted.'));
            }
            return redirect()->back()->with('error', __('Please try again.'));
        }

        return redirect()->back()->with('error', __('No brand to delete.'));
    }

    public function bulk_delete(Request $request)
    {
        $item_ids = $request->input('item_ids');
        foreach ($item_ids as $id) {
            $brand = Brand::find($id);
            if ($brand) {
                $brand->delete();
            }
        }
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function bulk_force_delete(Request $request)
    {
        $item_ids = $request->input('item_ids');
        foreach ($item_ids as $id) {
            $brand = Brand::withTrashed()->find($id);
            if ($brand) {
                if ($brand->thumbnail) {
                    File::delete($brand->thumbnail);
                }
                $brand->forceDelete();
            }
        }
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function bulk_restore(Request $request)
    {
        $item_ids = $request->input('item_ids');
        foreach ($item_ids as $id) {
            $brand = Brand::onlyTrashed()->find($id);
            if ($brand) {
                $brand->restore();
            }
        }
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function bulk_active(Request $request)
    {
        $item_ids = $request->input('item_ids');
        foreach ($item_ids as $id) {
            $brand = Brand::withTrashed()->find($id);
            if ($brand) {
                $brand->status = true;
                $brand->save();
            }
        }
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function bulk_inactive(Request $request)
    {
        $item_ids = $request->input('item_ids');
        foreach ($item_ids as $id) {
            $brand = Brand::withTrashed()->find($id);
            if ($brand) {
                $brand->status = false;
                $brand->save();
            }
        }
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function export_to_excel()
    {
        return Excel::download(new BrandExport(), 'brand.xlsx');
    }

    public function export_to_csv()
    {
        return Excel::download(new BrandExport(), 'brand.csv', \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv'
        ]);

    }

    public function export_to_pdf()
    {
        $brands = Brand::latest()->get();
        $pdf    = PDF::loadView('admin.brand.pdf', ['brands' => $brands]);
        return $pdf->download('brand.pdf');
    }
}