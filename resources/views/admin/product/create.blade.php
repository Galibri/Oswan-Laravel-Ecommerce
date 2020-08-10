@extends('layouts.admin')

@section('meta-title', __('Add new product'))

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="page-title bg-dark text-light p-3 mb-3 rounded">
            <h5 class="d-inline-block text-uppercase mb-0">{{ __('Add new product') }}</h5>
            <a href="{{ route('admin.product.index') }}"
                class="btn btn-outline-info float-right btn-sm d-inline-block">{{ __('View all') }}</a>
        </div>
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card card-dark">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">{{ __('Title') }}</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                        @error('title')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea name="description" id="description" cols="30" rows="5"
                            class="form-control textarea">{{ old('description') }}</textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="short_description">{{ __('Short description') }}</label>
                        <textarea name="short_description" id="short_description" cols="30" rows="5"
                            class="form-control">{{ old('short_description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="brand_id">{{ __('Brand') }}</label>
                        <select name="brand_id" id="brand_id" class="form-control">
                            <option value="">{{ __('Select brand') }}</option>
                            @if(count($brands) > 0)
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" @if(old('brand_id')==$brand->id) selected="selected"
                                @endif>{{ $brand->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        @error('brand_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_id">{{ __('Category') }}</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">{{ __('Select category') }}</option>
                            @if(count($productCategories) > 0)
                            @foreach($productCategories as $productCategory)
                            <option value="{{ $productCategory->id }}" @if(old('category_id')==$productCategory->id)
                                selected="selected"
                                @endif>{{ $productCategory->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">{{ __('Price') }}</label>
                        <input type="number" value="{{ old('price') }}" id="price" step="any" min="0" name="price"
                            class="form-control">
                        @error('price')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="selling_price">{{ __('Selling Price') }}</label>
                        <input type="number" value="{{ old('selling_price') }}" id="selling_price" step="any" min="0"
                            name="selling_price" class="form-control">
                        @error('selling_price')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sku">{{ __('SKU') }}</label>
                        <input type="text" value="{{ old('sku') }}" id="sku" name="sku" class="form-control">
                        @error('sku')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="qty">{{ __('Quantity') }}</label>
                        <input type="number" value="{{ old('qty') }}" id="qty" step="any" min="0" name="qty"
                            class="form-control">
                        @error('qty')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="virtual">{{ __('Virtual') }}</label>
                        <select name="virtual" id="virtual" class="form-control">
                            <option value="0" @if(old('virtual')===false)) selected="selected" @endif>{{ __('No') }}
                            </option>
                            <option value="1" @if(old('virtual')===true) selected="selected" @endif>{{ __('Yes') }}
                            </option>
                        </select>
                        @error('virtual')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">{{ __('Thumbnail') }}</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="thumbnail">
                                <label class="custom-file-label" for="exampleInputFile">{{ __('Choose file') }}</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text" id="">{{ __('Upload') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" @if(old('status')===true) selected="selected" @endif>
                                {{ __('Published') }}</option>
                            <option value="0" @if(old('status')===false) selected="selected" @endif>{{ __('Draft') }}
                            </option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ __('Save Product') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection