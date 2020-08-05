@extends('layouts.admin')

@section('meta-title', $productCategory->name)

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card card-dark">
            <div class="card-header">
                <h5 class="d-inline-block mt-1">{{ $productCategory->name }}</h5>
                <a href="{{ route('admin.product-category.index') }}"
                    class="btn btn-outline-warning float-right btn-sm">{{ __('View All') }}</a>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>{{ __('Name') }}: </strong>{{ $productCategory->name }}
                    </li>
                    <li class="list-group-item">
                        <strong>{{ __('Slug') }}: </strong>{{ $productCategory->slug }}
                    </li>
                    <li class="list-group-item">
                        <strong>{{ __('Description') }}: </strong>{!! $productCategory->description !!}
                    </li>
                    <li class="list-group-item">
                        <div><strong>{{ __('Thumbnail') }}: </strong></div>
                        <img height="100" src="{{ asset($productCategory->default_thumbnail) }}"
                            alt="{{ $productCategory->name }}">
                    </li>
                    <li class="list-group-item">
                        <strong>{{ __('Status') }}: </strong>{{ $productCategory->status_text }}
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('admin.product-category.edit', $productCategory->id) }}"
                            class="btn btn-outline-info">{{ __('Edit Product
                        Category') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection