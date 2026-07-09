<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tax Invoice – Imagine | TRESOR</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    /* ==================== Theme variables default ==================== */
    :root{
      --bill2-border: #222222;
      --bill2-muted: #444444;
      --bill2-light: #f5f7fb;
      --bill2-text: #111111;
      --bill2-bg-sheet: #ffffff;
    }

    /* ==================== Base ==================== */
    body{ margin: 20px 200px; }
    #bill2 { font-family: "Poppins", system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, "Helvetica Neue", Arial, sans-serif; color: var(--bill2-text); background: var(--bill2-bg-sheet); }
    #bill2 .sheet { width: 280mm; min-height: 297mm; margin: 0 auto; padding: 0mm 12mm; background: var(--bill2-bg-sheet); }
    #bill2 .row { display: flex; gap: 0px; }
    #bill2 .col { flex: 1; }
    #bill2 .right { margin-left: auto; text-align: right; }
    #bill2 .center { text-align: center; }
    #bill2 .muted { color: var(--bill2-muted); }
    #bill2 .small, #bill2 .xs { font-size: 10px; }
    #bill2 .bold { font-weight: 600; }
    #bill2 .title { font-size: 20px; letter-spacing: 0.5px; }
    #bill2 .hbar { border-top: 2px solid var(--bill2-border); margin: 8px 0; }

    /* ==================== Header ==================== */
    #bill2 .header { display: grid; grid-template-columns: 1fr auto 1.2fr; align-items: start; gap: 0px; }
    #bill2 .brand { font-weight: 700; font-size: 26px; line-height: 1.1; }
    #bill2 .invoice-head { text-align: center; }
    #bill2 .invoice-head .title { font-weight: 700; }
    #bill2 .invoice-head .copy { font-size: 12px; text-decoration: underline; margin-top: 0px; }
    #bill2 .company { padding: 4px 12px; font-size: 14px; margin-left: auto; text-align: right; }

    /* ==================== Blocks ==================== */
    #bill2 .block { border: 1px solid var(--bill2-border); }
    #bill2 .block .head { background: var(--bill2-light); border-bottom: 1px solid var(--bill2-border); padding: 0px 10px; font-weight: 600; font-size: 13px; }
    #bill2 .block .body { padding: 5px; }
    #bill2 .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 0px; }
    #bill2 .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0px; }

    /* ==================== Definition rows ==================== */
    #bill2 .dl { display: grid; grid-template-columns: auto 1fr; gap: 0px 8px; font-size:11px; }
    #bill2 .dl .k { font-weight: 600; white-space: nowrap; }
    #bill2 .dl .v { font-weight: 400; }

    /* ==================== Meta ==================== */
    #bill2 .meta { border: 1px solid var(--bill2-border); display: grid; grid-template-columns: 1fr 120px; gap: 0; }
    #bill2 .meta .left { padding: 5px; }
    #bill2 .qr { border-left: none; display: flex; align-items: center; justify-content: center; }
    #bill2 .qr-box { width: 110px; height: 110px; border: 1px solid var(--bill2-border); display: flex; align-items: center; justify-content: center; font-size: 10px; }

    /* ==================== Lower section ==================== */
    #bill2 .lower { display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 5px; }

    /* ==================== Table ==================== */
    #bill2 table { width:100%; border-collapse:collapse; font-size:12px; margin-top:5px; }
    #bill2 th, #bill2 td { border: 1px solid var(--bill2-border); padding:3px 8px; text-align:center; }
    #bill2 th { background: var(--bill2-light); font-weight:600; }
    #bill2 td[colspan="13"] { text-align:right; font-weight:600; white-space:nowrap; min-width:300px; }
    #bill2 .footnote { font-size:10px; color: var(--bill2-muted); margin-top:10px; line-height:1.4; }
    #bill2 .sign { text-align:right; margin-top:-135px; font-size:12px; font-weight:500; }

    @media print {
      body { margin: 0 !important; padding: 0; background: #fff; }
      #bill2 .sheet { width: 210mm; min-height: 297mm; margin: 0 auto; padding: 10mm 12mm; page-break-after: always; box-shadow: none; border: none; background: var(--bill2-bg-sheet); }
      #bill2 table { page-break-inside: auto; }
      #bill2 tr { page-break-inside: avoid; page-break-after: auto; }
      #bill2 thead { display: table-header-group; }
      #bill2 tfoot { display: table-footer-group; }
      #bill2 .brand img { max-width: 120px; height: auto; }
      .no-print { display: none !important; }
      #bill2 { font-size: 11px; }
      #bill2 th, #bill2 td { padding: 4px 6px !important; }
    }

    /* ==================== Editor Panel ==================== */
    .theme-editor {
      position: fixed;
      top: 18px;
      right: 18px;
      background: #fff;
      border: 1px solid #ddd;
      padding: 10px;
      border-radius: 10px;
      display: flex;
      gap: 12px;
      align-items: center;
      z-index: 99999;
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
      font-size: 12px;
      line-height: 1;
    }
    .theme-group { display:flex; flex-direction:column; align-items:center; gap:6px; }
    .theme-editor .label { font-weight:600; font-size:11px; color:#222; }
    .theme-picker { width: 44px; height: 28px; border: none; background: transparent; cursor: pointer; padding:0; }
    .theme-btn { background: #111; color: #fff; border: none; padding: 7px 10px; border-radius: 8px; cursor: pointer; display: inline-flex; align-items:center; gap:8px; font-weight:600; font-size:13px; }
    .theme-btn svg { width:16px; height:16px; fill: #fff; }
    .theme-reset { background: transparent; border: 1px solid #ccc; padding: 6px 8px; border-radius: 8px; cursor: pointer; font-size:12px; }
    @media print { .theme-editor { display: none !important; } }
  </style>
</head>
<body>

  <!-- 🎨 Theme Editor -->
  <div class="theme-editor no-print" role="region" aria-label="Invoice theme editor">
    <div class="theme-group" title="Change sheet background">
      <div class="label">Sheet</div>
      <input type="color" class="theme-picker" data-var="--bill2-bg-sheet" value="#ffffff" aria-label="Sheet background color">
    </div>

    <div class="theme-group" title="Change header / block head background">
      <div class="label">Header</div>
      <input type="color" class="theme-picker" data-var="--bill2-light" value="#f5f7fb" aria-label="Header background color">
    </div>

    <div class="theme-group" title="Change muted text color">
      <div class="label">Muted</div>
      <input type="color" class="theme-picker" data-var="--bill2-muted" value="#444444" aria-label="Muted text color">
    </div>

    <div class="theme-group" title="Change border color">
      <div class="label">Border</div>
      <input type="color" class="theme-picker" data-var="--bill2-border" value="#222222" aria-label="Border color">
    </div>

    <div style="display:flex;flex-direction:column;gap:8px;align-items:center;">
      <button class="theme-btn" id="printBtn" title="Print / Download (uses current theme)">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9V2h12v7h4v8h-4v7H6v-7H2V9h4zm2 0h8V4H8v5zm0 11h8v-5H8v5z"/></svg>
        Download
      </button>
      <button class="theme-reset" id="resetBtn" title="Reset theme to defaults">Reset</button>
    </div>
  </div>

  <section id="bill2" class="sheet">
    <!-- Header -->
    <div class="header">
      <div class="brand">
        <img src="<?php echo e($businessProfile->user && $businessProfile->user->avatar
                   ? asset($businessProfile->user->avatar)
                   : asset('logo_resized_200x275.png')); ?>"
             alt="Company Logo" style="max-height:80px;" />
      </div>

      <div class="invoice-head">
        <div class="title"><?php echo e($businessProfile->business_name ?? 'Company Name'); ?></div>
        <div class="copy"><?php echo e($businessProfile->business_address ?? ''); ?></div>
      </div>

      <div class="company">
        <div><strong><?php echo e($businessProfile->business_address ?? ''); ?></strong></div>
        <div><?php echo e($businessProfile->city ?? ''); ?> <?php echo e($businessProfile->pincode ?? ''); ?></div>
        <div><?php echo e($businessProfile->website ?? ''); ?></div>
        <div>Call us: <?php echo e($businessProfile->phone_no_first ?? '-'); ?></div>
        <div>Email: <?php echo e($businessProfile->business_email ?? $businessProfile->email ?? '-'); ?></div>
      </div>
    </div>

    <!-- Lower section -->
    <div class="lower">
      <div>
        <div class="block">
          <div class="head">Details of Receiver (Billed to)</div>
          <div class="body dl">
            <div class="k">Contact No. :</div><div class="v"><?php echo e($invoice->billingDetail->phone ?? '-'); ?></div>
            <div class="k">Name :</div><div class="v"><?php echo e($invoice->billingDetail->name ?? '-'); ?></div>
            <div class="k">E-mail id :</div><div class="v"><?php echo e($invoice->billingDetail->email ?? '-'); ?></div>
            <div class="k">State Code :</div><div class="v"><?php echo e($invoice->billingDetail->state ?? '-'); ?></div>
            <div class="k">GST No. :</div><div class="v"><?php echo e($invoice->billingDetail->gst_number ?? '-'); ?></div>
            <div class="k">PAN No. :</div><div class="v"><?php echo e($invoice->billingDetail->pan_number ?? '-'); ?></div>
          </div>
        </div>

        <div class="block">
          <div class="head">Details of Consignee (Shipped to)</div>
          <div class="body dl">
            <div class="k">Contact No. :</div><div class="v"><?php echo e($invoice->shippingDetail->phone ?? '-'); ?></div>
            <div class="k">Name :</div><div class="v"><?php echo e($invoice->shippingDetail->name ?? '-'); ?></div>
            <div class="k">Delivery Address :</div><div class="v"><?php echo nl2br(e($invoice->shippingDetail->address ?? '-')); ?></div>
            <div class="k">E-mail id :</div><div class="v"><?php echo e($invoice->shippingDetail->email ?? '-'); ?></div>
          </div>
        </div>

        <div class="block">
          <div class="head">Customer Loyalty Details</div>
          <div class="body dl">
            <div class="k">Awarded Points:</div><div class="v"><?php echo e($invoice->loyalty_points ?? 0); ?></div>
            <div class="k">Customer's Wallet :</div><div class="v"><?php echo e($invoice->customer_wallet ?? 0); ?></div>
            <div class="k">Current Invoice Loyalty Expiry Date</div>
            <div class="v"><?php echo e(optional($invoice->loyalty_expiry_date)->format('d F Y') ?? '-'); ?></div>
          </div>
        </div>
      </div>

      <div>
        <div class="meta">
          <div class="left dl">
            <div class="k">Invoice No. :</div><div class="v">invoice#<?php echo e($invoice->invoice_number ?? $invoice->id); ?></div>
            <div class="k">Invoice Date :</div><div class="v"><?php echo e($invoice->created_at->format('d M Y') ?? '-'); ?></div>
            <div class="k">GST No. :</div><div class="v"><?php echo e($businessProfile->gst_no ?? '-'); ?></div>
            <div class="k">PAN No. :</div><div class="v"><?php echo e($businessProfile->pan_number ?? '-'); ?></div>
            <div class="k">CIN No. :</div><div class="v"><?php echo e($businessProfile->cin_number ?? ''); ?></div>
            <div class="k">E-mail id :</div><div class="v"><?php echo e($businessProfile->business_email ?? $businessProfile->email ?? '-'); ?></div>
            <div class="k">IRN No. :</div><div class="v">—</div>
          </div>
        </div>

        <div class="block">
          <div class="head">—</div>
          <div class="body dl">
            <div class="k">Salesperson Name :</div><div class="v"><?php echo e($invoice->user->sname ?? '-'); ?></div>
            <div class="k">Payment Mode :</div><div class="v"><?php echo e(ucfirst($invoice->payment_type ?? '-')); ?> - <?php echo e(number_format($invoice->amount_received ?? 0, 2)); ?></div>
            <div class="k">Buyer's PO No. :</div><div class="v"><?php echo e($invoice->po_number ?? '-'); ?></div>
            <div class="k">EMI Option :</div><div class="v"><?php echo e($invoice->emi_option ?? '-'); ?></div>
            <div class="k">Approval code :</div><div class="v"><?php echo e($invoice->approval_code ?? '-'); ?></div>
            <div class="k">Delivery Address :</div><div class="v"><?php echo nl2br(e($invoice->billingDetail->address ?? '-')); ?></div>
            <div class="k">Buy Back Amt + Service Code :</div><div class="v"><?php echo e($invoice->buyback_amount ?? 0); ?></div>
            <div class="k">Gift Voucher Awarded :</div><div class="v"><?php echo e($invoice->gift_voucher ?? '-'); ?></div>
            <div class="k">Reference :</div><div class="v"><?php echo e($invoice->reference ?? '-'); ?></div>
            <div class="k">BB serial no. :</div><div class="v"><?php echo e($invoice->bb_serial ?? '-'); ?></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Table of Items -->
    <table class="table table-bordered">
      <thead>
        <tr>
          <th rowspan="2">SKU CODE / DESCRIPTION / IMEI</th>
          <th rowspan="2">MRP</th>
          <th rowspan="2">DISC. %</th>
          <th rowspan="2">HSN/SAC CODE</th>
          <th rowspan="2">QTY</th>
          <th rowspan="2">TAXABLE AMOUNT</th>
          <th colspan="2">CGST</th>
          <th colspan="2">SGST/UTGST</th>
          <th colspan="2">IGST</th>
          <th rowspan="2">TOTAL</th>
        </tr>
        <tr>
          <th>Rate</th><th>Amt.</th>
          <th>Rate</th><th>Amt.</th>
          <th>Rate</th><th>Amt.</th>
        </tr>
      </thead>

      <tbody>
        <?php
          $grandTotal   = 0;
          $totalTaxable = 0;
          $totalCGST    = 0;
          $totalSGST    = 0;
          $totalIGST    = 0;
        ?>

        <?php $__currentLoopData = $invoice->gstDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $invoiceItem = $invoice->items->firstWhere('item_id', $gst->item_id);
            $pricing = DB::table('pricings')->where('item_id',$gst->item_id)->first();

            $total = $gst->total;
            $cgst  = $gst->cgst;
            $sgst  = $gst->sgst;
            $igst  = $gst->igst;
            $taxable = $gst->without_gst;

            if($invoice->discount_percent > 0) {
              $discountFactor = (100 - $invoice->discount_percent) / 100;
              $taxable = $taxable * $discountFactor;
              $cgst    = $cgst * $discountFactor;
              $sgst    = $sgst * $discountFactor;
              $igst    = $igst * $discountFactor;
              $total   = $total * $discountFactor;
            }

            if($invoiceItem) {
              if($invoiceItem->price_type === 'sales') {
                if(!empty($pricing) && $pricing->salesprice_tax == 1) {
                  $total   = $taxable;
                  $cgst = $sgst = $igst = 0;
                }
              } elseif($invoiceItem->price_type === 'purchase') {
                if(!empty($pricing) && $pricing->purches_price_tax == 1) {
                  $total   = $taxable;
                  $cgst = $sgst = $igst = 0;
                }
              }
            }

            $totalTaxable += $taxable;
            $totalCGST    += $cgst;
            $totalSGST    += $sgst;
            $totalIGST    += $igst;
            $grandTotal   += $total;
          ?>

          <tr>
            <td>
              <?php echo e($gst->item->sku ?? '-'); ?>

              <b><?php echo e($invoiceItem->item->item_name ?? '-'); ?> </b><br>
              <?php echo e($invoiceItem->item->details->item_description ?? '-'); ?>

            </td>
            <td><?php echo e(number_format($gst->price, 2)); ?></td>
            <td><?php echo e($invoice->discount_percent ?? 0); ?></td>
            <td><?php echo e($gst->item->hsn_sac ?? '-'); ?></td>
            <td><?php echo e($gst->quantity); ?></td>
            <td><?php echo e(number_format($taxable, 2)); ?></td>

            
            <td><?php echo e($cgst > 0 ? ($gst->gst_percent/2).'%' : '0%'); ?></td>
            <td><?php echo e(number_format($cgst,2)); ?></td>

            
            <td><?php echo e($sgst > 0 ? ($gst->gst_percent/2).'%' : '0%'); ?></td>
            <td><?php echo e(number_format($sgst,2)); ?></td>

            
            <td><?php echo e($igst > 0 ? ($gst->gst_percent).'%' : '0%'); ?></td>
            <td><?php echo e(number_format($igst,2)); ?></td>

            <td><?php echo e(number_format($total,2)); ?></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <tr class="bold">
          <td colspan="5" class="left">Grand Total</td>
          <td><?php echo e(number_format($totalTaxable,2)); ?></td>
          <td></td><td><?php echo e(number_format($totalCGST,2)); ?></td>
          <td></td><td><?php echo e(number_format($totalSGST,2)); ?></td>
          <td></td><td><?php echo e(number_format($totalIGST,2)); ?></td>
          <td><?php echo e(number_format($invoice->total_amount ?? $grandTotal,2)); ?></td>
        </tr>
      </tbody>
    </table>

    <!-- Terms -->
    <div class="footnote">
      <b>TERMS & CONDITIONS:</b><br>
      <?php echo nl2br(e($invoice->note ?? 'Standard terms apply.')); ?>

    </div>

    <!-- Signature -->
    <div class="sign">
      <?php echo e($businessProfile->business_name ?? 'Company Name'); ?><br>
      <img src="<?php echo e(asset($businessProfile->business_signature ?? '')); ?>" alt=""><br>
      Authorised Signatory
    </div>
  </section>


 <script>
(function () {
  const root = document.documentElement;
  const bill2 = document.getElementById('bill2');
  const pickers = document.querySelectorAll('.theme-picker');
  const printBtn = document.getElementById('printBtn');
  const resetBtn = document.getElementById('resetBtn');

  const DEFAULT_THEME = {
    '--bill2-bg-sheet': '#ffffff',
    '--bill2-light': '#f5f7fb',
    '--bill2-muted': '#444444',
    '--bill2-border': '#222222'
  };

  let saved = {};
  try { saved = JSON.parse(localStorage.getItem('invoiceTheme') || '{}') || {}; } catch(e) {}
  const theme = Object.assign({}, DEFAULT_THEME, saved);

  function applyThemeObject(obj) {
    Object.entries(obj).forEach(([cssVar, value]) => {
      if (!value) return;
      root.style.setProperty(cssVar, value);
      bill2 && bill2.style.setProperty(cssVar, value);
      const picker = document.querySelector(`.theme-picker[data-var="${cssVar}"]`);
      if (picker) picker.value = value;
    });
  }

  applyThemeObject(theme);

  pickers.forEach(picker => {
    picker.addEventListener('input', (e) => {
      const cssVar = picker.dataset.var;
      const color = e.target.value;
      root.style.setProperty(cssVar, color);
      bill2 && bill2.style.setProperty(cssVar, color);
      theme[cssVar] = color;
      try { localStorage.setItem('invoiceTheme', JSON.stringify(theme)); } catch (err) {}
    });
  });

  // ✅ Apply theme right before print
printBtn && printBtn.addEventListener('click', () => {
  Object.entries(theme).forEach(([cssVar, value]) => {
    root.style.setProperty(cssVar, value);
    bill2.style.setProperty(cssVar, value); // 🔑 ensure invoice section has variables too
  });
  setTimeout(() => window.print(), 100);
});


  resetBtn && resetBtn.addEventListener('click', () => {
    try { localStorage.removeItem('invoiceTheme'); } catch (e) {}
    applyThemeObject(DEFAULT_THEME);
    Object.keys(theme).forEach(k => theme[k] = DEFAULT_THEME[k]);
  });
})();
</script>


</body>
</html>
<?php /**PATH C:\new-invoice.acttconnect.com\new-invoice.acttconnect.com\resources\views/admin/invoices/bill2.blade.php ENDPATH**/ ?>