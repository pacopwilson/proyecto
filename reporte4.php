<?php
include('../header.php');

require('../../inicio_sesion/conexion.php');
?>

<style>
    .table-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 28vh; /* O ajusta la altura según tus necesidades */
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
    <h1 class="mt-4 ">Reporte 4: Información de clientes</h1>
    <ol class="breadcrumb mb-2">
    	<li class="breadcrumb-item active">Información de los clientes que fueron atendidos el día 23-10-2023</li>
    </ol>
    <div class="text-end">
        <button class="boton-agregar" onclick="window.open('reporte4_PDF.php', '_blank')"><i class="fas fa-file-pdf"></i> Generar PDF</button>
    </div>
    <div class="table-container">
	    <table>
	        <tr style="font-weight: bold;">
	            <th>Nombre</th>
	            <th>Apellido</th>
	            <th>Ciudad</th>
	            <th>Estado</th>
	            <th>Teléfono</th>
	            <th>Paquetes entregados</th>
	            <th>Fecha</th>
	        </tr>

	        <?php 
	        $sql = "SELECT clientes.nombre, clientes.apellido, ciudades.nombre as ciudad_nombre, estados.nombre as estado_nombre, clientes.telefono, servicios.paquetes_entregados, servicios.fecha_servicio FROM estados JOIN ciudades ON estados.cve_estado = ciudades.cve_estado JOIN clientes ON ciudades.cve_ciudad = clientes.cve_ciudad JOIN servicios ON clientes.cve_cliente = servicios.cve_cliente WHERE servicios.fecha_servicio = '2023-10-23'";
	        $result = mysqli_query($conexion, $sql);

	        while ($mostrar = mysqli_fetch_array($result)) {
	        ?>
	        <tr>
	            <td><?php echo $mostrar['nombre'] ?></td>
	            <td><?php echo $mostrar['apellido'] ?></td>
	            <td><?php echo $mostrar['ciudad_nombre'] ?></td>
	            <td><?php echo $mostrar['estado_nombre'] ?></td>
	            <td><?php echo $mostrar['telefono'] ?></td>
	            <td><?php echo $mostrar['paquetes_entregados'] ?></td>}
	            <td><?php echo $mostrar['fecha_servicio'] ?></td>
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