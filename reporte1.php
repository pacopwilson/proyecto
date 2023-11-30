<?php
include('../header.php');

require('../../inicio_sesion/conexion.php');
?>

<style>
    .table-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 20vh; /* O ajusta la altura según tus necesidades */
	}

	table {
	    width: 50%;
	    border: 1px solid #000;
	}

	th, td {
	    width: 25%;
	    text-align: center;
	    vertical-align: top;
	    border: 1px solid #000;
	    border-collapse: collapse;
	    padding: 0.3em;
	}

	caption {
	    padding: 0.3em;
	}

	th {
		background: #eee;
	}
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4 ">Reporte 1: Inventarios</h1>
    <ol class="breadcrumb mb-2">
    	<li class="breadcrumb-item active">Paquetes inventariados en el almacen 1 en el turno diurno y el empleado que lo realizo</li>
    </ol>
    <div class="text-end">
        <button class="boton-agregar" onclick="window.open('reporte1_PDF.php', '_blank')"><i class="fas fa-file-pdf"></i> Generar PDF</button>
    </div>
    <div class="table-container">
	    <table>
	        <tr style="font-weight: bold;">
	            <th>Clave empleado</th>
	            <th>Nombre</th>
	            <th>Apellido</th>
	            <th>Turno</th>
	            <th>Clave paquete</th>
	            <th>Fecha de inventario</th>
	            <th>Almacen</th>

	        </tr>

	        <?php 
	        $sql = "SELECT empleados.cve_empleado, empleados.nombre, empleados.apellido, turnos.descripcion, inventarios.cve_paquete, inventarios.fecha_inventario, almacenes.descripcion FROM paquetes JOIN inventarios ON paquetes.cve_paquete = inventarios.cve_paquete JOIN almacenes ON almacenes.cve_almacen = inventarios.cve_almacen JOIN empleados ON empleados.cve_empleado = inventarios.cve_empleado JOIN turnos ON turnos.cve_turno = empleados.cve_turno WHERE almacenes.descripcion = 'Almacen 1' and turnos.descripcion='Diurno'";
	        $result = mysqli_query($conexion, $sql);

	        while ($mostrar = mysqli_fetch_array($result)) {
	        ?>
	        <tr>
	            <td><?php echo $mostrar['cve_empleado'] ?></td>
	            <td><?php echo $mostrar['nombre'] ?></td>
	            <td><?php echo $mostrar['apellido'] ?></td>
	            <td><?php echo $mostrar['descripcion'] ?></td>
	            <td><?php echo $mostrar['cve_paquete'] ?></td>
	            <td><?php echo $mostrar['fecha_inventario'] ?></td>
	            <td><?php echo $mostrar['descripcion'] ?></td>
	        </tr>
	        <?php 
	        }
	        ?>
	    </table>
	</div>
</div>



<?php
include('../footer.php');
?>