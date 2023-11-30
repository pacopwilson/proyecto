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
        $this->Cell(160, 10, utf8_decode('Reporte mantenimientos realizados'), 0, 0, 'C');
        // Salto de línea
        $this->Ln(10);

        $this->SetFont('Arial', '', 10);
        // Movernos a la derecha
        $this->Cell(60);
        // Título
        $this->Cell(160, 10, 'GSW Data Engineers', 0, 0, 'C');
        // Salto de línea
        $this->Ln(15);

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(20, 10, 'Clave empleado', 1, 0, 'C', 0);
        $this->Cell(15, 10, 'Nombre', 1, 0, 'C', 0);
        $this->Cell(15, 10, 'Apellido', 1, 0, 'C', 0);
        $this->Cell(30, 10, 'Puesto', 1, 0, 'C', 0);
        $this->Cell(15, 10, 'Fecha', 1, 0, 'C', 0);
        $this->Cell(25, 10, utf8_decode('Hora de terminación'), 1, 0, 'C', 0);
        $this->Cell(30, 10, utf8_decode('Clave banda transportadora'), 1, 0, 'C', 0);
        $this->Cell(55, 10, 'Incidencia', 1, 0, 'C', 0);
        $this->Cell(65, 10, utf8_decode('Solución'),1, 1, 'C', 0);
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

$sql = "SELECT empleados.cve_empleado, empleados.nombre, empleados.apellido, puestos.descripcion, mantenimientos.fecha_inicio, mantenimientos.hora_inicio,bandas_transportadoras.cve_bandaT, mantenimientos.incidencia, mantenimientos.solucion FROM puestos JOIN empleados ON puestos.cve_puesto = empleados.cve_puesto JOIN mantenimientos ON empleados.cve_empleado = mantenimientos.cve_empleado JOIN bandas_transportadoras ON bandas_transportadoras.cve_bandaT = mantenimientos.cve_bandaT";
$result = mysqli_query($conexion, $sql);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage("landscape");
$pdf->SetFont('Arial', '', 6);



while ($row = $result->fetch_assoc()) {
    $pdf->Cell(20, 10, $row['cve_empleado'], 1, 0, 'C', 0);
    $pdf->Cell(15, 10, utf8_decode($row['nombre']), 1, 0, 'C', 0);
    $pdf->Cell(15, 10, utf8_decode($row['apellido']), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode($row['descripcion']), 1, 0, 'C', 0);
    $pdf->Cell(15, 10, $row['fecha_inicio'], 1, 0, 'C', 0);
    $pdf->Cell(25, 10, $row['hora_inicio'], 1, 0, 'C', 0);
    $pdf->Cell(30, 10, $row['cve_bandaT'], 1, 0, 'C', 0);
    $pdf->Cell(55, 10, $row['incidencia'], 1, 0, 'C', 0);
    $pdf->Cell(65, 10, $row['solucion'], 1, 1, 'C', 0);
}

// Centrar la tabla en la página
$pdf->SetXY(($pdf->GetPageWidth() - 210) / 2, $pdf->GetY());
$pdf->Output();
?>