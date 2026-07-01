@extends('layouts.master')

@section('title') User Details @endsection

@section('content')

<div class="row">
    <div class="col-xxl-3">
        <div class="card mt-n5 text-center">
            <div class="card-body">
                <div class="profile-user position-relative d-inline-block mx-auto mb-3">
                    <img src="{{ $user->avatar ? asset($user->avatar) : URL::asset('build/images/users/avatar-1.jpg') }}" 
                         class="rounded-circle avatar-xl img-thumbnail" alt="user-profile-image">
                </div>
                <h5 class="fs-16 mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-1">{{ $user->email }}</p>
                <p class="text-muted mb-0">{{ $user->phone }}</p>
            </div>
        </div>
    </div>

    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            <div class="card-header">
                <ul class="nav nav-tabs nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#profileTab">Profile</a></li>
                    <!--<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#subscriptionTab">Subscription</a></li>-->
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#businessTab">Business</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#customersTab">Customers</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#invoicesTab">Invoices</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#transactionsTab">Transactions</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#historiesTab">Histories</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#itemsTab">Items</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#categoriesTab">Item Categories</a></li>
                    <!--<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#itemDetailsTab">Item Details</a></li>-->
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content">
                    
                    {{-- Profile --}}
                   <div class="tab-pane fade show active" id="profileTab">
    <table class="table table-bordered">
        <tr>
            <th>Full Address</th>
            <td>{{ $user->full_address ?? '' }}</td>
        </tr>
        <tr>
            <th>State</th>
            <td>{{ $user->state ?? '' }}</td>
        </tr>
        <tr>
            <th>District</th>
            <td>{{ $user->district ?? '' }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $user->phone ?? '' }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email ?? '' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($user->status) }}</td>
        </tr>
        <tr>
            <th>Subscription Expired Date</th>
            <td>{{ $user->subs_expired_date ?? '' }}</td>
        </tr>
        <tr>
            <th>OTP Verified</th>
            <td>{{ $user->otp_verified == '1' ? 'Yes' : 'No' }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $user->created_at ? $user->created_at->format('d M Y, h:i A') : '' }}</td>
        </tr>
    </table>
</div>

                    {{-- Subscription --}}
                    <!--<div class="tab-pane fade" id="subscriptionTab">-->
                    <!--    @if($user->subscription)-->
                    <!--        <table class="table table-bordered">-->
                    <!--            <tr><th>Current Plan</th><td>{{ $user->subscription->name }}</td></tr>-->
                    <!--            <tr><th>Expiry Date</th><td>{{ $user->subs_expired_date?->format('d M, Y') }}</td></tr>-->
                    <!--        </table>-->
                    <!--    @else-->
                    <!--        <p>No active subscription</p>-->
                    <!--    @endif-->
                    <!--</div>-->

                    {{-- Business Profiles --}}
                   <div class="tab-pane fade" id="businessTab">
    @if($user->businessProfiles->isNotEmpty())
        <table class="table table-bordered">
            <tr>
                <th>Business ID</th>
                <th>Business Name</th>
                <th>Description</th>
                <th>GST No</th>
                <th>Phone (Primary)</th>
                <th>Phone (Secondary)</th>
                <th>Email</th>
                <th>Business Email</th>
                <th>Address</th>
                <th>Pincode</th>
                <th>State</th>
                <th>Category</th>
                <th>Type</th>
                <th>Website</th>
                <th>Created At</th>
            </tr>
            @foreach($user->businessProfiles as $bp)
                <tr>
                    <td>{{ $bp->business_id }}</td>
                    <td>{{ $bp->business_name ?? '-' }}</td>
                    <td>{{ $bp->business_desc ?? '-' }}</td>
                    <td>{{ $bp->gst_no ?? '-' }}</td>
                    <td>{{ $bp->phone_no_first }}</td>
                    <td>{{ $bp->phone_no_second ?? '-' }}</td>
                    <td>{{ $bp->email }}</td>
                    <td>{{ $bp->business_email ?? '-' }}</td>
                    <td>{{ $bp->business_address }}</td>
                    <td>{{ $bp->pincode }}</td>
                    <td>{{ $bp->business_state }}</td>
                    <td>{{ $bp->business_category }}</td>
                    <td>{{ $bp->business_type ?? '-' }}</td>
                    <td>{{ $bp->website ?? '-' }}</td>
                    <td>{{ $bp->created_at ? $bp->created_at->format('d M Y') : '-' }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p>No business profiles</p>
    @endif
</div>


                    {{-- Customers --}}
                   <div class="tab-pane fade" id="customersTab">
    @if($user->customers->isNotEmpty())
        <table class="table table-bordered">
            <tr>
                <th>Customer Name</th>
                <th>Company Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>GST</th>
                <th>GST Treatment</th>
                <th>Place of Supply</th>
                <th>State</th>
            </tr>
            @foreach($user->customers as $customer)
                <tr>
                    <td>{{ $customer->customer_name }}</td>
                    <td>{{ $customer->company_name ?? '-' }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone ?? '-' }}</td>
                    <td>{{ $customer->gst ?? '-' }}</td>
                    <td>{{ $customer->gst_treatment ?? '-' }}</td>
                    <td>{{ $customer->place_of_supply ?? '-' }}</td>
                    <td>{{ $customer->state ?? '-' }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p>No customers</p>
    @endif
</div>


                    {{-- Invoices --}}
              <div class="tab-pane fade" id="invoicesTab">
    @if($user->invoices->isNotEmpty())
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Payment Type</th>
                <th>Total Amount</th>
                <th>Amount Received</th>
                <th>Discount (%)</th>
                <th>Round Off</th>
                <th>Date</th>
                <th>Download</th>
            </tr>
            @foreach($user->invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->customer_name }}</td>
                    <td>{{ ucfirst($invoice->payment_type) }}</td>
                    <td>₹{{ number_format($invoice->total_amount, 2) }}</td>
                    <td>₹{{ number_format($invoice->amount_received, 2) }}</td>
                    <td>{{ $invoice->discount_percent }}%</td>
                    <td>₹{{ number_format($invoice->round_off, 2) }}</td>
                    <td>{{ $invoice->created_at->format('d M, Y') }}</td>
                    <td>
                        <a href="" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-download"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <p>No invoices</p>
    @endif
</div>


                    {{-- Transactions --}}
                   <div class="tab-pane fade" id="transactionsTab">
    @if($user->transactions->isNotEmpty())
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Transaction Date</th>
                <th>Created At</th>
            </tr>
            @foreach($user->transactions as $tx)
                <tr>
                    <td>{{ $tx->id }}</td>
                    <td>{{ $tx->customer_name }}</td>
                    <td>{{ ucfirst($tx->status) }}</td>
                    <td>{{ \Carbon\Carbon::parse($tx->date)->format('d M, Y') }}</td>
                    <td>{{ $tx->created_at ? $tx->created_at->format('d M, Y h:i A') : '-' }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p>No transactions</p>
    @endif
</div>


                    {{-- Histories --}}
                {{-- Items --}}
<div class="tab-pane fade" id="historiesTab">
    @if($user->histories->isNotEmpty())
        <table class="table table-bordered">
            <tr>
                <th>Description</th>
                <th>Date</th>
            </tr>
            @foreach($user->histories as $history)
                <tr>
                    <td>{{ $history->description }}</td>
                    <td>{{ $history->created_at ? $history->created_at->format('d M, Y H:i') : '-' }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p>No history available</p>
    @endif
</div>


                    {{-- Items --}}
                    <div class="tab-pane fade" id="itemsTab">
                        @if($user->items->isNotEmpty())
                        <table class="table table-bordered">
                            <tr><th>Name</th></tr>
                            @foreach($user->items as $item)
                                <tr>
                                    <td>{{ $item->item_name }}</td>
                                 
                                </tr>
                            @endforeach
                        </table>
                        @else
                            <p>No items</p>
                        @endif
                    </div>

                    {{-- Item Categories --}}
                    <div class="tab-pane fade" id="categoriesTab">
                        @if($user->itemCategories->isNotEmpty())
                        <table class="table table-bordered">
                            <tr><th>Name</th></tr>
                            @foreach($user->itemCategories as $cat)
                                <tr>
                                    <td>{{ $cat->item_category_name }}</td>
                                </tr>
                            @endforeach
                        </table>
                        @else
                            <p>No categories</p>
                        @endif
                    </div>

                  

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
