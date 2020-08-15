@extends('layouts.admin')

@section('meta-title', $brand->name)

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card card-dark">
            <div class="card-header">
                <h5 class="d-inline-block mt-1">{{ $brand->name }}</h5>
                <a href="{{ route('admin.brand.index') }}"
                    class="btn btn-outline-warning float-right btn-sm">{{ __('View All') }}</a>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>{{ __('Name') }}: </strong>{{ $brand->name }}
                    </li>
                    <li class="list-group-item">
                        <strong>{{ __('Slug') }}: </strong>{{ $brand->slug }}
                    </li>
                    <li class="list-group-item">
                        <strong>{{ __('Description') }}: </strong>{!! $brand->description !!}
                    </li>
                    <li class="list-group-item">
                        <div><strong>{{ __('Thumbnail') }}: </strong></div>
                        <img height="100" src="{{ asset($brand->default_thumbnail) }}" alt="{{ $brand->name }}">
                    </li>
                    <li class="list-group-item">
                        <strong>{{ __('Status') }}: </strong>{{ $brand->status_text }}
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('admin.brand.edit', $brand->id) }}" class="btn btn-outline-info">{{ __('Edit Product
                        Brand') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection