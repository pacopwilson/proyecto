<?php
include('../header.php');

require('../../inicio_sesion/conexion.php');
?>

<style>
    .table-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 60vh; /* O ajusta la altura según tus necesidades */
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
    <h1 class="mt-4 ">Reporte 3: Trabajadores de Recursos Humanos</h1>
    <ol class="breadcrumb mb-2">
    	<li class="breadcrumb-item active">Trabajadores del turno vespertino del área de recursos humanos</li>
    </ol>
    <div class="text-end">
        <button class="boton-agregar" onclick="window.open('reporte3_PDF.php', '_blank')"><i class="fas fa-file-pdf"></i> Generar PDF</button>
    </div>
    <div class="table-container">
	    <table>
	        <tr style="font-weight: bold;">
	            <th>Clave empleado</th>
	            <th>Nombre</th>
	            <th>Apellido</th>
	            <th>Área</th>
	            <th>Puesto</th>
	            <th>Turno</th>
	        </tr>

	        <?php 
	        $sql = "SELECT empleados.cve_empleado, empleados.nombre, empleados.apellido, areas.nombre as area_nombre, puestos.descripcion as puesto, turnos.descripcion as turno FROM areas JOIN puestos ON areas.cve_area = puestos.cve_area JOIN empleados ON puestos.cve_puesto = empleados.cve_puesto JOIN turnos on turnos.cve_turno = empleados.cve_turno WHERE areas.nombre = 'Recursos Humanos' and turnos.descripcion = 'Vespertino'";
	        $result = mysqli_query($conexion, $sql);

	        while ($mostrar = mysqli_fetch_array($result)) {
	        ?>
	        <tr>
	            <td><?php echo $mostrar['cve_empleado'] ?></td>
	            <td><?php echo $mostrar['nombre'] ?></td>
	            <td><?php echo $mostrar['apellido'] ?></td>
	            <td><?php echo $mostrar['area_nombre'] ?></td>
	            <td><?php echo $mostrar['puesto'] ?></td>
	            <td><?php echo $mostrar['turno'] ?></td>
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