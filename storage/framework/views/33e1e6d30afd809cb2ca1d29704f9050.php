

<?php $__env->startSection('title'); ?> Edit Invoice <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
$states = [
    '01'=>'Jammu & Kashmir','02'=>'Himachal Pradesh','03'=>'Punjab','04'=>'Chandigarh',
    '05'=>'Uttarakhand','06'=>'Haryana','07'=>'Delhi','08'=>'Rajasthan','09'=>'Uttar Pradesh',
    '10'=>'Bihar','11'=>'Sikkim','12'=>'Arunachal Pradesh','13'=>'Nagaland','14'=>'Manipur',
    '15'=>'Mizoram','16'=>'Tripura','17'=>'Meghalaya','18'=>'Assam','19'=>'West Bengal',
    '20'=>'Jharkhand','21'=>'Odisha','22'=>'Chhattisgarh','23'=>'Madhya Pradesh','24'=>'Gujarat',
    '25'=>'Daman & Diu','26'=>'Dadra & Nagar Haveli','27'=>'Maharashtra','28'=>'Andhra Pradesh',
    '29'=>'Karnataka','30'=>'Goa','31'=>'Lakshadweep','32'=>'Kerala','33'=>'Tamil Nadu',
    '34'=>'Puducherry','35'=>'Andaman & Nicobar Islands','36'=>'Telangana','37'=>'Andhra Pradesh (New)'
];
?>

<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Invoices <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Edit Invoice <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><h6>Edit GST Invoice #<?php echo e($invoice->id); ?></h6></div>
            <div class="card-body">
                <form id="editInvoiceForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="user_id" value="<?php echo e(old('user_id', $invoice->user_id)); ?>">

                    <!-- Receiver Details -->
                    <h6>Receiver (Billed To)</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label>Name</label>
                            <input type="text" name="receiver_name" class="form-control" required
                                   value="<?php echo e(old('receiver_name', $invoice->billingDetail->name ?? '')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Contact No.</label>
                            <input type="text" name="receiver_phone" class="form-control"
                                   value="<?php echo e(old('receiver_phone', $invoice->billingDetail->phone ?? '')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Email</label>
                            <input type="email" name="receiver_email" class="form-control"
                                   value="<?php echo e(old('receiver_email', $invoice->billingDetail->email ?? '')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label>State</label>
                            <select name="receiver_state_code" class="form-control state-change" required>
                                <option value="">-- Select State --</option>
                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($code); ?>" <?php echo e((old('receiver_state_code', $invoice->billingDetail->state ?? '') == $code) ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <!-- Consignee -->
                    <h6>Consignee (Shipped To)</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label>Select Customer</label>
                            <select id="consigneeCustomer" class="form-control">
                                <option value="">-- Select Customer --</option>
                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($customer->id); ?>" 
                                    data-name="<?php echo e($customer->customer_name); ?>"
                                    data-phone="<?php echo e($customer->phone); ?>"
                                    data-email="<?php echo e($customer->email); ?>"
                                    data-state="<?php echo e($customer->state); ?>"
                                    data-address="<?php echo e($customer->place_of_supply); ?>"
                                    <?php echo e($invoice->customer_id==$customer->id?'selected':''); ?>>
                                    <?php echo e($customer->customer_name); ?> (<?php echo e($customer->company_name ?? ''); ?>)
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Payment Type</label>
                            <select name="payment_type" class="form-control" required>
                                <?php
                                    $paymentTypes = ['cash','credit_card','debit_card','upi','net_banking','wallet','cheque','bank_transfer','other'];
                                ?>
                                <?php $__currentLoopData = $paymentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type); ?>" <?php echo e((old('payment_type',$invoice->payment_type)==$type)?'selected':''); ?>><?php echo e(ucfirst(str_replace('_',' ',$type))); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3"><label>Name</label>
                            <input type="text" name="consignee_name" id="consignee_name" class="form-control" required value="<?php echo e(old('consignee_name', $invoice->shippingDetail->name ?? '')); ?>">
                        </div>
                        <div class="col-md-3"><label>Contact</label>
                            <input type="text" name="consignee_phone" id="consignee_phone" class="form-control" value="<?php echo e(old('consignee_phone', $invoice->shippingDetail->phone ?? '')); ?>">
                        </div>
                        <div class="col-md-3"><label>Email</label>
                            <input type="email" name="consignee_email" id="consignee_email" class="form-control" value="<?php echo e(old('consignee_email', $invoice->shippingDetail->email ?? '')); ?>">
                        </div>
                        <div class="col-md-3"><label>State</label>
                            <select name="consignee_state_code" id="consignee_state_code" class="form-control state-change" required>
                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code=>$name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($code); ?>" <?php echo e(old('consignee_state_code',$invoice->shippingDetail->state ?? '')==$code?'selected':''); ?>><?php echo e($name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6"><label>Address</label>
                            <textarea name="consignee_address" id="consignee_address" class="form-control"><?php echo e(old('consignee_address', $invoice->shippingDetail->address ?? '')); ?></textarea>
                        </div>
                    </div>

                    <!-- Invoice Items -->
                    <h6>Invoice Items</h6>
                    <table class="table table-bordered" id="itemsTable">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price Type</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>GST %</th>
                                <th>CGST</th>
                                <th>SGST</th>
                                <th>IGST</th>
                                <th>Total</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <select name="items[<?php echo e($index); ?>][item_id]" class="form-control item-select">
                                        <option value="">-- Select Item --</option>
                                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($it->id); ?>"
                                                <?php echo e($item->item_id==$it->id?'selected':''); ?>

                                                data-sales="<?php echo e($it->pricings->first()->salesprice_amount ?? 0); ?>"
                                                data-sales-tax="<?php echo e($it->pricings->first()->salesprice_tax ?? 0); ?>"
                                                data-purchase="<?php echo e($it->pricings->first()->purches_price_amount ?? 0); ?>"
                                                data-purchase-tax="<?php echo e($it->pricings->first()->purches_price_tax ?? 0); ?>"
                                                data-mrp="<?php echo e($it->pricings->first()->mrp_price ?? 0); ?>"
                                                data-gst="<?php echo e($it->pricings->first()->gst ?? 0); ?>">
                                                <?php echo e($it->item_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="items[<?php echo e($index); ?>][price_type]" class="form-control price-type">
                                        <option value="sales" <?php echo e($item->price_type=='sales'?'selected':''); ?>>Sales</option>
                                        <option value="purchase" <?php echo e($item->price_type=='purchase'?'selected':''); ?>>Purchase</option>
                                        <option value="mrp" <?php echo e($item->price_type=='mrp'?'selected':''); ?>>MRP</option>
                                    </select>
                                </td>
                                <td><input type="number" name="items[<?php echo e($index); ?>][quantity]" class="form-control qty" value="<?php echo e($item->quantity); ?>"></td>
                                <td><input type="number" name="items[<?php echo e($index); ?>][price]" class="form-control price" step="0.01" value="<?php echo e($item->price); ?>"></td>
                                <td><input type="number" name="items[<?php echo e($index); ?>][gst]" class="form-control gst" readonly value="<?php echo e($item->gst); ?>"></td>
                                <td><input type="number" class="form-control cgst" readonly value="<?php echo e($item->cgst); ?>"></td>
                                <td><input type="number" class="form-control sgst" readonly value="<?php echo e($item->sgst); ?>"></td>
                                <td><input type="number" class="form-control igst" readonly value="<?php echo e($item->igst); ?>"></td>
                                <td><input type="number" class="form-control total" readonly value="<?php echo e($item->total); ?>"></td>
                                <td><button type="button" class="btn btn-danger btn-sm removeRow">x</button></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-secondary btn-sm" id="addRow">+ Add Item</button>

                    <!-- Totals -->
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-3"><label>Discount %</label><input type="number" name="discount_percent" class="form-control" value="<?php echo e($invoice->discount_percent); ?>"></div>
                        <div class="col-md-3"><label>Discount Amount</label><input type="number" name="discount_amount" class="form-control" value="<?php echo e($invoice->discount_amount); ?>"></div>
                        <div class="col-md-3"><label>Subtotal</label><input type="number" id="subTotal" class="form-control" readonly></div>
                        <div class="col-md-3"><label>GST Total</label><input type="number" id="gstTotal" class="form-control" readonly></div>
                        <div class="col-md-3"><label>Grand Total</label><input type="number" name="total_amount" id="totalAmount" class="form-control" readonly></div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Update Invoice</button>
                        <a href="<?php echo e(route('invoices.index')); ?>" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
    let itemIndex = <?php echo e($invoice->items->count()); ?>;

    function calculateRow(row){
        let qty = parseFloat(row.find('.qty').val()) || 0;
        let price = parseFloat(row.find('.price').val()) || 0;
        let gstPercent = parseFloat(row.find('.gst').val()) || 0;
        let salesprice_tax = parseFloat(row.find('.item-select option:selected').data('sales-tax') || 0);
        let receiverState = $('select[name="receiver_state_code"]').val();
        let consigneeState = $('select[name="consignee_state_code"]').val();
        let isIntraState = receiverState === consigneeState;

        let cgst=0, sgst=0, igst=0, gstAmt=0, total=0;

        if(salesprice_tax == 0){ // GST to apply
            gstAmt = price * qty * gstPercent / 100;
            if(isIntraState){
                cgst = gstAmt/2; sgst = gstAmt/2;
            } else {
                igst = gstAmt;
            }
        } else { // tax included
            cgst=0; sgst=0; igst=0; gstAmt=0;
        }

        total = price*qty + gstAmt;

        row.find('.cgst').val(cgst.toFixed(2));
        row.find('.sgst').val(sgst.toFixed(2));
        row.find('.igst').val(igst.toFixed(2));
        row.find('.total').val(total.toFixed(2));
    }

    function calculateTotal(){
        let subtotal=0, gstTotal=0;
        $('#itemsTable tbody tr').each(function(){
            subtotal += parseFloat($(this).find('.total').val() || 0);
            gstTotal += parseFloat($(this).find('.cgst').val()||0) + parseFloat($(this).find('.sgst').val()||0) + parseFloat($(this).find('.igst').val()||0);
        });
        let discP = parseFloat($('input[name="discount_percent"]').val()) || 0;
        let discA = parseFloat($('input[name="discount_amount"]').val()) || 0;
        subtotal -= subtotal*(discP/100) + discA;
        $('#subTotal').val(subtotal.toFixed(2));
        $('#gstTotal').val(gstTotal.toFixed(2));
        $('#totalAmount').val(subtotal.toFixed(2));
    }

    // Event handlers
    $(document).on('input','.qty,.price',function(){ calculateRow($(this).closest('tr')); calculateTotal(); });

    $(document).on('change','.item-select,.price-type',function(){
        let row = $(this).closest('tr');
        let sel = row.find('.item-select option:selected');
        let type = row.find('.price-type').val();
        let price=0, gst = sel.data('gst') || 0;
        if(type=='sales'){ price = sel.data('sales') || 0; }
        if(type=='purchase'){ price = sel.data('purchase') || 0; }
        if(type=='mrp'){ price = sel.data('mrp') || 0; }
        row.find('.price').val(price);
        row.find('.gst').val(gst);
        calculateRow(row);
        calculateTotal();
    });

    $('#addRow').click(function(){
        let row = $('#itemsTable tbody tr:first').clone();
        row.find('input,select').val('');
        row.find('.qty').val(1);
        row.find('select[name*="item_id"]').attr('name',`items[${itemIndex}][item_id]`);
        row.find('select.price-type').attr('name',`items[${itemIndex}][price_type]`);
        row.find('.qty').attr('name',`items[${itemIndex}][quantity]`);
        row.find('.price').attr('name',`items[${itemIndex}][price]`);
        row.find('.gst').attr('name',`items[${itemIndex}][gst]`);
        $('#itemsTable tbody').append(row);
        itemIndex++;
    });

    $(document).on('click','.removeRow',function(){ 
        if($('#itemsTable tbody tr').length>1) $(this).closest('tr').remove(); 
        calculateTotal(); 
    });

    $('.state-change').on('change',function(){ 
        $('#itemsTable tbody tr').each(function(){ calculateRow($(this)); }); 
        calculateTotal(); 
    });

    $('input[name="discount_percent"],input[name="discount_amount"]').on('input',calculateTotal);

    // Auto-fill customer
    $('#consigneeCustomer').on('change',function(){
        let sel = $(this).find('option:selected');
        if(sel.val()!=''){
            $('#consignee_name').val(sel.data('name'));
            $('#consignee_phone').val(sel.data('phone'));
            $('#consignee_email').val(sel.data('email'));
            $('#consignee_state_code').val(sel.data('state'));
            $('#consignee_address').val(sel.data('address'));
        }
        $('#itemsTable tbody tr').each(function(){ calculateRow($(this)); });
        calculateTotal();
    });

    // Form submit via ajax
    $('#editInvoiceForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:'<?php echo e(route("invoices.update",$invoice->id)); ?>',
            method:'POST',
            data: $(this).serialize(),
            success:function(){ alert('Invoice updated'); window.location='<?php echo e(route("invoices.index")); ?>'; },
            error:function(){ alert('Error updating invoice'); }
        });
    });

    // Initial calculation on load
    $('#itemsTable tbody tr').each(function(){
        let row = $(this);
        let sel = row.find('.item-select option:selected');
        let type = row.find('.price-type').val();
        let price = 0, gst = sel.data('gst') || 0;
        if(type=='sales'){ price = sel.data('sales') || 0; }
        if(type=='purchase'){ price = sel.data('purchase') || 0; }
        if(type=='mrp'){ price = sel.data('mrp') || 0; }
        row.find('.price').val(price);
        row.find('.gst').val(gst);
        calculateRow(row);
    });
    calculateTotal();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/acttconnect/new-invoice.acttconnect.com/resources/views/admin/invoices/edit.blade.php ENDPATH**/ ?>