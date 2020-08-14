@extends('layouts.admin')

@section('meta-title', __('Products'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="page-title bg-dark text-light p-3 mb-3 rounded">
            <h5 class="d-inline-block text-uppercase mb-0">{{ __('All products') }}</h5>
            <a href="{{ route('admin.product.create') }}"
                class="btn btn-outline-info float-right btn-sm d-inline-block">{{ __('Add new') }}</a>
        </div>
        <div class="card card-dark">
            <div class="card-body">
                @if(count($products) > 0)
                <div class="row">
                    <div class="col">
                        <div class="bulk-action-area mb-3">
                            <div class="bulk-select d-inline-block">
                                <select name="dropdown-action" id="dropdown-action" class="form-control">
                                    <option>Select action</option>
                                    <option value="bulk-delete">{{ __('Delete') }}</option>
                                    <option value="bulk-force-delete">{{ __('Permanent Delete') }}</option>
                                    <option value="bulk-restore">{{ __('Restore') }}</option>
                                    <option value="bulk-active">{{ __('Make active') }}</option>
                                    <option value="bulk-inactive">{{ __('Make inactive') }}</option>
                                </select>
                            </div>
                            <button id="delete-action" class="btn btn-dark">{{ __('Submit') }}</button>
                        </div>
                    </div>
                    <div class="col text-center">
                        <a href="{{ route('admin.product.export_to_excel') }}"
                            class="btn btn-success">{{ __('Excel') }}</a>
                        <a href="{{ route('admin.product.export_to_csv') }}" class="btn btn-info">{{ __('CSV') }}</a>
                        <a href="{{ route('admin.product.export_to_pdf') }}" class="btn btn-primary">{{ __('PDF') }}</a>
                    </div>
                    <div class="col text-right">
                        <div class="page-links">
                            <div class="btn-group mb-3">
                                <a href="{{ route('admin.product.index') . '?type=all' }}"
                                    class="btn btn-outline-dark {{ request()->get('type') == 'all' ? 'active' : ''  }}">{{ __('All') }}</a>
                                <a href="{{ route('admin.product.index') }}"
                                    class="btn btn-outline-dark {{ request()->has('type') ? '' : 'active'  }}">{{ __('Published') }}</a>
                                <a href="{{ route('admin.product.index') . '?type=trash' }}"
                                    class="btn btn-outline-dark {{ request()->get('type') == 'trash' ? 'active' : ''  }}">{{ __('Trashed') }}</a>
                            </div>
                        </div>
                    </div>

                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px;"><input type="checkbox" id="select-all"></th>
                            <th>Thumbnail</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Gallery</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <th><input type="checkbox" class="bulk-item-id" data-id="{{ $product->id }}"></th>
                            <td>
                                <img height="40" src="{{ asset($product->default_thumbnail) }}"
                                    alt="{{ $product->title }}">
                            </td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->slug }}</td>
                            <td><span
                                    class="badge badge-@if($product->status == true){{ 'success' }} @else{{ 'warning' }} @endif">{{ $product->status_text }}</span>
                            </td>
                            <td><a href="{{ route('admin.gallery.create', $product->id) }}" class="btn btn-info"><i
                                        class="far fa-images"></i></a></td>
                            <td>
                                @if($product->deleted_at != null)
                                <form action="{{ route('admin.product.restore', $product->id ) }}"
                                    class="d-inline-block" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm"><i
                                            class="fas fa-recycle"></i></button>
                                </form>
                                <form action="{{ route('admin.product.force_delete', $product->id) }}"
                                    class="d-inline-block" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        title="{{ __('Permanently Delete') }}"><i class="fas fa-trash"></i></button>
                                </form>
                                @else
                                <a href="{{ route('admin.product.show', $product->id) }}"
                                    class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-info btn-sm"><i
                                        class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.product.destroy', $product->id) }}" class="d-inline-block"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fas fa-trash-alt"></i></button>
                                </form>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="no-product-found">
                    <h3>{{ __('No product found.') }}</h3>
                </div>
                @endif
            </div>
            <div class="card-footer text-right">
                <div class="d-inline-block">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    (function($) {
        $(document).ready(function() {
            let item_ids = []
            $(document).on('click', '.bulk-item-id', function() {
                let data_id = $(this).data('id');
                if($(this).prop('checked')) {
                    if(!item_ids.includes(data_id)) {
                        item_ids.push(data_id)
                    }
                } else {
                    if(item_ids.includes(data_id)) {
                        item_ids = item_ids.filter(element => element != data_id)
                    }
                }
                console.log(item_ids)
                
            })

            // Multi select
            $('#select-all').on('click', function() {
                if($(this).prop('checked')) {
                    $.each($('.bulk-item-id').prop('checked', 'checked'), function() {
                        data_id = $(this).data('id')
                        if(!item_ids.includes(data_id)) {
                            item_ids.push(data_id)
                        }
                    })
                } else  {
                    $('.bulk-item-id').prop('checked', '');
                    item_ids = []
                }
            })

            // Bulk action
            $('#delete-action').on('click', function() {

                if($('#dropdown-action').val() == 'bulk-delete') {
                    
                    if(item_ids.length > 0) {
                        axios.post("{{ route('admin.brand.bulk_delete') }}", {
                            item_ids
                        })
                        .then(response => {
                            if(response.data.message == 'success') {
                                window.location.href = window.location.href
                            }
                        })
                        .catch(error => console.log(error))
                    }
                        
                } else if($('#dropdown-action').val() == 'bulk-force-delete') {
                    
                    if(item_ids.length > 0) {
                        axios.post("{{ route('admin.brand.bulk_force_delete') }}", {
                            item_ids
                        })
                        .then(response => {
                            if(response.data.message == 'success') {
                                window.location.href = window.location.href
                            }
                        })
                        .catch(error => console.log(error))
                    }
                    
                } else if($('#dropdown-action').val() == 'bulk-restore') {
                    
                    if(item_ids.length > 0) {
                        axios.post("{{ route('admin.brand.bulk_restore') }}", {
                            item_ids
                        })
                        .then(response => {
                            if(response.data.message == 'success') {
                                window.location.href = window.location.href
                            }
                        })
                        .catch(error => console.log(error))
                    }
                    
                } else if($('#dropdown-action').val() == 'bulk-active') {
                    
                    if(item_ids.length > 0) {
                        axios.post("{{ route('admin.brand.bulk_active') }}", {
                            item_ids
                        })
                        .then(response => {
                            if(response.data.message == 'success') {
                                window.location.href = window.location.href
                            }
                        })
                        .catch(error => console.log(error))
                    }
                    
                } else if($('#dropdown-action').val() == 'bulk-inactive') {
                    
                    if(item_ids.length > 0) {
                        axios.post("{{ route('admin.brand.bulk_inactive') }}", {
                            item_ids
                        })
                        .then(response => {
                            if(response.data.message == 'success') {
                                window.location.href = window.location.href
                            }
                        })
                        .catch(error => console.log(error))
                    }
                    
                }
            })
            
            
        })
    })(jQuery)
</script>
@endsection