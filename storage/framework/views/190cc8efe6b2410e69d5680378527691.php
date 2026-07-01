

<?php $__env->startSection('title'); ?> Create Invoice <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
$states = [
    '01' => 'Jammu & Kashmir','02' => 'Himachal Pradesh','03' => 'Punjab','04' => 'Chandigarh',
    '05' => 'Uttarakhand','06' => 'Haryana','07' => 'Delhi','08' => 'Rajasthan','09' => 'Uttar Pradesh',
    '10' => 'Bihar','11' => 'Sikkim','12' => 'Arunachal Pradesh','13' => 'Nagaland','14' => 'Manipur',
    '15' => 'Mizoram','16' => 'Tripura','17' => 'Meghalaya','18' => 'Assam','19' => 'West Bengal',
    '20' => 'Jharkhand','21' => 'Odisha','22' => 'Chhattisgarh','23' => 'Madhya Pradesh','24' => 'Gujarat',
    '25' => 'Daman & Diu','26' => 'Dadra & Nagar Haveli','27' => 'Maharashtra','28' => 'Andhra Pradesh',
    '29' => 'Karnataka','30' => 'Goa','31' => 'Lakshadweep','32' => 'Kerala','33' => 'Tamil Nadu',
    '34' => 'Puducherry','35' => 'Andaman & Nicobar Islands','36' => 'Telangana','37' => 'Andhra Pradesh (New)'
];
?>

<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Invoices <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Create Invoice <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><h6>Generate GST Invoice</h6></div>
            <div class="card-body">
                <form id="createInvoiceForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="user_id" class="form-control" value="<?php echo e(Auth::user()->id ?? ''); ?>">

                    <!-- Receiver Details -->
                    <h6>Receiver (Billed To)</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label>Name</label>
                            <input type="text" name="receiver_name" class="form-control" required
                                   value="<?php echo e(Auth::user()->name ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Contact No.</label>
                            <input type="text" name="receiver_phone" class="form-control"
                                   value="<?php echo e(Auth::user()->phone ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Email</label>
                            <input type="email" name="receiver_email" class="form-control"
                                   value="<?php echo e(Auth::user()->email ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <label>State</label>
                            <select name="receiver_state_code" class="form-control state-change" required>
                                <option value="">-- Select State --</option>
                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($code); ?>" 
                                        <?php echo e((Auth::user()->state == $name) ? 'selected' : ''); ?>>
                                        <?php echo e($name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <!-- Customer Dropdown -->
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
                                        data-address="<?php echo e($customer->place_of_supply); ?>">
                                        <?php echo e($customer->customer_name); ?> (<?php echo e($customer->company_name ?? ''); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                       <div class="col-md-4">
    <label>Payment Type</label>
    <select id="paymentType" name="payment_type" class="form-control" required>
        <option value="">-- Select payment type --</option>
        <option value="cash" selected>Cash</option>
        <option value="credit_card">Credit Card</option>
        <option value="debit_card">Debit Card</option>
        <option value="upi">UPI</option>
        <option value="net_banking">Net Banking</option>
        <option value="wallet">Wallet</option>
        <option value="cheque">Cheque</option>
        <option value="bank_transfer">Bank Transfer</option>
        <option value="other">Other</option>
    </select>
</div>

                    </div>

                    <!-- Consignee Fields -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-3"><label>Name</label><input type="text" name="consignee_name" id="consignee_name" class="form-control" required></div>
                        <div class="col-md-3"><label>Contact No.</label><input type="text" name="consignee_phone" id="consignee_phone" class="form-control"></div>
                        <div class="col-md-3"><label>Email</label><input type="email" name="consignee_email" id="consignee_email" class="form-control"></div>
                        <div class="col-md-3"><label>State</label>
                            <select name="consignee_state_code" id="consignee_state_code" class="form-control state-change" required>
                                <option value="">-- Select State --</option>
                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($code); ?>"><?php echo e($name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6"><label>Delivery Address</label><textarea name="consignee_address" id="consignee_address" class="form-control"></textarea></div>
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
                            <tr>
                                <td>
                                    <select name="items[0][item_id]" class="form-control item-select" required>
                                        <option value="">-- Select Item --</option>
                                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($it->id); ?>"
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
                                    <select name="items[0][price_type]" class="form-control price-type">
                                        <option value="sales">Sales Price</option>
                                        <option value="purchase">Purchase Price</option>
                                        <option value="mrp">MRP</option>
                                    </select>
                                </td>
                                <td><input type="number" name="items[0][quantity]" class="form-control qty" value="1" min="1"></td>
                                <td><input type="number" name="items[0][price]" class="form-control price" step="0.01"></td>
                                <td><input type="number" name="items[0][gst]" class="form-control gst" readonly></td>
                                <td><input type="number" class="form-control cgst" readonly></td>
                                <td><input type="number" class="form-control sgst" readonly></td>
                                <td><input type="number" class="form-control igst" readonly></td>
                                <td><input type="number" class="form-control total" readonly></td>
                                <td><button type="button" class="btn btn-danger btn-sm removeRow">x</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-secondary" id="addRow">+ Add Item</button>

                    <!-- Totals -->
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-3"><label>Discount %</label><input type="number" name="discount_percent" class="form-control" value="0"></div>
                        <div class="col-md-3"><label>Discount Amount</label><input type="number" name="discount_amount" class="form-control" value="0"></div>
                        <!--<div class="col-md-3"><label>Round Off</label>-->
                        <!--    <select id="roundType" name="round_type" class="form-control"><option value="none">None</option></select>-->
                        <!--    <input type="hidden" name="round_off" id="roundOffValue" value="0">-->
                        <!--</div>-->
                        <div class="col-md-3">
    <label>Round Off</label>
    <select id="roundType" name="round_type" class="form-control">
        <option value="none">None</option>
    </select>
    <input type="hidden" name="round_off" id="roundOffValue" value="0">
</div>

                        <div class="col-md-3"><label>Subtotal</label><input type="number" id="subTotal" class="form-control" readonly></div>
                        <div class="col-md-3"><label>GST Total</label><input type="number" id="gstTotal" class="form-control" readonly></div>
                        <div class="col-md-3"><label>Grand Total</label><input type="number" name="total_amount" id="totalAmount" class="form-control" readonly></div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Generate Invoice</button>
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
    let itemIndex = 1;

    // Auto-fill Consignee fields
    $('#consigneeCustomer').on('change', function(){
        let selected = $(this).find('option:selected');
        if(selected.val() !== '') {
            $('#consignee_name').val(selected.data('name'));
            $('#consignee_phone').val(selected.data('phone'));
            $('#consignee_email').val(selected.data('email'));
            $('#consignee_state_code').val(selected.data('state'));
            $('#consignee_address').val(selected.data('address'));
        } else {
            $('#consignee_name, #consignee_phone, #consignee_email, #consignee_state_code, #consignee_address').val('');
        }
    });

    // Calculate single row
    function calculateRow(row){
        let qty = parseFloat(row.find('.qty').val())||0;
        let price = parseFloat(row.find('.price').val())||0;
        let gst = parseFloat(row.find('.gst').val())||0;
        let taxFlag = row.data('taxFlag') || 0;

        let receiverState = $('select[name="receiver_state_code"]').val();
        let consigneeState = $('select[name="consignee_state_code"]').val();
        let isIntraState = receiverState === consigneeState;

        let cgst=0, sgst=0, igst=0, total=0, gstAmt=0;

        if(gst > 0){
            if(taxFlag == 1){
                gstAmt = (price * qty * gst)/(100 + gst);
                price = (price * qty) - gstAmt;
            } else {
                gstAmt = price * qty * gst / 100;
                price = price * qty;
            }

            if(isIntraState){
                cgst = gstAmt/2;
                sgst = gstAmt/2;
            } else {
                igst = gstAmt;
            }
            total = price + gstAmt;
        } else {
            total = price * qty;
        }

        row.find('.cgst').val(cgst.toFixed(2));
        row.find('.sgst').val(sgst.toFixed(2));
        row.find('.igst').val(igst.toFixed(2));
        row.find('.total').val(total.toFixed(2));
    }

    // Calculate totals
    function calculateTotal(){
        let subtotal=0, gstTotal=0;
        $('#itemsTable tbody tr').each(function(){
            subtotal += parseFloat($(this).find('.total').val()||0);
            gstTotal += parseFloat($(this).find('.cgst').val()||0) 
                      + parseFloat($(this).find('.sgst').val()||0) 
                      + parseFloat($(this).find('.igst').val()||0);
        });

        let discP = parseFloat($('input[name="discount_percent"]').val())||0;
        let discA = parseFloat($('input[name="discount_amount"]').val())||0;
        let discount = subtotal*(discP/100) + discA;
        subtotal -= discount;

        // store raw subtotal (before round-off)
        $('#baseSubTotal').val(subtotal.toFixed(2));

        $('#subTotal').val(subtotal.toFixed(2));
        $('#gstTotal').val(gstTotal.toFixed(2));

        updateRoundOffOptions(subtotal);
        applyRoundOff();
    }

    // Populate item row from selected item
    function updateRowFromItem(row){
        let sel = row.find('.item-select option:selected');
        let type = row.find('.price-type').val();
        let price=0, gst=0, taxFlag=0;

        if(type=="sales"){ 
            price=sel.data('sales')||0; 
            gst=sel.data('gst')||0; 
            taxFlag=sel.data('sales-tax')||0;
        }
        if(type=="purchase"){ 
            price=sel.data('purchase')||0; 
            gst=sel.data('gst')||0; 
            taxFlag=sel.data('purchase-tax')||0;
        }
        if(type=="mrp"){ 
            price=sel.data('mrp')||0; 
            gst=sel.data('gst')||0; 
            taxFlag=1;
        }

        row.find('.price').val(price);
        row.find('.gst').val(gst);
        row.data('taxFlag', taxFlag);

        calculateRow(row);
        calculateTotal();
    }

    // Add / Remove row
    $('#addRow').click(function(){
        let row = $('#itemsTable tbody tr:first').clone();
        row.find('input').val('');
        row.find('select').val('');
        row.find('.qty').val(1);
        row.find('.total,.cgst,.sgst,.igst,.gst,.price').val('');
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

    // Events
    $(document).on('change','.item-select,.price-type',function(){
        updateRowFromItem($(this).closest('tr'));
    });
    $(document).on('input','.qty,.price',function(){ 
        calculateRow($(this).closest('tr')); 
        calculateTotal(); 
    });
    $('.state-change').on('change', function(){
        $('#itemsTable tbody tr').each(function(){
            calculateRow($(this));
        });
        calculateTotal();
    });
    $('input[name="discount_percent"],input[name="discount_amount"]').on('input',calculateTotal);
    $(document).on('change','#roundType',function(){
        applyRoundOff();
    });

    // Submit
    $('#createInvoiceForm').submit(function(e){
        e.preventDefault();
        $.post('<?php echo e(route("invoices.store")); ?>', $(this).serialize(), function(res){
            alert("Invoice saved!");
            window.location='<?php echo e(route("invoices.index")); ?>';
        }).fail(()=>alert("Error saving invoice"));
    });
});

// -------- Round Off Helpers --------
function updateRoundOffOptions(grandTotal) {
    let fractional = (grandTotal % 1).toFixed(2); 
    let options = '<option value="none" data-round="0">None</option>';

    if (fractional > 0) {
        let plus = (1 - fractional).toFixed(2);   
        let minus = (0 - fractional).toFixed(2); 
        options += `<option value="plus" data-round="${plus}">+${plus}</option>`;
        options += `<option value="minus" data-round="${minus}">${minus}</option>`;
    }

    $('#roundType').html(options);
}

function applyRoundOff() {
    let roundValue = parseFloat($('#roundType option:selected').data('round')) || 0;
    let baseSubtotal = parseFloat($('#baseSubTotal').val()) || 0;

    let finalTotal = (baseSubtotal + roundValue).toFixed(2);

    $('#roundOffValue').val(roundValue.toFixed(2));
    $('#subTotal').val(baseSubtotal.toFixed(2)); // always show original subtotal
    $('#totalAmount').val(finalTotal);
}
</script>

<!-- Hidden field for raw subtotal -->
<input type="hidden" id="baseSubTotal" value="0">
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/acttconnect/new-invoice.acttconnect.com/resources/views/admin/invoices/create.blade.php ENDPATH**/ ?>