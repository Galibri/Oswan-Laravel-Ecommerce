@extends('layouts.admin')

@section('meta-title', __('Add new gallery'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('admin.gallery.store', $product_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card card-dark">
                <div class="card-header">
                    <h5 class="d-inline-block mt-1">{{ __('Add new gallery') }}</h5>
                    <a href="{{ route('admin.product.index') }}"
                        class="btn btn-outline-warning float-right btn-sm">{{ __('Back to product') }}</a>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputFile">Upload Images</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="images[]"
                                    multiple>
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text" id="">Upload</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">{{ __('Add to gallery') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@if(count($galleries) > 0)
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @foreach($galleries as $gallery)
                    <div class="col-md-3">
                        <div class="single-img-wrapper">
                            <img src="{{ asset($gallery) }}" class="img-fluid">
                            <form action="{{ route('admin.gallery.destroy', [$product_id, $gallery_id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="image_name" value="{{ $gallery }}">
                                <button type="submit" class="img-dlt-btn btn"><i
                                        class="fas fa-times-circle"></i></button>
                            </form>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection