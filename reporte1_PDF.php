<?php
require('../fpdf/fpdf.php');

require ('../../inicio_sesion/conexion.php');

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
	    // Logo
	    //$this->Image('logo.png',10,8,33);
	    // Arial bold 15
	    $this->SetFont('Arial','B',20);
	    // Movernos a la derecha
	    $this->Cell(60);
	    // Título
	    $this->Cell(70,10,'Reporte Inventarios',0,0,'C');
	    // Salto de línea
	    $this->Ln(10);

	   	$this->SetFont('Arial','',10);
	    // Movernos a la derecha
	    $this->Cell(60);
	    // Título
	    $this->Cell(70,10,'GSW Data Engineers',0,0,'C');
	   	// Salto de línea
	    $this->Ln(15);

	    $this->SetFont('Arial','B',10);
	    $this->Cell(30, 10, 'Clave empleado', 1, 0, 'C', 0);
	    $this->Cell(20, 10, 'Nombre', 1, 0, 'C', 0);
	    $this->Cell(25, 10, 'Apellido', 1, 0, 'C', 0);
	    $this->Cell(15, 10, 'Turno', 1, 0, 'C', 0);
	    $this->Cell(30, 10, 'Clave paquete', 1, 0, 'C', 0);
	    $this->Cell(40, 10, 'Fecha de inventario', 1, 0, 'C', 0);
		$this->Cell(25, 10, 'Almacen', 1, 1, 'C', 0);
	}

	// Pie de página
	function Footer()
	{
	    // Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Número de página
	    $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
	}
}

$sql = "SELECT empleados.cve_empleado, empleados.nombre, empleados.apellido, turnos.descripcion as turno_desc, inventarios.cve_paquete, inventarios.fecha_inventario, almacenes.descripcion FROM paquetes JOIN inventarios ON paquetes.cve_paquete = inventarios.cve_paquete JOIN almacenes ON almacenes.cve_almacen = inventarios.cve_almacen JOIN empleados ON empleados.cve_empleado = inventarios.cve_empleado JOIN turnos ON turnos.cve_turno = empleados.cve_turno WHERE almacenes.descripcion = 'Almacen 1' and turnos.descripcion='Diurno'";
$result=mysqli_query($conexion, $sql);

$pdf = new PDF();
$pdf->AliasNbPages(); 
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

while($row = $result->fetch_assoc()){
	$pdf->Cell(30, 10, $row['cve_empleado'], 1, 0, 'C', 0);
	$pdf->Cell(20, 10, $row['nombre'], 1, 0, 'C', 0);
	$pdf->Cell(25, 10, utf8_decode($row['apellido']), 1, 0, 'C', 0);
	$pdf->Cell(15, 10, $row['turno_desc'], 1, 0, 'C', 0);
	$pdf->Cell(30, 10, $row['cve_paquete'], 1, 0, 'C', 0);
	$pdf->Cell(40, 10, $row['fecha_inventario'], 1, 0, 'C', 0);
	$pdf->Cell(25, 10, $row['descripcion'], 1, 1, 'C', 0);
}

$pdf->SetXY(($pdf->GetPageWidth() - 210) / 2, $pdf->GetY());
$pdf->Output();
?>