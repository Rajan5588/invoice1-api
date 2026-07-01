@extends('layouts.master')

@section('title') Item Details @endsection

@section('content')
<div class="row">
    <div class="col-xxl-3">
        <div class="card mt-n5 text-center">
            <div class="card-body">
                <div class="profile-user position-relative d-inline-block mx-auto mb-3">
                  
                </div>
                <h5 class="fs-16 mb-1">{{ $item->item_name }}</h5>
                <p class="text-muted mb-1">Owned by: {{ $item->user?->name ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            <div class="card-header">
                <ul class="nav nav-tabs nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#detailsTab">Details</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#pricingsTab">Pricings</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#stocksTab">Stocks</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#imagesTab">Other Images</a></li>
                     <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#profileTab">User</a></li>
           
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content">

                    {{-- Item Details --}}
                    <div class="tab-pane fade show active" id="detailsTab">
                        @if($item->details)
                            <table class="table table-bordered">
                                <tr><th>Category</th><td>{{ $item->details->category?->item_category_name ?? '-' }}</td></tr>
                                <tr><th>Description</th><td>{{ $item->details->item_description ?? '-' }}</td></tr>
                                <tr><th>Show Online Store</th><td>{{ $item->details->show_online_store ? 'Yes' : 'No' }}</td></tr>
                                <tr><th>Created At</th><td>{{ $item->created_at?->format('d M Y, h:i A') }}</td></tr>
                            </table>
                        @else
                            <p>No item details available</p>
                        @endif
                    </div>

                    {{-- Pricings --}}
                    <div class="tab-pane fade" id="pricingsTab">
                        @if($item->pricings->isNotEmpty())
                            <table class="table table-bordered">
                                <tr>
                                    <th>Unit</th>
                                    <th>Sales Price</th>
                                    <th>Sales Tax</th>
                                    <th>Purchase Price</th>
                                    <th>Purchase Tax</th>
                                    <th>MRP</th>
                                    <th>GST</th>
                                </tr>
                                @foreach($item->pricings as $pricing)
                                    <tr>
                                        <td>{{ $pricing->unit }}</td>
                                        <td>₹{{ number_format($pricing->salesprice_amount, 2) }}</td>
                                        <td>{{ $pricing->salesprice_tax }}%</td>
                                        <td>₹{{ number_format($pricing->purches_price_amount, 2) }}</td>
                                        <td>{{ $pricing->purches_price_tax }}%</td>
                                        <td>₹{{ number_format($pricing->mrp_price, 2) }}</td>
                                        <td>{{ $pricing->gst }}%</td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p>No pricing records</p>
                        @endif
                    </div>

                    {{-- Stocks --}}
                    <div class="tab-pane fade" id="stocksTab">
                        @if($item->stocks->isNotEmpty())
                            <table class="table table-bordered">
                                <tr>
                                    <th>Opening Stock</th>
                                    <th>As of Date</th>
                                    <th>Low Alert Status</th>
                                    <th>Low Alert Quantity</th>
                                </tr>
                                @foreach($item->stocks as $stock)
                                    <tr>
                                        <td>{{ $stock->opening_stock }}</td>
                                        <td>{{ $stock->as_of_date ? \Carbon\Carbon::parse($stock->as_of_date)->format('d M, Y') : '-' }}</td>
                                        <td>{{ $stock->low_alert_status ? 'Yes' : 'No' }}</td>
                                        <td>{{ $stock->low_alert_quantity }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p>No stock records</p>
                        @endif
                    </div>

                    {{-- Other Images --}}
                    <div class="tab-pane fade" id="imagesTab">
                        @if($item->otherImages->isNotEmpty())
                            <div class="row">
                                @foreach($item->otherImages as $image)
                                    <div class="col-md-3 mb-3">
                                        <img src="{{ asset($image->image_path) }}" class="img-fluid rounded shadow" alt="item-image">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No additional images</p>
                        @endif
                    </div>
                    
                     <div class="tab-pane fade" id="profileTab">
                        @if($item->user)
                            <table class="table table-bordered">
                                    <tr><th>Name</th><td>{{ $item->user->name ?? '' }}</td></tr>
                                <tr><th>Full Address</th><td>{{ $item->user->full_address ?? '' }}</td></tr>
                                <tr><th>State</th><td>{{ $item->user->state ?? '' }}</td></tr>
                                <tr><th>District</th><td>{{ $item->user->district ?? '' }}</td></tr>
                                <tr><th>Phone</th><td>{{ $item->user->phone ?? '' }}</td></tr>
                                <tr><th>Email</th><td>{{ $item->user->email ?? '' }}</td></tr>
                                <tr><th>Status</th><td>{{ ucfirst($item->user->status) }}</td></tr>
                                <tr><th>Subscription Expired Date</th><td>{{ $item->user->subs_expired_date ?? '' }}</td></tr>
                                <tr><th>OTP Verified</th><td>{{ $item->user->otp_verified == '1' ? 'Yes' : 'No' }}</td></tr>
                                <tr><th>Created At</th><td>{{ $item->user->created_at ? $item->user->created_at->format('d M Y, h:i A') : '' }}</td></tr>
                            </table>
                        @else
                            <p>No user information available</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
