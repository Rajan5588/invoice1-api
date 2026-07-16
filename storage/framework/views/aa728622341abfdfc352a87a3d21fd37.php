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
<body>
  <div class="invoice-box">
    <div class="top-note">✍ Thank you for doing business with us</div>

    <div class="company-info">
     <?php if(!$setting || $setting->print_company_name): ?>
<h2><?php echo e($invoice->user->businessProfile->business_name ?? ''); ?></h2>
<?php endif; ?>

<?php if(!$setting || $setting->print_address): ?>
<p><?php echo e($invoice->user->businessProfile->business_address ?? ''); ?></p>
<?php endif; ?>

<?php if(!$setting || $setting->print_gstin): ?>
<p>
    GSTIN : <?php echo e($invoice->user->businessProfile->gst_no ?? ''); ?>

</p>
<?php endif; ?>

<?php if(!$setting || $setting->print_phone): ?>
<p>Phone : <?php echo e($invoice->user->businessProfile->phone_no_first ?? ''); ?></p>
<?php endif; ?>

<?php if(!$setting || $setting->print_email): ?>
<p>Email : <?php echo e($invoice->user->businessProfile->business_email ?? ''); ?></p>
<?php endif; ?>
    </div>

    <div class="tax-title">
      TAX INVOICE
      <span class="note">Original For Recipient</span>
    </div>

    <div class="invoice-detail-section">
      <div class="left">
        <table>
          <tr>
            <td><strong>Invoice Number</strong></td>
            <td>: <?php echo e($invoice->id); ?></td>
          </tr>
          <tr>
            <td><strong>Invoice Date</strong></td>
          <td>: <?php echo e(date('d-m-Y',strtotime($invoice->created_at))); ?></td>
          </tr>
          <tr>
            <td><strong>State</strong></td>
          <td>: <?php echo e($invoice->user->businessProfile->business_state ?? ''); ?></td>
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
            <td><strong>Customer Name</strong></td>
            <td>: <?php echo e($invoice->customer_name); ?></td>
        </tr>
        <tr>
            <td><strong>Phone</strong></td>
            <td>: <?php echo e($invoice->customer_number); ?></td>
        </tr>
        <tr>
            <td><strong>Payment Type</strong></td>
            <td>: <?php echo e(ucfirst($invoice->payment_type)); ?></td>
        </tr>
        <tr>
            <td><strong>Company Code</strong></td>
            <td>: <?php echo e($invoice->company_code ?? '-'); ?></td>
        </tr>
    </table>
</div>
</div>
  

    <div class="address-section">
      <div class="address-box">
        <div class="address-box-title">Details of Receiver | Billed to</div>
<p><span class="bold">Name:</span> <?php echo e($invoice->customer_name); ?></p>
<p><span class="bold">Address:</span> <?php echo e($invoice->billingDetail->billing_address ?? ''); ?></p>
<p><?php echo e($invoice->billingDetail->billing_state ?? ''); ?></p>
    <p><span class="bold">GSTIN:</span> <?php echo e($invoice->billingDetail->gstin ?? ''); ?></p>
        <p><span class="bold">State:</span> <?php echo e($invoice->billingDetail->billing_state ?? ''); ?></p>
      </div>

      <div class="address-box">
        <div class="address-box-title">Details of Consignee | Shipped to</div>
<p><span class="bold">Name:</span> <?php echo e($invoice->shippingDetail->name ?? ''); ?></p>
<p><span class="bold">Address:</span> <?php echo e($invoice->shippingDetail->shipping_address ?? ''); ?></p>
 <p><?php echo e($invoice->shippingDetail->shipping_state ?? ''); ?></p>
    <p><span class="bold">GSTIN:</span> <?php echo e($invoice->shippingDetail->gstin ?? ''); ?></p>
   <p><span class="bold">State:</span> <?php echo e($invoice->shippingDetail->shipping_state ?? ''); ?></p>
      </div>
    </div>

    <!-- Product Table Start -->
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
     <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($key+1); ?></td>
    <td class="text-left"><?php echo e($item->item->item_name ?? ''); ?></td>
    <td><?php echo e($item->quantity); ?></td>
    <td>PCS</td>
    <td><?php echo e($item->price); ?></td>
    <td><?php echo e($item->total); ?></td>
    <td>0%</td>
    <td>0</td>
    <td><?php echo e($item->total); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     <tr>
    <td colspan="2"><strong>Total</strong></td>
    <td><?php echo e($invoice->items->sum('quantity')); ?></td>
    <td colspan="2"></td>
    <td class="highlight">₹ <?php echo e(number_format($invoice->total_amount,2)); ?></td>
    <td>-</td>
    <td>-</td>
    <td>₹ <?php echo e(number_format($invoice->total_amount,2)); ?></td>
</tr>
    </table>

    <!-- Summary Table -->
<table class="summary-table">

<tr>
<td rowspan="6" style="width:60%;">
<strong>Total Invoice Amount in words</strong><br>

<span style="font-weight:bold;">
<?php echo e(ucwords(\NumberFormatter::create('en_IN', \NumberFormatter::SPELLOUT)->format($invoice->total_amount))); ?>

Only
</span>

</td>

<td class="label">Sub Total</td>
<td>₹ <?php echo e(number_format($invoice->total_amount + $invoice->discount_amount - $invoice->round_off,2)); ?></td>
</tr>

<tr>
<td class="label">Discount</td>
<td>₹ <?php echo e(number_format($invoice->discount_amount,2)); ?></td>
</tr>

<tr>
<td class="label">Round Off</td>
<td>₹ <?php echo e(number_format($invoice->round_off,2)); ?></td>
</tr>

<tr>
<td class="label">Grand Total</td>
<td>₹ <?php echo e(number_format($invoice->total_amount,2)); ?></td>
</tr>

<tr>
<td class="label">Amount Received</td>
<td>₹ <?php echo e(number_format($invoice->amount_received,2)); ?></td>
</tr>

<tr>
<td class="label">Balance Due</td>
<td>₹ <?php echo e(number_format($invoice->total_amount-$invoice->amount_received,2)); ?></td>
</tr>

</table>

    <!-- Footer -->
    <div class="footer-sign">
      Certified that the particular given above are true and correct<br>
   <strong>For, <?php echo e($invoice->user->businessProfile->business_name ?? ''); ?></strong>
    </div>

    <div class="sign-box">

<?php if(!$setting || $setting->print_signature): ?>

<?php if($invoice->user->businessProfile && $invoice->user->businessProfile->digital_sign): ?>

<img src="<?php echo e(asset($invoice->user->businessProfile->digital_sign)); ?>" width="120">

<?php endif; ?>

<div><?php echo e($setting->signature_text ?? 'Authorised Signatory'); ?></div>

<?php endif; ?>

</div>

    <div class="thank-you">Thankyou for your business</div>
  </div>
</body>
</html>
<?php /**PATH C:\new-invoice.acttconnect.com\new-invoice.acttconnect.com\resources\views/BillTemplates/bill1.blade.php ENDPATH**/ ?>