<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Gallery;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($product_id)
    {
        $gallery    = Gallery::whereProductId($product_id)->first();
        $gallery_id = '';
        $galleries  = [];
        if ($gallery) {
            $galleries  = array_reverse(json_decode($gallery->images, true));
            $gallery_id = $gallery->id;
        }
        return view('admin.gallery.create', compact('product_id', 'galleries', 'gallery_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $product_id)
    {
        if ($request->has('images')) {

            $images = $request->file('images');
            $path   = 'uploads/images/gallery';

            $existingGallery = Gallery::whereProductId($product_id)->first();
            if ($existingGallery) {
                $gallery       = $existingGallery;
                $galleryImages = json_decode($existingGallery->images, true);
            } else {
                $gallery       = new Gallery();
                $galleryImages = [];
            }

            foreach ($images as $image) {
                $image_name = time() . '_' . rand(100, 999) . '_' . $image->getClientOriginalName();
                $image->move(public_path($path), $image_name);

                $image_name_path = $path . '/' . $image_name;
                array_push($galleryImages, $image_name_path);
            }

            $gallery->images     = json_encode($galleryImages);
            $gallery->product_id = $product_id;

            if ($gallery->save()) {
                $product = Product::whereId($product_id)->first();
                if ($product) {
                    $product->gallery_id = $gallery->id;
                    $product->save();
                }
            }

            return redirect()->back()->with('success', 'Images added');

        }
        return redirect()->back()->with('error', 'Please try agin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $product_id)
    {
        $image_name    = $request->input('image_name');
        $gallery       = Gallery::whereProductId($product_id)->first();
        $gallery_array = json_decode($gallery->images, true);

        array_splice($gallery_array, array_search($image_name, $gallery_array), 1);
        File::delete($request->input('image_name'));

        $gallery->images = json_encode($gallery_array);
        $gallery->save();
        return redirect()->back()->with('success', __('Image deleted.'));
    }
}