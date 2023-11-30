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
        $this->Cell(70, 10, 'Reporte sesiones de trabajo', 0, 0, 'C');
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
        $this->Cell(30, 10, 'Clave empleado', 1, 0, 'C', 0);
        $this->Cell(20, 10, 'Nombre', 1, 0, 'C', 0);
        $this->Cell(25, 10, 'Apellido', 1, 0, 'C', 0);
        $this->Cell(20, 10, 'Turno', 1, 0, 'C', 0);
        $this->Cell(30, 10, 'Hora de entrada', 1, 0, 'C', 0);
        $this->Cell(30, 10, 'Hora de salida', 1, 0, 'C', 0);
        $this->MultiCell(30, 5, 'Clave banda transportadora', 1, 'C');
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

$sql = "SELECT sesion_trabajo.cve_empleado, empleados.nombre, empleados.apellido, turnos.descripcion, sesion_trabajo.hora_inicio, sesion_trabajo.hora_salida, sesion_trabajo.cve_bandaT FROM bandas_transportadoras JOIN sesion_trabajo ON sesion_trabajo.cve_bandaT = bandas_transportadoras.cve_bandaT JOIN empleados ON empleados.cve_empleado = sesion_trabajo.cve_empleado JOIN turnos on turnos.cve_turno = empleados.cve_turno WHERE sesion_trabajo.fecha = '2023-11-20'";
$result = mysqli_query($conexion, $sql);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(30, 10, $row['cve_empleado'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, utf8_decode($row['nombre']), 1, 0, 'C', 0);
    $pdf->Cell(25, 10, $row['apellido'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $row['descripcion'], 1, 0, 'C', 0);
    $pdf->Cell(30, 10, $row['hora_inicio'], 1, 0, 'C', 0);
    $pdf->Cell(30, 10, $row['hora_salida'], 1, 0, 'C', 0);
    $pdf->MultiCell(30, 10, $row['cve_bandaT'], 1, 'C');
}

// Centrar la tabla en la página
$pdf->SetXY(($pdf->GetPageWidth() - 210) / 2, $pdf->GetY());
$pdf->Output();
?>
