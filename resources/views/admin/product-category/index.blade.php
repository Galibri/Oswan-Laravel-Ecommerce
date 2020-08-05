@extends('layouts.admin')

@section('meta-title', __('Product Categories'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="page-title bg-dark text-light p-3 mb-3 rounded">
            <h5 class="d-inline-block text-uppercase mb-0">{{ __('All product categories') }}</h5>
            <a href="{{ route('admin.product-category.create') }}"
                class="btn btn-outline-info float-right btn-sm d-inline-block">{{ __('Add new') }}</a>
        </div>
        <div class="page-links">
            <div class="btn-group mb-3">
                <a href="{{ route('admin.product-category.index') . '?type=all' }}"
                    class="btn btn-sm btn-outline-dark {{ request()->get('type') == 'all' ? 'active' : ''  }}">{{ __('All') }}</a>
                <a href="{{ route('admin.product-category.index') }}"
                    class="btn btn-sm btn-outline-dark {{ request()->has('type') ? '' : 'active'  }}">{{ __('Published') }}</a>
                <a href="{{ route('admin.product-category.index') . '?type=trash' }}"
                    class="btn btn-sm btn-outline-dark {{ request()->get('type') == 'trash' ? 'active' : ''  }}">{{ __('Trashed') }}</a>
            </div>
        </div>
        <div class="card card-dark">
            <div class="card-body">
                @if(count($productCategories) > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td></td>
                            <td colspan="5">
                                <button id="bulk-delete" type="submit"
                                    class="btn btn-danger">{{ __('Delete selected') }}</button>
                                <button id="bulk-force-delete" type="submit"
                                    class="btn btn-danger">{{ __('Permanently Delete selected') }}</button>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Thumbnail</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productCategories as $productCategory)
                        <tr>
                            <th><input type="checkbox" class="bulk-cat-id" data-id="{{ $productCategory->id }}"></th>
                            <td>
                                <img height="40" src="{{ asset($productCategory->default_thumbnail) }}"
                                    alt="{{ $productCategory->name }}">
                            </td>
                            <td>{{ $productCategory->name }}</td>
                            <td>{{ $productCategory->slug }}</td>
                            <td><span
                                    class="badge badge-@if($productCategory->status == true){{ 'success' }} @else{{ 'warning' }} @endif">{{ $productCategory->status_text }}</span>
                            </td>
                            <td>
                                @if($productCategory->deleted_at != null)
                                <form action="{{ route('admin.product-category.restore', $productCategory->id ) }}"
                                    class="d-inline-block" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                            class="fas fa-recycle"></i></button>
                                </form>
                                <form action="{{ route('admin.product-category.force_delete', $productCategory->id) }}"
                                    class="d-inline-block" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                        title="{{ __('Permanently Delete') }}"><i class="fas fa-trash"></i></button>
                                </form>
                                @else
                                <a href="{{ route('admin.product-category.show', $productCategory->id) }}"
                                    class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.product-category.edit', $productCategory->id) }}"
                                    class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.product-category.destroy', $productCategory->id) }}"
                                    class="d-inline-block" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                            class="fas fa-trash-alt"></i></button>
                                </form>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    {{ $productCategories->links() }}
                </table>
                @else
                <div class="no-product-found">
                    <h3>{{ __('No product found.') }}</h3>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    (function($) {
        $(document).ready(function() {
            let cat_ids = []
            $(document).on('click', '.bulk-cat-id', function() {
                let data_id = $(this).data('id');
                if($(this).prop('checked')) {
                    if(!cat_ids.includes(data_id)) {
                        cat_ids.push(data_id)
                    }
                } else {
                    if(cat_ids.includes(data_id)) {
                        cat_ids = cat_ids.filter(element => element != data_id)
                    }
                }
                
                // console.log(cat_ids)
            })
            $('#bulk-delete').on('click', function() {
                if(cat_ids.length > 0) {
                    axios.post("{{ route('admin.product-category.bulk_delete') }}", {
                        cat_ids
                    })
                    .then(response => {
                        if(response.data.message == 'success') {
                            window.location.href = window.location.href
                        }
                    })
                    .catch(error => console.log(error))
                }
            })
            $('#bulk-force-delete').on('click', function() {
                if(cat_ids.length > 0) {
                    axios.post("{{ route('admin.product-category.bulk_force_delete') }}", {
                        cat_ids
                    })
                    .then(response => {
                        if(response.data.message == 'success') {
                            window.location.href = window.location.href
                        }
                    })
                    .catch(error => console.log(error))
                }
            })
        })
    })(jQuery)
</script>
@endsection