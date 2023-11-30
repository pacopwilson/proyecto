<?php
require('../fpdf/fpdf.php');
require('../../inicio_sesion/conexion.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        //$this->Image('logo.png',10,8,33);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 20);
        // Movernos a la derecha
        $this->Cell(60);
        // Título
        $this->Cell(70, 10, utf8_decode('Reporte información de clientes'), 0, 0, 'C');
        // Salto de línea
        $this->Ln(10);

        $this->SetFont('Arial', '', 10);
        // Movernos a la derecha
        $this->Cell(60);
        // Título
        $this->Cell(70, 10, 'GSW Data Engineers', 0, 0, 'C');
        // Salto de línea
        $this->Ln(15);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(20, 10, 'Nombre', 1, 0, 'C', 0);
        $this->Cell(20, 10, 'Apellido', 1, 0, 'C', 0);
        $this->Cell(40, 10, utf8_decode('Ciudad'), 1, 0, 'C', 0);
        $this->Cell(30, 10, utf8_decode('Estado'), 1, 0, 'C', 0);
        $this->Cell(25, 10, utf8_decode('Teléfono'), 1, 0, 'C', 0);
        $this->Cell(40, 10, 'Paquetes entregados', 1, 0, 'C', 0);
        $this->Cell(20, 10, 'Fecha', 1, 1, 'C', 0);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$sql = "SELECT clientes.nombre, clientes.apellido, ciudades.nombre as ciudad_nombre, estados.nombre as estado_nombre, clientes.telefono, servicios.paquetes_entregados, servicios.fecha_servicio FROM estados JOIN ciudades ON estados.cve_estado = ciudades.cve_estado JOIN clientes ON ciudades.cve_ciudad = clientes.cve_ciudad JOIN servicios ON clientes.cve_cliente = servicios.cve_cliente WHERE servicios.fecha_servicio = '2023-10-23'";
$result = mysqli_query($conexion, $sql);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);



while ($row = $result->fetch_assoc()) {
    $pdf->Cell(20, 10, utf8_decode($row['nombre']), 1, 0, 'C', 0);
    $pdf->Cell(20, 10, utf8_decode($row['apellido']), 1, 0, 'C', 0);
    $pdf->Cell(40, 10, utf8_decode($row['ciudad_nombre']), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode($row['estado_nombre']), 1, 0, 'C', 0);
    $pdf->Cell(25, 10, $row['telefono'], 1, 0, 'C', 0);
    $pdf->Cell(40, 10, $row['paquetes_entregados'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $row['fecha_servicio'], 1, 1, 'C', 0);
}

// Centrar la tabla en la página
$pdf->SetXY(($pdf->GetPageWidth() - 210) / 2, $pdf->GetY());
$pdf->Output();
?>