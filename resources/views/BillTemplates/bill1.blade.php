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
      <h2>ACT T CONNECT PVT LTD</h2>
      <p>93 INFRONT OF SAKHI KE HANUMAN JHANSI, Jhansi, Uttar Pradesh, 284001</p>
      <p>GSTIN : 09AAUCA0414B1ZO 
        <span class="state-code-box">State Code : 09</span>
      </p>
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
            <td>: INV1</td>
          </tr>
          <tr>
            <td><strong>Invoice Date</strong></td>
            <td>: <strong>04-08-2025</strong></td>
          </tr>
          <tr>
            <td><strong>State</strong></td>
            <td>: <strong>Uttar Pradesh</strong></td>
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
            <td>Fhjb</td>
            <td style="text-align:right;">gg</td>
          </tr>
        </table>
      </div>
    </div>

    <div class="address-section">
      <div class="address-box">
        <div class="address-box-title">Details of Receiver | Billed to</div>
        <p><span class="bold">Name:</span> DEMO GST Register Party</p>
        <p><span class="bold">Address:</span> Second Floor 106/3 Avanti Vihar Road Raipur Raipur</p>
        <p>Chhattisgarh 492004, Raipur, Chhattisgarh, 492004</p>
        <p><span class="bold">GSTIN:</span> 22AAICG8226H1ZO 
          <span class="state-code-box">State Code : 22</span>
        </p>
        <p><span class="bold">State:</span> Chhattisgarh</p>
      </div>

      <div class="address-box">
        <div class="address-box-title">Details of Consignee | Shipped to</div>
        <p><span class="bold">Name:</span> DEMO GST Register Party</p>
        <p><span class="bold">Address:</span> Second Floor 106/3 Avanti Vihar Road Raipur Raipur</p>
        <p>Chhattisgarh 492004, Raipur, Chhattisgarh, 492004</p>
        <p><span class="bold">GSTIN:</span> 22AAICG8226H1ZO 
          <span class="state-code-box">State Code : 22</span>
        </p>
        <p><span class="bold">State:</span> Chhattisgarh</p>
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
      <tr>
        <td>1</td>
        <td class="text-left">Demo Product</td>
        <td>1</td>
        <td>PCS</td>
        <td>100.0</td>
        <td class="highlight">100.00</td>
        <td>18.00%</td>
        <td>18.00</td>
        <td>₹ 118.00</td>
      </tr>
      <tr>
        <td colspan="2"><strong>Total</strong></td>
        <td>1</td>
        <td colspan="2"></td>
        <td class="highlight">₹ 100.00</td>
        <td></td>
        <td>₹ 18.00</td>
        <td>₹ 118.00</td>
      </tr>
    </table>

    <!-- Summary Table -->
    <table class="summary-table">
      <tr>
        <td rowspan="5" style="width: 60%;">
          <strong>Total Invoice Amount in words</strong><br>
          <span style="font-weight: bold;">One Hundred Eighteen Rupees Only /-</span>
        </td>
        <td class="label">Total Amount Before Tax</td>
        <td>₹ 100.00</td>
      </tr>
      <tr>
        <td class="label">Add : IGST</td>
        <td>₹ 18.00</td>
      </tr>
      <tr>
        <td class="label">Total Tax Amount</td>
        <td>₹ 18.00</td>
      </tr>
      <tr>
        <td class="label">Final Invoice Amount</td>
        <td>₹ 118.00</td>
      </tr>
      <tr>
        <td class="label">Balance Due</td>
        <td>₹ 118.00</td>
      </tr>
    </table>

    <!-- Footer -->
    <div class="footer-sign">
      Certified that the particular given above are true and correct<br>
      <strong>For, ACT T CONNECT PVT LTD</strong>
    </div>

    <div class="sign-box">
      <div>✍</div>
      <div>Authorised Signatory</div>
    </div>

    <div class="thank-you">Thankyou for your business</div>
  </div>
</body>
</html>
