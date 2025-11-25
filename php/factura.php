<?php
// factura.php - PDF con datos del formulario

// Incluir DomPDF
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// DEBUG: Mostrar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    
    // 1. CONEXIÓN A LA BASE DE DATOS
    $cnx = new mysqli("localhost", "root", "", "mahr");

    if ($cnx->connect_error) {
        die("Fallo de conexión a la BD: " . $cnx->connect_error);
    }

    // 2. Obtener datos del formulario
    $checkbox = isset($_POST['existe']) ? $_POST['existe'] : '0';

    // Inicializar todas las variables
    $NombreEmpresa = $_POST['NombreEmpresa'] ?? '';
    $persona = $_POST['persona'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $EstadoLugar = $_POST['EstadoLugar'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';
    $NumeroOrden = $_POST['NumeroOrden'] ?? '';
    $TiempoEntrega = $_POST['TiempoEntrega'] ?? '';
    $codigo = $_POST['codigo'] ?? '';
    $descuento = $_POST['descuento'] ?? '';
    $cantItems = $_POST['cantItems'] ?? '';

    // 3. LÓGICA PARA CLIENTE EXISTENTE
    if($checkbox == '1') {
        // Cliente existente - obtener datos de la base de datos
        $sql_verificar = "SELECT AttnCliente, Direccion, Phone, Email FROM cliente WHERE NombreEmpresa = ?";
        $stmt_verificar = $cnx->prepare($sql_verificar);
        
        if ($stmt_verificar) {
            $stmt_verificar->bind_param("s", $NombreEmpresa);
            $stmt_verificar->execute();
            $resultado = $stmt_verificar->get_result();
            
            if ($resultado->num_rows > 0) {
                // La empresa existe, recuperar sus datos
                $fila = $resultado->fetch_assoc();
                $persona = $fila['AttnCliente'];
                $direccion = $fila['Direccion'];
                $telefono = $fila['Phone'];
                $email = $fila['Email'];
            }
            $stmt_verificar->close();
        }
    } else {
        // Cliente nuevo - verificar si existe antes de insertar
        $empresa_existe = false;
        $sql_verificar = "SELECT NombreEmpresa FROM cliente WHERE NombreEmpresa = ?";
        $stmt_verificar = $cnx->prepare($sql_verificar);
        
        if ($stmt_verificar) {
            $stmt_verificar->bind_param("s", $NombreEmpresa);
            $stmt_verificar->execute();
            $resultado = $stmt_verificar->get_result();
            $empresa_existe = ($resultado->num_rows > 0);
            $stmt_verificar->close();
        }

        // Insertar nuevo cliente si no existe
        if (!$empresa_existe) {
            $sql_insertar = "INSERT INTO cliente (NombreEmpresa, AttnCliente, Direccion, Phone, Email) VALUES (?, ?, ?, ?, ?)";
            $stmt_insertar = $cnx->prepare($sql_insertar);
            
            if ($stmt_insertar) {
                $stmt_insertar->bind_param("sssss", $NombreEmpresa, $persona, $direccion, $telefono, $email);
                $stmt_insertar->execute();
                $stmt_insertar->close();
            }
        }
    }

    // 4. Cerrar conexión
    $cnx->close();

    // 5. Configurar DomPDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    
    $dompdf = new Dompdf($options);

    // 6. HTML del PDF
    $html = '
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Mahr Proposal</title>
    <style>
    /* TUS ESTILOS CSS AQUÍ (mantén todo tu CSS actual) */
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
    .logo {
        width: 180px;
        display: block;
        margin: 0 auto;
    }
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
    .footer-text {
        margin-top: 30px;
        font-size: 12px;
    }
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
    .company-info {
        position: absolute;
        top: 40px;
        right: 40px;
        text-align: right;
        font-size: 15px;
        line-height: 1.4rem;
    }
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
    </style>
    </head>

    <body>

    <!-- PÁGINA 1 -->
    <div class="page">
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

        <table style="width:100%; font-size:14px;">
            <tr>
                <td><b>Date:</b> ' . date('d/m/Y') . '</td>
                <td><b>Proposal Number:</b> <span>LC051625-153</span></td>
            </tr>
        </table>

        <div class="right-instructions-box">
            <p>Please refer to Proposal Number on order and all correspondence. Address reply to:</p>
            <p><strong>Mahr Corporation de Mexico</strong></p>
            <p><strong>Cel. 462 107 33 73</strong><br>
            <a href="mailto:luis.chairez@mahr.com">luis.chairez@mahr.com</a></p>
            <p>by:&nbsp;&nbsp;&nbsp;&nbsp; <strong>Luis Chairez</strong></p>
        </div>

        <br>

        <!-- DATOS DEL CLIENTE -->
        <div style="font-size:13px; line-height:1.3;">
            ' . htmlspecialchars($NombreEmpresa) . '<br>
            attn. ' . htmlspecialchars($persona) . '<br>
            ' . htmlspecialchars($direccion) . '<br>
            ' . (!empty($EstadoLugar) ? htmlspecialchars($EstadoLugar) . '<br>' : '') . '
            Phone: ' . htmlspecialchars($telefono) . '<br>
            E-Mail: ' . htmlspecialchars($email) . '
        </div>

        <br>

        <table style="width:100%; font-size:14px;">
            <tr>
                <td><b>Reference:</b> ' . htmlspecialchars($NumeroOrden) . '</td>
            </tr>
            <tr>
                <td><b>Dated:</b> ' . date('d/m/Y') . '</td>
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
                <td>' . htmlspecialchars($codigo) . '</td>
                <td>
                    REMOTE INDICATING UNIT, MAXUM3 WITH DATA OUTPUT - 6PIN<br><br>
                    <span style="color:red; font-weight:bold;">****' . htmlspecialchars($TiempoEntrega) . '*****</span><br><br>
                    <img src="https://i.imgur.com/NcQAkmw.png" style="width:220px; display:block; margin:auto;">
                </td>
                <td>' . htmlspecialchars($cantItems) . '</td>
                <td>$696.60</td>
                <td>$696.60</td>
            </tr>

            <!-- TOTAL -->
            <tr>
                <td colspan="5" style="text-align:right; font-weight:bold;">Total</td>
                <td>$696.60</td>
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

    <!-- PÁGINA 2 - TÉRMINOS Y CONDICIONES -->
    <div class="page">
        <img src="https://i.imgur.com/nnG2jjD.png" class="logo">

        <div class="terms-title">MAHR CORPORATION DE MEXICO S.A DE C.V</div>
        <div class="terms-subtitle">STANDARD TERMS AND CONDITIONS OF SALE</div>

        <div class="terms-text">
            ' . include_terms_and_conditions() . '
        </div>
    </div>
    </body>
    </html>
    ';
    
    // 7. Generar PDF
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    // 8. Enviar al navegador
    $dompdf->stream("cotizacion_mahr.pdf", ["Attachment" => false]);
    
} catch (Exception $e) {
    echo "Error al generar PDF: " . $e->getMessage();
}

// Función para incluir términos y condiciones
function include_terms_and_conditions() {
    return '
    1. TERMS AND CONDITIONS OF SALE. The terms and conditions appearing in this quotation shall constitute the complete agreement between the parties...
    <br><br>
    2. TITLE AND RISK OF LOSS. Title to, and risk of loss of the products sold hereunder shall pass to Purchaser upon delivery...
    <br><br>
    <!-- ... resto de tus términos y condiciones ... -->
    ';
}
?>