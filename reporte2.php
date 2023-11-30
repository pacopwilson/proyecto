<?php
include('../header.php');

require('../../inicio_sesion/conexion.php');
?>

<style>
    .table-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 19vh; /* O ajusta la altura según tus necesidades */
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
    <h1 class="mt-4 ">Reporte 2: Sesiones de trabajo</h1>
    <ol class="breadcrumb mb-2">
    	<li class="breadcrumb-item active">Información completa de la sesión de trabajo de la fecha 20-11-2023</li>
    </ol>
    <div class="text-end">
        <button class="boton-agregar" onclick="window.open('reporte2_PDF.php', '_blank')"><i class="fas fa-file-pdf"></i> Generar PDF</button>
    </div>
    <div class="table-container">
	    <table>
	        <tr style="font-weight: bold;">
	            <th>Clave empleado</th>
	            <th>Nombre</th>
	            <th>Apellido</th>
	            <th>Turno</th>
	            <th>Hora de entrada</th>
	            <th>Hora de salida</th>
	            <th>Clave banda transportadora</th>
	        </tr>

	        <?php 
	        $sql = "SELECT sesion_trabajo.cve_empleado, empleados.nombre, empleados.apellido, turnos.descripcion, sesion_trabajo.hora_inicio, sesion_trabajo.hora_salida, sesion_trabajo.cve_bandaT FROM bandas_transportadoras JOIN sesion_trabajo ON sesion_trabajo.cve_bandaT = bandas_transportadoras.cve_bandaT JOIN empleados ON empleados.cve_empleado = sesion_trabajo.cve_empleado JOIN turnos on turnos.cve_turno = empleados.cve_turno WHERE sesion_trabajo.fecha = '2023-11-20'";
	        $result = mysqli_query($conexion, $sql);

	        while ($mostrar = mysqli_fetch_array($result)) {
	        ?>
	        <tr>
	            <td><?php echo $mostrar['cve_empleado'] ?></td>
	            <td><?php echo $mostrar['nombre'] ?></td>
	            <td><?php echo $mostrar['apellido'] ?></td>
	            <td><?php echo $mostrar['descripcion'] ?></td>
	            <td><?php echo $mostrar['hora_inicio'] ?></td>
	            <td><?php echo $mostrar['hora_salida'] ?></td>
	            <td><?php echo $mostrar['cve_bandaT'] ?></td>
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