@extends('layouts.master')

@section('title') Edit Item @endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Items @endslot
    @slot('title') Edit Item @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <h6>Edit Item: {{ $item->item_name }}</h6>
            </div>
            <div class="card-body">
                <form id="editItemForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $item->id }}">

                    <!-- Item Name -->
                    <div class="mb-3">
                        <label class="form-label">Item Name</label>
                        <input type="text" name="item_name" class="form-control" value="{{ $item->item_name }}" required>
                        <input type="hidden" name="user_id" class="form-control" value="{{Auth::user()->id}}" >
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#pricing" role="tab">Pricing</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#stock" role="tab">Stock</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#other" role="tab">Other</a></li>
                    </ul>

                    <div class="tab-content text-muted">
                        <!-- Pricing -->
                        <div class="tab-pane fade show active" id="pricing" role="tabpanel">
                            <div class="row g-3">
                                @forelse($item->pricings as $i => $pricing)
                                    <div class="col-md-6">
                                        <label class="form-label">Unit</label>
                                        <input type="text" class="form-control" name="pricings[{{ $i }}][unit]" value="{{ $pricing->unit }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sales Price</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="pricings[{{ $i }}][salesprice_amount]" value="{{ $pricing->salesprice_amount }}">
                                            <select class="form-select" name="pricings[{{ $i }}][salesprice_tax]" style="max-width:100px;">
                                                <option value="">GST</option>
                                                <option value="1" {{ $pricing->salesprice_tax == 1 ? 'selected' : 0 }}>With GST</option>
                                                <option value="0" {{ $pricing->salesprice_tax == 0 ? 'selected' : 1 }}>Without GST</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Purchase Price</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="pricings[{{ $i }}][purches_price_amount]" value="{{ $pricing->purches_price_amount }}">
                                            <select class="form-select" name="pricings[{{ $i }}][purches_price_tax]" style="max-width:100px;">
                                                <option value="">GST</option>
                                                <option value="1" {{ $pricing->purches_price_tax == 1 ? 'selected' : 0 }}>With GST</option>
                                                <option value="0" {{ $pricing->purches_price_tax == 0 ? 'selected' : 1 }}>Without GST</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">MRP Price</label>
                                        <input type="number" class="form-control" name="pricings[{{ $i }}][mrp_price]" value="{{ $pricing->mrp_price }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">GST %</label>
                                        <select class="form-control" name="pricings[{{ $i }}][gst]">
                                            <option value="">Select GST</option>
                                            <option value="5" {{ $pricing->gst == 5 ? 'selected' : '' }}>5%</option>
                                            <option value="12" {{ $pricing->gst == 12 ? 'selected' : '' }}>12%</option>
                                            <option value="18" {{ $pricing->gst == 18 ? 'selected' : '' }}>18%</option>
                                            <option value="28" {{ $pricing->gst == 28 ? 'selected' : '' }}>28%</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">HSN No</label>
                                        <input type="text" class="form-control" name="pricings[{{ $i }}][hsn_no]" value="{{ $pricing->hsn_no }}">
                                    </div>
                                @empty
                                    <div class="col-md-6">
                                        <label class="form-label">Unit</label>
                                        <input type="text" class="form-control" name="pricings[0][unit]">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sales Price</label>
                                        <input type="number" class="form-control" name="pricings[0][salesprice_amount]">
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Stock -->
                        <div class="tab-pane fade" id="stock" role="tabpanel">
                            <div class="row g-3">
                                @forelse($item->stocks as $i => $stock)
                                    <div class="col-md-6">
                                        <label class="form-label">Opening Stock</label>
                                        <input type="number" class="form-control" name="stocks[{{ $i }}][opening_stock]" value="{{ $stock->opening_stock }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">As of Date</label>
                                        <input type="date" class="form-control" name="stocks[{{ $i }}][as_of_date]" value="{{ $stock->as_of_date }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Low Stock Quantity</label>
                                        <input type="number" class="form-control" name="stocks[{{ $i }}][low_alert_quantity]" value="{{ $stock->low_alert_quantity }}">
                                    </div>
                                @empty
                                    <div class="col-md-6">
                                        <label class="form-label">Opening Stock</label>
                                        <input type="number" class="form-control" name="stocks[0][opening_stock]">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">As of Date</label>
                                        <input type="date" class="form-control" name="stocks[0][as_of_date]">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Low Stock Quantity</label>
                                        <input type="number" class="form-control" name="stocks[0][low_alert_quantity]">
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Other -->
                        <div class="tab-pane fade" id="other" role="tabpanel">
                            <div class="mb-3">
                                <label class="form-label">Existing Images</label>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach($item->otherImages as $img)
                                        <img src="{{ $img->image_path }}" width="100" class="img-thumbnail">
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Add New Images</label>
                                <input type="file" class="form-control" name="images[]" multiple>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="item_category_id" class="form-control">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $item->details && $item->details->item_category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->item_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Item Description</label>
                                <textarea name="item_description" class="form-control" rows="3">{{ $item->details->item_description ?? '' }}</textarea>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="show_online_store" {{ $item->details && $item->details->show_online_store ? 'checked' : '' }}>
                                <label class="form-check-label">Show on Online Store</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">Update Item</button>
                        <a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#editItemForm').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
    url: '{{ route("items.update", $item->id) }}',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    success: function(response){
        alert(response.message);
        window.location.href = '{{ route("items.index") }}';
    },
    error: function(xhr){
        if(xhr.status === 422){
            let errors = xhr.responseJSON.errors;
            let messages = '';
            for(let key in errors){
                messages += errors[key].join(', ') + '\n';
            }
            alert(messages);
        } else {
            alert('Something went wrong.');
        }
    }
});

    });
});
</script>
@endsection
