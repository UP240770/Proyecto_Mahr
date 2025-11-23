<?php
// simple_pdf_form.php - PDF con datos del formulario

// Incluir DomPDF
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

try {
    // Obtener datos del formulario
    $titulo = $_POST['titulo'] ?? 'Documento PDF';
    $nombre = $_POST['nombre'] ?? 'Usuario';
    
    // Configurar DomPDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    
    $dompdf = new Dompdf($options);
    
    // HTML del PDF
    $html = '
    
    <html lang="en">
<head>
<meta charset="UTF-8">
<title>Mahr Proposal</title>

<style>
/* CONFIGURACIÓN DE PÁGINA */
@page {
    size: letter;
    margin: 25mm;
}

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: #ffffff;
}

.page {
    width: 100%;
    height: 1080px;
    box-sizing: border-box;
    padding: 20px 30px;
    position: relative;
    page-break-after: always;
}

/* LOGO */
.logo {
    width: 180px;
    display: block;
    margin: 0 auto;
}

/* ENCABEZADOS */
.header-line {
    width: 100%;
    border-top: 4px solid black;
    margin: 10px 0;
}

.proposal-title {
    font-size: 20px;
    font-weight: bold;
    margin-top: 5px;
}

/* TABLA PRINCIPAL */
.table-main {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-size: 13px;
}

.table-main th, .table-main td {
    border: 2px solid black;
    padding: 5px;
    vertical-align: top;
}

.table-main th {
    background: #e8e8e8;
    font-weight: bold;
}

/* PIE DE PÁGINA */
.footer-text {
    margin-top: 30px;
    font-size: 12px;
}

/* PÁGINA 2 — TÉRMINOS */
.terms-title {
    font-size: 20px;
    font-weight: bold;
    text-align: center;
}

.terms-subtitle {
    font-size: 14px;
    text-align: center;
    margin-bottom: 20px;
}

.terms-text {
    font-size: 12px;
    line-height: 1.4;
    text-align: justify;
}

/* GENERAL */
/*body {
    font-family: Arial, Helvetica, sans-serif;
    margin: 0;
    padding: 0;
    background: #f4f4f4;
}
*/

/*.page {
    width: 816px;        
    height: 1056px;       
    background: white;
    margin: 20px auto;
    padding: 40px;
    box-sizing: border-box;
    box-shadow: 0 0 8px rgba(0,0,0,0.2);
    position: relative;
}
*/
/* ENCABEZADO  */
.header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.header img {
    width: 150px;
}

.header-right {
    text-align: right;
    font-size: 14px;
}

.big-title {
    font-size: 26px;
    font-weight: bold;
    margin-top: 10px;
}

/* SECCIÓN DATOS */
.section-title {
    background: black;
    color: white;
    padding: 5px 10px;
    margin-top: 25px;
    font-size: 18px;
    font-weight: bold;
}

.subsection {
    padding: 10px;
    font-size: 15px;
}

/* TABLA DE ITEMS */
.table-container {
    margin-top: 20px;
}

.table-container table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.table-container th {
    background: #d9d9d9;
    padding: 8px;
    border: 2px solid #000;
    font-weight: bold;
}

.table-container td {
    padding: 8px;
    border: 2px solid #000;
}

/* IMAGEN DEL EQUIPO */
.product-image {
    width: 280px;
    margin-top: 20px;
    border: 2px solid #bbb;
}

/* TOTALES */
.total-box {
    width: 300px;
    margin-left: auto;
    margin-top: 20px;
    border: 2px solid black;
    padding: 10px;
    font-size: 16px;
}

.total-box div {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
}

/* PÁGINA 2: TÉRMINOS */
.terms-title {
    font-size: 20px;
    margin-top: 20px;
    font-weight: bold;
    border-bottom: 3px solid black;
    padding-bottom: 5px;
}

.terms-text {
    margin-top: 10px;
    font-size: 14px;
    line-height: 1.4rem;
    text-align: justify;
}

/*  PIE DE PÁGINA */
.footer {
    position: absolute;
    bottom: 25px;
    left: 40px;
    right: 40px;
    font-size: 12px;
    text-align: center;
    color: #444;
}
/* INFORMACIÓN SUPERIOR DERECHA  */
.company-info {
    position: absolute;
    top: 40px;
    right: 40px;
    text-align: right;
    font-size: 15px;
    line-height: 1.4rem;
}
/*  CUADRO DE INSTRUCCIONES DERECHA  */
.right-instructions-box {
    position: absolute;
    top: 250px;   
    right: 40px;
    width: 320px;
    font-size: 14px;
    line-height: 1.4rem;
}

.right-instructions-box p {
    margin: 6px 0;
}

.right-instructions-box a {
    color: #0000cc;
    text-decoration: none;
}

.right-instructions-box a:hover {
    text-decoration: underline;
}


</style>
</head>

<body>

<!-- PÁGINA 1 -->
<div class="page">
  

    <!-- LOGO -->
    <img src="https://i.imgur.com/nnG2jjD.png" class="logo">
<div class="company-info">
    <strong>Mahr Corporation de Mexico</strong><br>
    Diego de Montemayor 211<br>
    Col. Centro<br>
    Monterrey, N.L. CP 64000<br>
    Tel (81) 8333-2010
</div>

    <div class="proposal-title">PROPOSAL</div>
    <div class="header-line"></div>

    <!-- FECHA Y NÚMERO -->
    <table style="width:100%; font-size:14px;">
        <tr>
            <td><b>Date:</b> ' . date('d/m/Y') . '</td>
            <td><b>Proposal Number:</b> <span contenteditable="true">LC051625-153</span></td>
          <div class="right-instructions-box">
    <p>Please refer to Proposal Number on order and all correspondence. Address reply to:</p>
    <p><strong>Mahr Corporation de Mexico</strong></p>

    <p><strong>Cel. 462 107 33 73</strong><br>
    <a href="mailto:luis.chairez@mahr.com">luis.chairez@mahr.com</a></p>

    <p>by:&nbsp;&nbsp;&nbsp;&nbsp; <strong>Luis Chairez</strong></p>
</div>

        </tr>
    </table>

    <br>

    <!-- DATOS  EDITABLES -->
    <div style="font-size:13px; line-height:1.3;" contenteditable="true">
        AAM MAQUILADORA MEXICO S. de R.L. de C.V.<br>
        attn. Abhram Israel Aviña Castañeda<br>
        Av. Comerciantes 1300, Parque Industrial FIPASI<br>
        Carr. Silao-Irapuato km 5.3<br>
        Silao, Gto. 36100<br>
        Phone: 52 (472) 7229532 &nbsp;&nbsp;&nbsp;  <br>
        E-Mail:AbrahamIsrael.Avina@aam.com
    </div>

    <br>

    <table style="width:100%; font-size:14px;">
        <tr>
            <td><b>Reference:</b></td>
           
        <tr>
            <td><b>Dated:</b></td>
          
        </tr>
    </table>

    <br>

    <!-- TABLA PRINCIPAL -->
    <table class="table-main">
        <tr>
            <th style="width:40px;">Item</th>
            <th style="width:80px;">Order Number</th>
            <th>Description</th>
            <th style="width:40px;">Qty.</th>
            <th style="width:90px;">Unit Price (US $)</th>
            <th style="width:90px;">Ext. Price (US $)</th>
        </tr>

       
        <tr>
            <td>1</td>
            <td contenteditable="true">2033011</td>
            <td contenteditable="true">
                REMOTE INDICATING UNIT, MAXUM3 WITH DATA OUTPUT - 6PIN<br><br>
                <span style="color:red; font-weight:bold;">****Estimated delivery time 16 - 22 Weeks *****</span><br><br>

                <!-- Imagen que tú colocarás -->
                <img src="https://i.imgur.com/NcQAkmw.png" style="width:220px; display:block; margin:auto;">

                -->


            </td>
            <td contenteditable="true">1</td>
            <td contenteditable="true">$696.60</td>
            <td contenteditable="true">$696.60</td>
        </tr>

        <!-- TOTAL -->
        <tr>
            <td colspan="5" style="text-align:right; font-weight:bold;">Total</td>
            <td contenteditable="true">$696.60</td>
        </tr>
    </table>

    <br><br>

    <!-- PIE DE PÁGINA -->
    <div class="footer-text">
        <b>Estimated Delivery from Receipt of Order:</b> Indicated on each item<br><br>
        <b>Incoterms:</b> Your Facility in Mexico<br>
        <b>Payment Terms:</b> Net 30 days from invoice date*, subject to credit approval<br>
        <b>Quote validity:</b> 30 Days<br>
        <b>Price:</b> add. +16% IVA
        <br><br><br>
        <b>by</b><br><br>
        Luis Chairez<br>
        Mahr Corporation de Mexico
    </div>
</div>

<!-- PÁGINA 2 -->
<div class="page">

    <img src="https://i.imgur.com/nnG2jjD.png" class="logo">

    <div class="terms-title">MAHR CORPORATION DE MEXICO S.A DE C.V</div>
    <div class="terms-subtitle">STANDARD TERMS AND CONDITIONS OF SALE</div>

    <div class="terms-text">
        <!-- TEXTO DE TÉRMINOS AQUÍ -->
      
        1. TERMS AND CONDITIONS OF SALE. The terms and conditions appearing in this quotation shall constitute the complete agreement between the parties, and such terms and conditions supersede any prior or contemporaneous agreements or communications between th					

        <br><br>
       2. TITLE AND RISK OF LOSS. Title to, and risk of loss of the products sold hereunder shall pass to Purchaser upon delivery to the carrier at the f.o.b. point of shipment (Providence, R. I. unless otherwise specified).					

        <br><br>
       3. PRICES. Prices and discounts are subject to change without notice.  Written quotations automatically expire thirty (30) calendar days from the date of issuance, unless otherwise stated in the proposal.					

        <br><br>
       4. TERMS OF PAYMENT. Standard terms of payment are net thirty (30) days from date of invoice (subject to credit approval) for direct purchases.  Payments begin upon receipt and acceptance of equipment for purchases through Mahr Financial Services.					

        <br><br>
       5. PAYMENTS. If, in the judgment of Seller, the financial condition of the Purchaser, at any time during the manufacturing process, or at the time the material is ready for shipment, does not justify the terms of payment specified above, Seller may requir					

        <br><br>
       6. DELIVERY. Seller reserves the right to modify delivery dates to accommodate its production schedule, to deliver the products in more than one installment and to determine the quantity of products to be contained in each shipment.  Delivery dates are th					

        <br><br>
       7. FORCE MAJEURE. Seller shall not be liable for loss, damage, detention or delay resulting from causes beyond its reasonable control including, but not limited to, fire, strike or other concerted action of workmen, act or omission of any governmental aut					

        <br><br>
       8. SHIPMENT CLAIMS. Claims by Purchaser must be made within three (3) days after receipt of shipments and Seller shall have an opportunity to investigate any such claim by Purchaser.  The shipment shall be conclusively presumed to be proper and conforming					

        <br><br>
       9. RETURNING PRODUCTS. Prior to the return of any products to the factory, Purchaser must submit a written request for authorization.  The written request must reference the order number and explain in detail why approval to make the return is requested (					

        <br><br>
       10. WARRANTY. Mahr Inc. (“Seller”) warrants its catalog and modified catalog products to be free from defects in material and workmanship under normal use and service for a period of one year from date of original Purchaser’s invoice.  Upon receipt of pro					 
      Repair or replacement of the product in the manner above is the exclusive warranty remedy and shall constitute complete fulfillment of all Seller’s liabilities for breach of this Warranty without regard to whether any defect was discoverable or latent at 					

      THE FOREGOING WARRANTY IS EXCLUSIVE AND IN LIEU OF ANY OTHER WARRANTIES OF QUALITY, WHETHER EXPRESS OR IMPLIED (INCLUDING ANY WARRANTY OF MERCHANTABILITY OR FITNESS FOR PURPOSE).  IN NO EVENT SHALL SELLER BE LIABLE FOR SPECIAL, INDIRECT, INCIDENTAL OR CON					

      The products shall conform to the contract if they meet the specifications thereof within the margins and tolerances usual or customary in the trade.					

      Warranty on special or custom designed products will be furnished in lieu of the above, if different.					


        <br><br>
        11. PATENTS. Seller shall indemnify Purchaser against attorney’s fees or any damages or costs awarded against Purchaser in the event any legal proceeding is brought against Purchaser by a third person claiming the material delivered hereunder in itself co					

        <br><br>
        12. PURCHASER’S RIGHT OF TERMINATION. Purchaser shall have the right to terminate this order, in whole or in part, upon notice in writing to Seller.  In the event of termination, Seller shall, as directed, cease work and transfer to Purchaser title to all					

        <br><br>
       13. TAXES. Any taxes, import or export duties or tariffs imposed with respect to the sale of the products, which the Seller at any time either pays or must collect, shall be added to and paid as part of the purchase price.					

        <br><br>
       14. LIMITATION OF LIABILITY. IN NO EVENT SHALL THE SELLER BE LIABLE (a) FOR DIRECT DAMAGES IN EXCESS OF THE ORIGINAL PURCHASE PRICE OF THE PRODUCTS CLAIMED TO BE DEFECTIVE, OR (b) FOR ANY SPECIAL CONSEQUENTIAL, INCIDENTAL OR INDIRECT DAMAGES WITH RESPECT 					

        <br><br>
        15. LAW. The rights and obligations of Seller and Purchaser hereunder shall be governed by the Uniform Commercial Code as enacted and construed in the State of Rhode Island and the parties hereby agree to submit to the jurisdiction of the courts of the St					

        <br><br>
       16. MINIMUM ORDER VALUE. $100.00 for new products or parts. $35.00 for repair or calibration services.					

    </div>
</div>

</body>
</html>
    
    ';
    
    // Generar PDF
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    // Enviar al navegador
    $dompdf->stream("documento_personalizado.pdf", ["Attachment" => false]);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>