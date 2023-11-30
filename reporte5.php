<?php
include('../header.php');

require('../../inicio_sesion/conexion.php');
?>

<style>
    .table-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 46vh; /* O ajusta la altura según tus necesidades */
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
    <h1 class="mt-4 ">Reporte 5: Mantenimientos realizados</h1>
    <ol class="breadcrumb mb-2">
    	<li class="breadcrumb-item active">Información general de todos los mantenimientos realizados</li>
    </ol>
    <div class="text-end">
        <button class="boton-agregar" onclick="window.open('reporte5_PDF.php', '_blank')"><i class="fas fa-file-pdf"></i> Generar PDF</button>
    </div>
    <div class="table-container">
	    <table>
	        <tr style="font-weight: bold;">
	            <th>Clave empleado</th>
	            <th>Nombre</th>
	            <th>Apellido</th>
	            <th>Puesto</th>
	            <th>Fecha</th>
	            <th>Hora de mantenimiento</th>
	            <th>Clave banda transportadora</th>
	            <th>Incidencia</th>
	            <th>Solución</th>
	        </tr>

	        <?php 
	        $sql = "SELECT empleados.cve_empleado, empleados.nombre, empleados.apellido, puestos.descripcion, mantenimientos.fecha_inicio, mantenimientos.hora_inicio,bandas_transportadoras.cve_bandaT, mantenimientos.incidencia, mantenimientos.solucion FROM puestos JOIN empleados ON puestos.cve_puesto = empleados.cve_puesto JOIN mantenimientos ON empleados.cve_empleado = mantenimientos.cve_empleado JOIN bandas_transportadoras ON bandas_transportadoras.cve_bandaT = mantenimientos.cve_bandaT";
	        $result = mysqli_query($conexion, $sql);

	        while ($mostrar = mysqli_fetch_array($result)) {
	        ?>
	        <tr>
	            <td><?php echo $mostrar['cve_empleado'] ?></td>
	            <td><?php echo $mostrar['nombre'] ?></td>
	            <td><?php echo $mostrar['apellido'] ?></td>
	            <td><?php echo $mostrar['descripcion'] ?></td>
	            <td><?php echo $mostrar['fecha_inicio'] ?></td>
	            <td><?php echo $mostrar['hora_inicio'] ?></td>}
	            <td><?php echo $mostrar['cve_bandaT'] ?></td>
	            <td><?php echo $mostrar['incidencia'] ?></td>
	            <td><?php echo $mostrar['solucion'] ?></td>
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