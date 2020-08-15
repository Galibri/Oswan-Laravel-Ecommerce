@extends('layouts.admin')

@section('meta-title', __('Add new coupon'))

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <form action="{{ route('admin.coupon.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card card-dark">
                <div class="card-header">
                    <h5 class="d-inline-block mt-1">{{ __('Add new coupon') }}</h5>
                    <a href="{{ route('admin.product-category.index') }}"
                        class="btn btn-outline-warning float-right btn-sm">{{ __('View All') }}</a>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" class="form-control" name="code" id="code" value="{{ old('code') }}">
                        @error('code')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="starts_at">Starts at</label>
                        <input type="text" class="form-control datetime" name="starts_at" id="starts_at"
                            autocomplete="off" value="{{ old('starts_at') }}">
                        @error('starts_at')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="expires_at">Expires at</label>
                        <input type="text" class="form-control datetime" name="expires_at" id="expires_at"
                            autocomplete="off" value="{{ old('expires_at') }}">
                        @error('expires_at')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" name="amount" step="any" min="0" id="amount"
                            autocomplete="off" value="{{ old('amount') }}">
                        @error('amount')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="max_uses">Max Uses</label>
                        <input type="number" min="0" class="form-control" name="max_uses" id="max_uses"
                            autocomplete="off" value="{{ old('max_uses') }}">
                        @error('max_uses')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ old('status') == 1 ? 'selected="selected"' : '' }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected="selected"' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="is_fixed">Type</label>
                        <select name="is_fixed" id="is_fixed" class="form-control">
                            <option value="1" {{ old('is_fixed') == 1 ? 'selected="selected"' : '' }}>Fixed</option>
                            <option value="0" {{ old('is_fixed') == 0 ? 'selected="selected"' : '' }}>Percentage
                            </option>
                        </select>
                        @error('is_fixed')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control textarea" id="description" cols="30"
                            rows="6">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-info">{{ __('Save Coupon') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection