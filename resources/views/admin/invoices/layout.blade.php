
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tax Invoice Header - Enhanced</title>
  <style>
    * {
      box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      margin: 0;
      padding: 0;
      background: #fff;
      font-size: 13px;
    }

    .invoice-box {
      border: 1px solid #000;
      max-width: 1000px;
      margin: 20px auto;
      background: #fdfdfd;
    }

    .top-note {
      text-align: center;
      font-size: 12px;
      padding: 8px;
      border-bottom: 1px solid #000;
      font-style: italic;
      background-color: #f1f1f1;
    }

    .company-info {
      text-align: center;
      padding: 12px 10px 8px;
      line-height: 1.5;
    }

    .company-info h2 {
      margin: 0;
      font-size: 18px;
      font-weight: bold;
      letter-spacing: 0.5px;
    }

    .company-info p {
      margin: 2px 0;
      font-size: 13px;
    }

    .state-code-box {
      display: inline-block;
      border: 1px solid #000;
      padding: 2px 6px;
      font-size: 12px;
      margin-left: 6px;
      background-color: #e6f0ff;
    }

    .tax-title {
      background-color: #cce6ff;
      text-align: center;
      font-weight: bold;
      padding: 8px;
      font-size: 15px;
      border-top: 1px solid #000;
      border-bottom: 1px solid #000;
      position: relative;
      letter-spacing: 1px;
    }

    .tax-title .note {
      position: absolute;
      right: 12px;
      font-style: italic;
      font-weight: normal;
      font-size: 11px;
      color: #333;
    }

    .invoice-detail-section {
      display: flex;
      justify-content: space-between;
      padding: 12px 15px;
      border-bottom: 1px solid #000;
      position: relative;
    }

    .invoice-detail-section::before {
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;
      left: 50%;
      width: 1px;
      background-color: #000;
      z-index: 1;
    }

    .invoice-detail-section .left,
    .invoice-detail-section .right {
      width: 48%;
      position: relative;
      z-index: 2;
    }

    .invoice-detail-section table {
      width: 100%;
      border-collapse: collapse;
    }

    .invoice-detail-section td {
      padding: 5px 0;
      vertical-align: top;
      font-size: 13px;
    }

    .invoice-detail-section td strong {
      font-weight: bold;
    }

    .address-section {
      display: flex;
      border-top: 1px solid #000;
      position: relative;
    }

    .address-section::before {
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;
      left: 50%;
      width: 1px;
      background-color: #000;
      z-index: 1;
    }

    .address-box {
      width: 50%;
      padding: 0 15px 12px;
      border-right: 1px solid #000;
      position: relative;
      z-index: 2;
    }

    .address-box:last-child {
      border-right: none;
    }

    .address-box-title {
      background-color: #cce6ff;
      font-weight: bold;
      padding: 6px 10px;
      margin: 0 -15px 10px -15px;
      border-bottom: 1px solid #000;
      font-size: 13.5px;
      letter-spacing: 0.5px;
      text-align: center;
    }

    .address-box p {
      margin: 4px 0;
      font-size: 13px;
      line-height: 1.4;
    }

    .bold {
      font-weight: bold;
    }

    /* ===== Product Table Section ===== */
    .product-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 5px;
    }

    .product-table th,
    .product-table td {
      border: 1px solid #000;
      padding: 6px 5px;
      text-align: center;
      font-size: 13px;
    }

    .product-table th {
      background-color: #cce6ff;
      font-weight: bold;
    }

    .highlight {
      background-color: #e6f4ff;
    }

    .text-left {
      text-align: left;
    }

    .summary-table {
      width: 100%;
      border-collapse: collapse;

    }

    .summary-table td {
      border: 1px solid #000;
      padding: 6px 8px;
      font-size: 13px;
    }

    .summary-table .label {
      font-weight: bold;
      background-color: #f2f8ff;
    }

    .footer-sign {
      text-align: center;
      padding: 30px 20px 10px;
      font-size: 13px;
    }

    .sign-box {
      text-align: center;
      margin-top: 20px;
      font-size: 13px;
    }

    .sign-box img {
      height: 40px;
      margin-bottom: 5px;
    }

    .thank-you {
      font-style: italic;
      font-size: 12px;
      text-align: center;
      margin: 10px;
    }

  </style>
</head>
<body><div class="invoice-box" id="invoiceBox">

    <!-- Top Note -->
    <div class="top-note">✍ Thank you for doing business with us</div>

    <!-- Company Info -->
    <div class="company-info">
        <h2>{{ $company->name ?? 'Company Name' }}</h2>
        <p>{{ $company->full_address ?? 'Company Address' }}</p>
        <p>
            GSTIN: {{ $company->gst ?? '-' }}
            <span class="state-code-box">State Code: {{ $company->state_code ?? '-' }}</span>
        </p>
    </div>

    <!-- Tax Title -->
    <div class="tax-title" id="taxTitle">
        TAX INVOICE
        <span class="note">Original For Recipient</span>
    </div>

    <!-- Invoice Details -->
    <div class="invoice-detail-section">
        <div class="left">
            <table>
                <tr>
                    <td><strong>Invoice Number</strong></td>
                    <td>: {{ $invoice->id }}</td>
                </tr>
                <tr>
                    <td><strong>Invoice Date</strong></td>
                    <td>: {{ \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td><strong>State</strong></td>
                    <td>: {{ $invoice->customer->state ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Reverse Charge</strong></td>
                    <td>: NO</td>
                </tr>
            </table>
        </div>
        <div class="right">
            <table>
                <tr>
                    <td>{{ $invoice->customer->company_name ?? $invoice->customer_name }}</td>
                    <td style="text-align:right;">{{ $invoice->customer->phone ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Customer Details -->
    <div class="address-section">
        <div class="address-box" id="billingTitle">
            <div class="address-box-title">Details of Receiver | Billed to</div>
            <p><span class="bold">Name:</span> {{ $invoice->customer_name ?? $invoice->customer->customer_name }}</p>
            <p><span class="bold">Address:</span> {{ $invoice->customer->place_of_supply ?? '-' }}</p>
            <p><span class="bold">GSTIN:</span> {{ $invoice->customer->gst ?? '-' }}
                <span class="state-code-box">State Code: {{ $invoice->customer->state ?? '-' }}</span>
            </p>
            <p><span class="bold">State:</span> {{ $invoice->customer->state ?? '-' }}</p>
        </div>
        <div class="address-box" id="shippingTitle">
            <div class="address-box-title">Details of Consignee | Shipped to</div>
            <p><span class="bold">Name:</span> {{ $invoice->customer_name ?? $invoice->customer->customer_name }}</p>
            <p><span class="bold">Address:</span> {{ $invoice->customer->place_of_supply ?? '-' }}</p>
            <p><span class="bold">GSTIN:</span> {{ $invoice->customer->gst ?? '-' }}
                <span class="state-code-box">State Code: {{ $invoice->customer->state ?? '-' }}</span>
            </p>
            <p><span class="bold">State:</span> {{ $invoice->customer->state ?? '-' }}</p>
        </div>
    </div>

    <!-- Product Table -->
    <table class="product-table" id="productTable">
        <tr>
            <th>Sr. No.</th>
            <th class="text-left">Name of Product</th>
            <th>QTY</th>
            <th>Unit</th>
            <th>Rate</th>
            <th class="highlight">Taxable Value</th>
            <th colspan="2">IGST</th>
            <th>Total</th>
        </tr>

        @php 
            $totalQty = 0; 
            $totalAmount = 0; 
            $totalTax = 0; 
        @endphp

        @foreach($invoice->items as $key => $item)
            @php
                $tax = ($item->price * 18)/100;
                $total = $item->price + $tax;
                $totalQty += $item->quantity;
                $totalAmount += $item->price;
                $totalTax += $tax;
            @endphp
            <tr @if($loop->first) class="highlight" @endif>
                <td>{{ $key + 1 }}</td>
                <td class="text-left">{{ $item->item->item_name ?? 'Item '.$item->item_id }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->item->unit ?? '-' }}</td>
                <td>{{ number_format($item->price,2) }}</td>
                <td class="highlight">{{ number_format($item->price,2) }}</td>
                <td>18%</td>
                <td>{{ number_format($tax,2) }}</td>
                <td>₹ {{ number_format($total,2) }}</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="2"><strong>Total</strong></td>
            <td>{{ $totalQty }}</td>
            <td colspan="2"></td>
            <td class="highlight">₹ {{ number_format($totalAmount,2) }}</td>
            <td></td>
            <td>₹ {{ number_format($totalTax,2) }}</td>
            <td>₹ {{ number_format($totalAmount + $totalTax,2) }}</td>
        </tr>
    </table>

    <!-- Summary Table -->
    <table class="summary-table">
        <tr>
            <td rowspan="5" style="width: 60%;">
                <strong>Total Invoice Amount in words</strong><br>
                <span style="font-weight: bold;">{{ \NumberFormatter::create('en', \NumberFormatter::SPELLOUT)->format($totalAmount + $totalTax) }} Rupees Only /-</span>
            </td>
            <td class="label">Total Amount Before Tax</td>
            <td>₹ {{ number_format($totalAmount,2) }}</td>
        </tr>
        <tr>
            <td class="label">Add : IGST</td>
            <td>₹ {{ number_format($totalTax,2) }}</td>
        </tr>
        <tr>
            <td class="label">Total Tax Amount</td>
            <td>₹ {{ number_format($totalTax,2) }}</td>
        </tr>
        <tr>
            <td class="label">Final Invoice Amount</td>
            <td>₹ {{ number_format($totalAmount + $totalTax,2) }}</td>
        </tr>
        <tr>
            <td class="label">Balance Due</td>
            <td>₹ {{ number_format($invoice->total_amount,2) }}</td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer-sign">
        Certified that the particulars given above are true and correct<br>
        <strong>For, {{ $company->name ?? 'Company Name' }}</strong>
    </div>

    <div class="sign-box">
        <div>✍</div>
        <div>Authorised Signatory</div>
    </div>

    <div class="thank-you">Thank you for your business</div>
</div>
</body>
</html>
