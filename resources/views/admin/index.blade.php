@extends('layouts.master')

@section('title')
    @lang('translation.dashboards')
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/apexcharts/apexcharts.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="container-fluid">

    {{-- Greeting --}}
    @php
        $currentTime = Carbon\Carbon::now('Asia/Kolkata');
        $hour = $currentTime->hour;

        if ($hour >= 5 && $hour < 12) {
            $greeting = 'Good Morning';
        } elseif ($hour >= 12 && $hour < 17) {
            $greeting = 'Good Afternoon';
        } elseif ($hour >= 17 && $hour < 21) {
            $greeting = 'Good Evening';
        } else {
            $greeting = 'Good Night';
        }
    @endphp
    <h4 class="mb-4">{{ $greeting }}, {{ Auth::user()->name }}!</h4>

    {{-- Quick Stats --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Today's Sales</p>
                    <h3>{{ $todaySales }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Pending Invoices</p>
                    <h3>{{ $pendingInvoices }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Paid Invoices</p>
                    <h3>{{ $paidInvoices }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <p class="text-muted mb-1">Overdue Amount</p>
                    <h3>{{ $overdueAmount }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Invoice List & Charts --}}
    <div class="row">
     <div class="col-lg-6">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Invoice List</h5>
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Invoice #</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->invoice->id ?? 'N/A' }}</td>
                                <td>{{ $transaction->customer_name ?? $transaction->invoice->customer->name ?? 'N/A' }}</td>
                                <td>{{ $transaction->date ?? $transaction->invoice->date ?? 'N/A' }}</td>
                                <td>{!! $transaction->status_badge !!}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No transactions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


        {{-- Charts --}}
        <div class="col-lg-6">
            <!--<div class="card shadow-sm mb-3">-->
            <!--    <div class="card-body">-->
            <!--        <h5 class="mb-3">Monthly Revenue</h5>-->
            <!--        <div id="revenueChart"></div>-->
            <!--    </div>-->
            <!--</div>-->

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Invoice Status</h5>
                    <div id="statusChart"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="row mt-4">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <a href="{{ route('invoices.create') }}" class="btn btn-primary me-2">Create Invoice</a>
                    <a href="{{ route('users.create') }}" class="btn btn-info me-2">Add Users</a>
                    <a href="{{route('items.index')}}" class="btn btn-primary me-2">Create Items</a>
                    
                    <a href="" class="btn btn-secondary">Download Report</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
    // Monthly Revenue Chart
    var options = {
        chart: { type: 'line', height: 250 },
        series: [{
            name: 'Revenue',
            data: @json($monthlyRevenue)
        }],
        xaxis: { categories: @json($months) }
    };
    new ApexCharts(document.querySelector("#revenueChart"), options).render();

    // Invoice Status Pie Chart
    var options2 = {
        chart: { type: 'pie', height: 250 },
        series: [{{ $paidInvoices }}, {{ $pendingInvoices }}, {{ $overdueInvoices }}],
        labels: ['Paid', 'Pending', 'Overdue'],
        colors: ['#28a745', '#ffc107', '#dc3545']
    };
    new ApexCharts(document.querySelector("#statusChart"), options2).render();
</script>
@endsection
