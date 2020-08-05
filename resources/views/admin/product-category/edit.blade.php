@extends('layouts.admin')

@section('meta-title', __('Edit category'))

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <form action="{{ route('admin.product-category.update', $productCategory->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card card-dark">
                <div class="card-header">
                    <h5 class="d-inline-block mt-1">{{ __('Edit category') }}</h5>
                    <a href="{{ route('admin.product-category.index') }}"
                        class="btn btn-outline-warning float-right btn-sm">{{ __('View All') }}</a>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ $productCategory->name }}">
                    </div>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="form-group">
                        <img height="50" src="{{ asset($productCategory->default_thumbnail) }}"
                            alt="{{ $productCategory->name }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Thumbnail</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="thumbnail">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text" id="">Upload</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option {{ $productCategory->status == 1 ? 'selected="selected"' : '' }} value="1">Active
                            </option>
                            <option {{ $productCategory->status == 0 ? 'selected="selected"' : '' }} value="0">Inactive
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control textarea" id="description" cols="30"
                            rows="6">{{ $productCategory->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">{{ __('Save Product Category') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection