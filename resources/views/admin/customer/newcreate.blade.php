@extends('layouts.master')

@section('title', 'Create Customer')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .form-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        box-shadow: 0 3px 12px rgba(0,0,0,0.05);
        padding: 2rem;
    }
    .form-section {
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f1f1f1;
        font-weight: 700;
        font-size: 1rem;
        color: #495057;
        display: flex; align-items: center; gap: .75rem;
    }
    .form-section .section-actions { margin-left: auto; }
    .required:after { content: " *"; color: #dc3545; }
    .btn { border-radius: 8px; padding: 0.55rem 1.2rem; }
    .mini-chip {
        display: inline-flex; align-items: center; gap: .4rem;
        background: #f8f9fa; border: 1px solid #e9ecef; padding: .35rem .6rem;
        border-radius: 999px; font-size: .85rem; color: #495057;
    }
    .mini-chip .bi { font-size: 1rem; }
    .invalid-feedback { display: block; }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="form-card">
            <h4 class="mb-4"><i class="bi bi-people me-2"></i> Create Customer</h4>

            <form action="{{ route('admin-customers.store', $company_slug) }}" method="POST" novalidate>
                @csrf

                {{-- ===== First (unnamed) section: GST No, GST Treatment, Company Name, Mobile ===== --}}
                <div class="form-section">
                    <i class="bi bi-card-checklist"></i> Initial Details
                    <div class="section-actions">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#billingAddressModal">
                            <i class="bi bi-geo-alt"></i> Add Billing Address
                        </button>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="form-label required">GST Number</label>
                        <input type="text" name="gst" maxlength="15"
                               class="form-control text-uppercase @error('gst') is-invalid @enderror"
                               value="{{ old('gst') }}" placeholder="27AAECS1234F1Z5">
                        @error('gst') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label required">GST Treatment</label>
                        <select name="gst_treatment" class="form-control select2 @error('gst_treatment') is-invalid @enderror">
                            <option value="">Select GST Treatment</option>
                            <option value="Registered Business" {{ old('gst_treatment')=='Registered Business'?'selected':'' }}>Registered Business</option>
                            <option value="Unregistered Business" {{ old('gst_treatment')=='Unregistered Business'?'selected':'' }}>Unregistered Business</option>
                            <option value="Consumer" {{ old('gst_treatment')=='Consumer'?'selected':'' }}>Consumer</option>
                            <option value="Overseas" {{ old('gst_treatment')=='Overseas'?'selected':'' }}>Overseas</option>
                            <option value="Special Economic Zone" {{ old('gst_treatment')=='Special Economic Zone'?'selected':'' }}>Special Economic Zone</option>
                            <option value="Deemed Export" {{ old('gst_treatment')=='Deemed Export'?'selected':'' }}>Deemed Export</option>
                        </select>
                        @error('gst_treatment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label required">Company Name</label>
                        <input type="text" name="company_name"
                               class="form-control @error('company_name') is-invalid @enderror"
                               value="{{ old('company_name') }}" placeholder="Acme Pvt Ltd">
                        @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label required">Mobile No</label>
                        <input type="text" name="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone') }}" placeholder="9876543210">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Billing address summary chip (after modal save) --}}
                    <div class="col-12" id="billingAddressSummary" style="display:none;">
                        <div class="mini-chip"><i class="bi bi-geo-alt"></i> <span class="text"></span></div>
                    </div>
                </div>

                {{-- Hidden fields to carry structured data from modals --}}
                <input type="hidden" name="billing_address[address]" id="billing_address_address" value="{{ old('billing_address.address') }}">
                <input type="hidden" name="billing_address[city]" id="billing_address_city" value="{{ old('billing_address.city') }}">
                <input type="hidden" name="billing_address[pincode]" id="billing_address_pincode" value="{{ old('billing_address.pincode') }}">
                <input type="hidden" name="billing_address[state]" id="billing_address_state" value="{{ old('billing_address.state') }}">
                <input type="hidden" name="billing_address[country]" id="billing_address_country" value="{{ old('billing_address.country','India') }}">

                <input type="hidden" name="payment_terms[days]" id="payment_terms_days" value="{{ old('payment_terms.days') }}">
                <input type="hidden" name="payment_terms[opening_balance]" id="payment_terms_opening_balance" value="{{ old('payment_terms.opening_balance') }}">
                <input type="hidden" name="payment_terms[balance_type]" id="payment_terms_balance_type" value="{{ old('payment_terms.balance_type') }}">
                <input type="hidden" name="payment_terms[email]" id="payment_terms_email" value="{{ old('payment_terms.email') }}">

                {{-- ===== Basic Details (Payment Terms etc.) ===== --}}
                <div class="form-section">
                    <i class="bi bi-sliders2"></i> Basic Details
                    <div class="section-actions">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#paymentTermsModal">
                            <i class="bi bi-wallet2"></i> Add Payment Terms
                        </button>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="form-label required">Customer Name</label>
                        <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                               value="{{ old('customer_name') }}" placeholder="John Doe">
                        @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="name@company.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <div id="paymentTermsSummary" style="display:none;">
                            <div class="mini-chip me-2">
                                <i class="bi bi-calendar2-week"></i> <span class="text"></span>
                            </div>
                            <div class="mini-chip">
                                <i class="bi bi-cash-coin"></i> <span class="money"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== Other Details ===== --}}
                <div class="form-section">
                    <i class="bi bi-info-circle"></i> Other Details
                </div>

                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="form-label required">Party Type</label>
                        <select name="party_type" class="form-control select2 @error('party_type') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="Buyer" {{ old('party_type')=='Buyer'?'selected':'' }}>Buyer</option>
                            <option value="Vendor" {{ old('party_type')=='Vendor'?'selected':'' }}>Vendor</option>
                            <option value="Both" {{ old('party_type')=='Both'?'selected':'' }}>Both</option>
                        </select>
                        @error('party_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label required">Tax Preference</label>
                        <select name="tax_preference" id="tax_preference" class="form-control select2 @error('tax_preference') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="Taxable" {{ old('tax_preference')=='Taxable'?'selected':'' }}>Taxable</option>
                            <option value="Tax Exempt" {{ old('tax_preference')=='Tax Exempt'?'selected':'' }}>Tax Exempt</option>
                        </select>
                        @error('tax_preference') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <div class="form-check mt-4 pt-2">
                            <input class="form-check-input" type="checkbox" value="1" id="tds_check" name="tds_enabled" {{ old('tds_enabled')?'checked':'' }}>
                            <label class="form-check-label" for="tds_check">
                                Apply TDS
                            </label>
                        </div>
                        <select name="tds_rate" id="tds_rate" class="form-control mt-2 select2" style="display:none;">
                            <option value="">Select TDS Rate</option>
                            <option value="0.10" {{ old('tds_rate')=='0.10'?'selected':'' }}>10%</option>
                            <option value="0.05" {{ old('tds_rate')=='0.05'?'selected':'' }}>5%</option>
                            <option value="0.01" {{ old('tds_rate')=='0.01'?'selected':'' }}>1%</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <div class="form-check mt-4 pt-2">
                            <input class="form-check-input" type="checkbox" value="1" id="tcs_check" name="tcs_enabled" {{ old('tcs_enabled')?'checked':'' }}>
                            <label class="form-check-label" for="tcs_check">
                                Apply TCS
                            </label>
                        </div>
                        <select name="tcs_rate" id="tcs_rate" class="form-control mt-2 select2" style="display:none;">
                            <option value="">Select TCS Rate</option>
                            <option value="0.10" {{ old('tcs_rate')=='0.10'?'selected':'' }}>10%</option>
                            <option value="0.075" {{ old('tcs_rate')=='0.075'?'selected':'' }}>7.5%</option>
                            <option value="0.01" {{ old('tcs_rate')=='0.01'?'selected':'' }}>1%</option>
                        </select>
                    </div>
                </div>

                {{-- ===== Assign User ===== --}}
                <div class="form-section">
                    <i class="bi bi-person-check"></i> Assign User
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label required">Select User</label>
                        <select name="user_id" class="form-control select2 @error('user_id') is-invalid @enderror">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id')==$user->id?'selected':'' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- ===== Submit ===== --}}
                <div class="text-end mt-4">
                    <a href="{{ route('admin-customers.index', $company_slug) }}" class="btn btn-light border">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===================== BILLING ADDRESS MODAL ===================== --}}
<div class="modal fade" id="billingAddressModal" tabindex="-1" aria-labelledby="billingAddressModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="billingAddressModalLabel"><i class="bi bi-geo-alt"></i> Billing Address</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label required">Address</label>
                <textarea class="form-control" id="ba_address" rows="2" placeholder="Street, Area">{{ old('billing_address.address') }}</textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label required">City</label>
                <input type="text" class="form-control" id="ba_city" value="{{ old('billing_address.city') }}" placeholder="Mumbai">
            </div>
            <div class="col-md-4">
                <label class="form-label required">Pincode</label>
                <input type="text" class="form-control" id="ba_pincode" value="{{ old('billing_address.pincode') }}" placeholder="400001" maxlength="6">
            </div>
            <div class="col-md-4">
                <label class="form-label required">State</label>
                <select id="ba_state" class="form-control select2" style="width:100%;">
                    <option value="">Select State</option>
                    @php
                    $states = ['Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Delhi','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal'];
                    @endphp
                    @foreach($states as $s)
                        <option value="{{ $s }}" {{ old('billing_address.state')==$s?'selected':'' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label required">Country</label>
                <select id="ba_country" class="form-control select2" style="width:100%;">
                    <option value="India" selected>India</option>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="saveBillingAddressBtn"><i class="bi bi-check2-circle"></i> Save Address</button>
      </div>
    </div>
  </div>
</div>

{{-- ===================== PAYMENT TERMS MODAL ===================== --}}
<div class="modal fade" id="paymentTermsModal" tabindex="-1" aria-labelledby="paymentTermsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentTermsModalLabel"><i class="bi bi-wallet2"></i> Payment Terms</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label required">Term</label>
                <select id="pt_days" class="form-control select2" style="width:100%;">
                    <option value="">Select</option>
                    <option value="15" {{ old('payment_terms.days')=='15'?'selected':'' }}>15 Days</option>
                    <option value="30" {{ old('payment_terms.days')=='30'?'selected':'' }}>30 Days</option>
                    <option value="45" {{ old('payment_terms.days')=='45'?'selected':'' }}>45 Days</option>
                </select>
                <button type="button" id="openCustomTerm" class="btn btn-link p-0 mt-1">+ Add custom term</button>
            </div>

            <div class="col-md-4">
                <label class="form-label required">Opening Balance</label>
                <input type="number" min="0" step="0.01" id="pt_opening_balance" class="form-control"
                       value="{{ old('payment_terms.opening_balance') }}" placeholder="0.00">
            </div>

            <div class="col-md-4">
                <label class="form-label required d-block">Balance Type</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pt_balance_type" id="pt_receive" value="to_receive" {{ old('payment_terms.balance_type','to_receive')=='to_receive'?'checked':'' }}>
                    <label class="form-check-label" for="pt_receive">To Receive</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pt_balance_type" id="pt_pay" value="to_pay" {{ old('payment_terms.balance_type')=='to_pay'?'checked':'' }}>
                    <label class="form-check-label" for="pt_pay">To Pay</label>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email for Statements</label>
                <input type="email" id="pt_email" class="form-control" value="{{ old('payment_terms.email') }}" placeholder="accounts@company.com">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="savePaymentTermsBtn"><i class="bi bi-check2-circle"></i> Save Terms</button>
      </div>
    </div>
  </div>
</div>

{{-- ===================== CUSTOM TERM MINI MODAL ===================== --}}
<div class="modal fade" id="customTermModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title">Custom Term (Days)</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3">
        <input type="number" min="1" id="custom_term_days" class="form-control" placeholder="e.g., 60">
      </div>
      <div class="modal-footer py-2">
        <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="addCustomTermBtn">Add</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
(function() {
    const $doc = $(document);

    // Init select2
    function initSelect2() {
        $('.select2').select2({ width: '100%' });
        // Ensure modals show their own dropdowns correctly
        $('#billingAddressModal .select2').select2({ width: '100%', dropdownParent: $('#billingAddressModal') });
        $('#paymentTermsModal .select2').select2({ width: '100%', dropdownParent: $('#paymentTermsModal') });
        $('#customTermModal .select2').select2({ width: '100%', dropdownParent: $('#customTermModal') });
    }
    initSelect2();

    // Uppercase GST on input
    $doc.on('input', 'input[name="gst"]', function() {
        this.value = this.value.toUpperCase().replace(/\s+/g,'').slice(0,15);
    });

    // Phone: digits only
    $doc.on('input', 'input[name="phone"]', function() {
        this.value = this.value.replace(/[^0-9]/g,'').slice(0,15);
    });

    // TDS/TCS dropdown toggle
    function toggleTaxDropdowns() {
        $('#tds_rate').toggle( $('#tds_check').is(':checked') );
        $('#tcs_rate').toggle( $('#tcs_check').is(':checked') );
    }
    toggleTaxDropdowns();
    $doc.on('change', '#tds_check,#tcs_check', toggleTaxDropdowns);

    // ===== Billing Address Modal Save =====
    $('#saveBillingAddressBtn').on('click', function() {
        const addr = $('#ba_address').val().trim();
        const city = $('#ba_city').val().trim();
        const pin  = $('#ba_pincode').val().trim();
        const state = $('#ba_state').val();
        const country = $('#ba_country').val();

        // simple front-end validation
        if(!addr || !city || !pin || pin.length < 6 || !state || !country) {
            alert('Please fill Address, City, 6-digit Pincode, State and Country.');
            return;
        }

        // Set hidden inputs
        $('#billing_address_address').val(addr);
        $('#billing_address_city').val(city);
        $('#billing_address_pincode').val(pin);
        $('#billing_address_state').val(state);
        $('#billing_address_country').val(country);

        // Show summary chip
        const summary = `${addr}, ${city} ${pin}, ${state}, ${country}`;
        $('#billingAddressSummary .text').text(summary);
        $('#billingAddressSummary').show();

        // close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('billingAddressModal'));
        modal.hide();
    });

    // ===== Payment Terms: open custom term modal =====
    $('#openCustomTerm').on('click', function() {
        $('#customTermModal').modal('show');
        setTimeout(()=>$('#custom_term_days').trigger('focus'), 150);
    });

    // Add custom term to select and choose it
    $('#addCustomTermBtn').on('click', function() {
        const days = parseInt($('#custom_term_days').val(), 10);
        if (!days || days < 1) {
            alert('Enter a valid number of days.');
            return;
        }
        // append and select
        const $sel = $('#pt_days');
        if ($sel.find('option[value="'+days+'"]').length === 0) {
            $sel.append(`<option value="${days}">${days} Days</option>`);
        }
        $sel.val(String(days)).trigger('change');

        const modal = bootstrap.Modal.getInstance(document.getElementById('customTermModal'));
        modal.hide();
    });

    // ===== Payment Terms Modal Save =====
    $('#savePaymentTermsBtn').on('click', function() {
        const days = $('#pt_days').val();
        const opening = $('#pt_opening_balance').val();
        const balanceType = $('input[name="pt_balance_type"]:checked').val() || 'to_receive';
        const email = $('#pt_email').val().trim();

        if(!days) { alert('Please select a payment term.'); return; }
        if(opening === '' || Number(opening) < 0) { alert('Opening balance must be 0 or more.'); return; }
        if(email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { alert('Enter a valid email.'); return; }

        // Set hidden inputs
        $('#payment_terms_days').val(days);
        $('#payment_terms_opening_balance').val(opening);
        $('#payment_terms_balance_type').val(balanceType);
        $('#payment_terms_email').val(email);

        // Show summary chips
        const termText = `${days} Day${Number(days) > 1 ? 's' : ''}`;
        const moneyText = `${balanceType === 'to_receive' ? 'To Receive' : 'To Pay'} • ₹ ${Number(opening).toFixed(2)}${email ? ' • ' + email : ''}`;

        $('#paymentTermsSummary .text').text(termText);
        $('#paymentTermsSummary .money').text(moneyText);
        $('#paymentTermsSummary').show();

        const modal = bootstrap.Modal.getInstance(document.getElementById('paymentTermsModal'));
        modal.hide();
    });
})();
</script>
@endsection
