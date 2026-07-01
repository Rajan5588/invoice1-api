<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tax Invoice</title>
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
<body>
    @php
function numberToWordsIndian($number) {
    $no = floor($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five',
        6 => 'six', 7 => 'seven', 8 => 'eight',
        9 => 'nine', 10 => 'ten', 11 => 'eleven',
        12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen',
        15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen',
        18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty',
        30 => 'thirty', 40 => 'forty', 50 => 'fifty',
        60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred
                : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
        } else $str[] = null;
    }
    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ? "." . $words[$point / 10] . " " . $words[$point = $point % 10] : '';
    return ucwords(trim($result)) . " Rupees " . ($points ? $points . " Paise" : "") . " Only";
}
@endphp

  <div class="invoice-box">
    <div class="top-note">✍ Thank you for doing business with us</div>

    <!-- Company Info -->
    <div class="company-info">
      <h2>{{ $businessProfile->business_name ?? 'Company Name' }}</h2>
      <p>{{ $businessProfile->business_address ?? '' }}, 
         {{ $businessProfile->city ?? '' }} - {{ $businessProfile->pincode ?? '' }}</p>
      <p>GSTIN : {{ $businessProfile->gst_no ?? '-' }}
        <span class="state-code-box">State Code : {{ $businessProfile->state_code ?? '-' }}</span>
      </p>
      <p>Call: {{ $businessProfile->phone_no_first ?? '-' }} | Email: {{ $businessProfile->business_email ?? $businessProfile->email ?? '-' }}</p>
    </div>

    <div class="tax-title">
      TAX INVOICE
      <span class="note">Original For Recipient</span>
    </div>

    <!-- Invoice Details -->
    <div class="invoice-detail-section">
      <div class="left">
        <table>
          <tr>
            <td><strong>Invoice Number</strong></td>
            <td>: {{ $invoice->invoice_number ?? $invoice->id }}</td>
          </tr>
          <tr>
            <td><strong>Invoice Date</strong></td>
            <td>: {{ $invoice->created_at->format('d-m-Y') ?? '-' }}</td>
          </tr>
          <tr>
            <td><strong>State</strong></td>
            <td>: {{ $invoice->billingDetail->state ?? '-' }}</td>
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
            <td><strong>Salesperson</strong></td>
            <td style="text-align:right;">{{ $invoice->user->sname ?? '-' }}</td>
          </tr>
        </table>
      </div>
    </div>

    <!-- Address Section -->
    <div class="address-section">
      <div class="address-box">
        <div class="address-box-title">Details of Receiver | Billed to</div>
        <p><span class="bold">Name:</span> {{ $invoice->billingDetail->name ?? '-' }}</p>
        <p><span class="bold">Address:</span> {!! nl2br(e($invoice->billingDetail->address ?? '-')) !!}</p>
        <p><span class="bold">GSTIN:</span> {{ $invoice->billingDetail->gst_number ?? '-' }}
          <span class="state-code-box">State Code : {{ $invoice->billingDetail->state_code ?? '-' }}</span>
        </p>
        <p><span class="bold">State:</span> {{ $invoice->billingDetail->state ?? '-' }}</p>
      </div>

      <div class="address-box">
        <div class="address-box-title">Details of Consignee | Shipped to</div>
        <p><span class="bold">Name:</span> {{ $invoice->shippingDetail->name ?? '-' }}</p>
        <p><span class="bold">Address:</span> {!! nl2br(e($invoice->shippingDetail->address ?? '-')) !!}</p>
        <p><span class="bold">GSTIN:</span> {{ $invoice->shippingDetail->gst_number ?? '-' }}
          <span class="state-code-box">State Code : {{ $invoice->shippingDetail->state_code ?? '-' }}</span>
        </p>
        <p><span class="bold">State:</span> {{ $invoice->shippingDetail->state ?? '-' }}</p>
      </div>
    </div>

    <!-- Product Table -->
<table class="product-table">
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
    $sr=1;
    $grandTotal   = 0;
    $totalTaxable = 0;
    $totalIGST    = 0;
    $totalCGST    = 0;
    $totalSGST    = 0;
  @endphp

  @foreach($invoice->gstDetails as $gst)
    @php
      $invoiceItem = $invoice->items->firstWhere('item_id', $gst->item_id);
      $pricing = DB::table('pricings')->where('item_id',$gst->item_id)->first();

      $taxable = $gst->without_gst;
      $igst    = $gst->igst;
      $cgst    = $gst->cgst;
      $sgst    = $gst->sgst;
      $total   = $gst->total;

      // apply discount %
      if($invoice->discount_percent > 0) {
          $factor = (100 - $invoice->discount_percent) / 100;
          $taxable *= $factor;
          $igst    *= $factor;
          $cgst    *= $factor;
          $sgst    *= $factor;
          $total   *= $factor;
      }

      // tax-inclusive pricing check
      if($invoiceItem) {
          if($invoiceItem->price_type === 'sales' && !empty($pricing) && $pricing->salesprice_tax == 1) {
              $total   = $taxable;
              $igst=$cgst=$sgst=0;
          }
          if($invoiceItem->price_type === 'purchase' && !empty($pricing) && $pricing->purches_price_tax == 1) {
              $total   = $taxable;
              $igst=$cgst=$sgst=0;
          }
      }

      $totalTaxable += $taxable;
      $totalIGST    += $igst;
      $totalCGST    += $cgst;
      $totalSGST    += $sgst;
      $grandTotal   += $total;
    @endphp
    <tr>
      <td>{{ $sr++ }}</td>
      <td class="text-left">{{ $invoiceItem->item->item_name ?? '-' }}</td>
      <td>{{ $gst->quantity }}</td>
      <td>PCS</td>
      <td>{{ number_format($gst->price,2) }}</td>
      <td class="highlight">{{ number_format($taxable,2) }}</td>
      <td>{{ $igst > 0 ? $gst->gst_percent.'%' : '0%' }}</td>
      <td>{{ number_format($igst,2) }}</td>
      <td>₹ {{ number_format($total,2) }}</td>
    </tr>
  @endforeach

  <tr>
    <td colspan="2"><strong>Total</strong></td>
    <td>{{ $invoice->items->sum('quantity') }}</td>
    <td colspan="2"></td>
    <td class="highlight">₹ {{ number_format($totalTaxable,2) }}</td>
    <td></td>
    <td>₹ {{ number_format($totalIGST,2) }}</td>
    <td>₹ {{ number_format($grandTotal,2) }}</td>
  </tr>
</table>

<!-- Summary Table -->
<table class="summary-table">
  <tr>
    <td rowspan="6" style="width: 60%;">
      <strong>Total Invoice Amount in words</strong><br>
      <span style="font-weight: bold;">{{ numberToWordsIndian($grandTotal) }}</span>
    </td>
    <td class="label">Total Amount Before Tax</td>
    <td>₹ {{ number_format($totalTaxable,2) }}</td>
  </tr>
  <tr>
    <td class="label">Add : CGST</td>
    <td>₹ {{ number_format($totalCGST,2) }}</td>
  </tr>
  <tr>
    <td class="label">Add : SGST</td>
    <td>₹ {{ number_format($totalSGST,2) }}</td>
  </tr>
  <tr>
    <td class="label">Add : IGST</td>
    <td>₹ {{ number_format($totalIGST,2) }}</td>
  </tr>
  <tr>
    <td class="label">Total Tax Amount</td>
    <td>₹ {{ number_format($totalCGST+$totalSGST+$totalIGST,2) }}</td>
  </tr>
  <tr>
    <td class="label">Final Invoice Amount</td>
    <td>₹ {{ number_format($grandTotal,2) }}</td>
  </tr>
  <tr>
    <td class="label">Balance Due</td>
    <td>₹ {{ number_format($grandTotal - ($invoice->amount_received ?? 0),2) }}</td>
  </tr>
</table>


    <!-- Footer -->
    <div class="footer-sign">
      Certified that the particulars given above are true and correct<br>
      <strong>For, {{ $businessProfile->business_name ?? 'Company Name' }}</strong>
    </div>

    <div class="sign-box">
      <div><img src="{{ asset($businessProfile->business_signature ?? '') }}" alt=""></div>
      <div>Authorised Signatory</div>
    </div>

    <div class="thank-you">Thank you for your business</div>
  </div>
</body>
</html>
