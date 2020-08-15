<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('type') && request()->input('type') == 'trash') {
            $coupons = Coupon::onlyTrashed()->latest()->paginate(8);
        } elseif (request()->has('type') && request()->input('type') == 'all') {
            $coupons = Coupon::withTrashed()->latest()->paginate(8);
        } else {
            $coupons = Coupon::latest()->paginate(8);
        }
        return view('admin.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.create');
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
            'name'       => 'required',
            'code'       => 'required',
            'starts_at'  => 'required',
            'expires_at' => 'required',
            'amount'     => 'required',
            'max_uses'   => 'required'
        ]);

        $coupon              = new Coupon();
        $coupon->name        = $request->input('name');
        $coupon->code        = $request->input('code');
        $coupon->starts_at   = $request->input('starts_at');
        $coupon->expires_at  = $request->input('expires_at');
        $coupon->description = $request->input('description');
        $coupon->status      = $request->input('status');
        $coupon->is_fixed    = $request->input('is_fixed');
        $coupon->amount      = $request->input('amount');
        $coupon->max_uses    = $request->input('max_uses');

        if ($coupon->save()) {
            return redirect()->route('admin.coupon.edit', $coupon->id)->with('success', 'Coupon created successfully.');
        } else {
            return redirect()->back()->with('error', 'Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.coupon.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'name'       => 'required',
            'code'       => 'required',
            'starts_at'  => 'required',
            'expires_at' => 'required',
            'amount'     => 'required',
            'max_uses'   => 'required'
        ]);

        $coupon->name        = $request->input('name');
        $coupon->code        = $request->input('code');
        $coupon->starts_at   = $request->input('starts_at');
        $coupon->expires_at  = $request->input('expires_at');
        $coupon->description = $request->input('description');
        $coupon->status      = $request->input('status');
        $coupon->is_fixed    = $request->input('is_fixed');
        $coupon->amount      = $request->input('amount');
        $coupon->max_uses    = $request->input('max_uses');

        if ($coupon->save()) {
            return redirect()->route('admin.coupon.edit', $coupon->id)->with('success', 'Coupon updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        if ($coupon->delete()) {
            return redirect()->back()->with('success', 'Coupon deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Please try again.');
        }
    }

    public function restore($id)
    {
        $coupon = Brand::onlyTrashed()->find($id);
        if ($coupon) {
            if ($coupon->restore()) {
                return redirect()->back()->with('success', __('Brand restored.'));
            }
            return redirect()->back()->with('error', __('Please try again.'));
        }
        return redirect()->back()->with('error', __('No coupon to restore.'));
    }

    public function force_delete($id)
    {
        $coupon = Brand::onlyTrashed()->find($id);
        if ($coupon) {
            if ($coupon->thumbnail) {
                File::delete($coupon->thumbnail);
            }

            if ($coupon->forceDelete()) {
                return redirect()->back()->with('success', __('Brand permanently deleted.'));
            }
            return redirect()->back()->with('error', __('Please try again.'));
        }

        return redirect()->back()->with('error', __('No coupon to delete.'));
    }

    public function bulk_delete(Request $request)
    {
        $item_ids = $request->input('item_ids');
        foreach ($item_ids as $id) {
            $coupon = Brand::find($id);
            if ($coupon) {
                $coupon->delete();
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
            $coupon = Brand::withTrashed()->find($id);
            if ($coupon) {
                if ($coupon->thumbnail) {
                    File::delete($coupon->thumbnail);
                }
                $coupon->forceDelete();
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
            $coupon = Brand::onlyTrashed()->find($id);
            if ($coupon) {
                $coupon->restore();
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
            $coupon = Brand::withTrashed()->find($id);
            if ($coupon) {
                $coupon->status = true;
                $coupon->save();
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
            $coupon = Brand::withTrashed()->find($id);
            if ($coupon) {
                $coupon->status = false;
                $coupon->save();
            }
        }
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function export_to_excel()
    {
        return Excel::download(new BrandExport(), 'coupon.xlsx');
    }

    public function export_to_csv()
    {
        return Excel::download(new BrandExport(), 'coupon.csv', \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv'
        ]);

    }

    public function export_to_pdf()
    {
        $coupons = Brand::latest()->get();
        $pdf     = PDF::loadView('admin.coupon.pdf', ['coupons' => $coupons]);
        return $pdf->download('coupon.pdf');
    }
}