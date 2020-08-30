@extends('layouts.admin')

@section('meta-title', __('Home Category Options'))

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <form action="{{ route('admin.settings.home.category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card card-dark">
                <div class="card-body">
                    <div class="form-group">
                        <label for="home_products_by_categories">Select Categories to show on homepage:</label>
                        <select name="home_products_by_categories[]" id="home_products_by_categories"
                            class="form-control" multiple>
                            @foreach($productCategories as $productCategory)
                            <option value="{{ $productCategory->id }}" @if(in_array($productCategory->id, $selected))
                                selected="selected" @endif >{{ $productCategory->name }}</option>
                            @endforeach
                        </select>
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