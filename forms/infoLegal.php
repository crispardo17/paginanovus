<?php
include("conexion.php");

$curl = curl_init("https://www.postdata.gov.co/api/action/datastore/search.json?resource_id=015190b8-9115-4ff2-a4f6-04bf83a598b4&sort[anno]=desc&sort[mes]=desc&fields[]=smmlv&limit=1");
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
$smmlv = json_decode($result)->result->records[0]->smmlv;
$valorvis = 135 * $smmlv;
$procesos=[];
curl_close($curl);


if (isset($_POST['nombres'])) {

	$name_client        = $_REQUEST['nombres'];
	$apellidos_client   = $_REQUEST['apellidos'];
	$tipo_DocumentoId   = $_REQUEST['tipoDocumentoId'];
	$documento_Cliente  = $_REQUEST['documentoCliente'];
	$correo_Electronico = $_REQUEST['correoElectronico'];
	$celular1           = $_REQUEST['celular1'];

	$tabla              = $_POST['tabla'];
	$tabla              = json_decode($tabla);
	$pp                 = '';
	$contador           = 1;
	$existe             = '';

	foreach ($tabla as $row) {
		$contador           = 1;
		foreach ($row as $matri) {
			if ($contador == count($row, 1) && $row == end($tabla)) {
				$pp = $pp . $matri->matricula;
			} else {
				$pp = $pp . $matri->matricula . ',';
			}
			$contador++;
		}
	}
	// insert en la tabla cliente
	$sql = " SELECT * from cliente WHERE documentoCliente = '{$documento_Cliente}' ";
	$sth = $conn->query($sql);

	if ($sth->rowCount() > 0) {
		$update = " UPDATE cliente SET nombres = '{$name_client}', apellidos = '{$apellidos_client}', tipoDocumentoId = '{$tipo_DocumentoId}', correoElectronico = '{$correo_Electronico}', celular1 = '{$celular1}' WHERE documentoCliente = '{$documento_Cliente}' ";
		$conn->query($update);
	} else {
		$sql = " INSERT INTO cliente(nombres, apellidos, tipoDocumentoId, documentoCliente, correoElectronico, celular1) VALUES ('" . $name_client . "','" . $apellidos_client . "','" . $tipo_DocumentoId . "','" . $documento_Cliente . "','" . $correo_Electronico . "','" . $celular1 . "') ";
		$conn->query($sql);
	}

	//
	$sql = "SELECT * FROM legal.matricula where matriculaId in ('$pp')";
	$response = $conn->query($sql);
	$cantidad = $response->rowCount();
	$fecha = date('mdY');

	$sqlreg = "select *from registro";
	$responReg = $conn->query($sqlreg);
	$cantidadReg = $responReg->rowCount();


	if ($cantidad == 0) {


		$sql = " INSERT INTO registro(registrosId,fechaVenta,documentoCliente ) VALUES (" . ($cantidadReg + 1) . $fecha . ",now(),'$documento_Cliente') ";

		$conn->query($sql);
		$registroid = ($cantidadReg + 1) . $fecha;
	} else {
		$i = 1;

		foreach ($response->fetchAll() as $item) {
			if ($i == $cantidad) {
				$existe = $existe . $item['matriculaId'];
			} else {
				$existe = $existe . $item['matriculaId'] . ',';
			}
			$i = $i + 1;
		}
		print_r("Las matriculas $existe ya se encuentras registradas");
	}
}


//insert para la tabla matricula


if (isset($tabla)) {


	$procesoId = "";
	$auxproceso = [];
	$i = 0;
	//print_r($tabla);

	// print_r(count($tabla));
	foreach ($tabla as $row) {
		$sql = " INSERT INTO proceso( estadoId, registroId ) VALUES (1,'$registroid') ";
		$conn->query($sql);
		$procesoId = $conn->lastInsertId();
        
		foreach ($row as $matri) {
			$z=0;


			$matricula     	= $matri->matricula;
			$inmueble    	= $matri->inmueble;
			$tipoInmueble 	= $matri->tipoInmueble;
			$ciudad       	= $matri->ciudad;
			$comercial   	= $matri->comercial;
			$entidad      	= $matri->entidad;
			$proceso        = $matri->proceso;
			$tipoVivienda = 0;
			if ($matri->comercial < $valorvis) {
				$tipoVivienda = 1;
			} else {
				$tipoVivienda = 2;
			}
			$stmt = $conn->prepare('INSERT INTO matricula(matriculaId, direccion, avaluoComercial,      
						procesoEntidadBancaria, tipoInmuebleId, ciudadId, procesoId,tipoViviendaId)
						VALUES(:matricula, :inmueble, :comercial, :proceso,   
						:tipoInmueble, :ciudad, :procesoId,:tipoVivienda);');

			$stmt->execute([
				':matricula'              => $matricula,
				':inmueble' 			  => $inmueble,
				':comercial'			  => $comercial,
				':proceso'                => $proceso,
				':tipoInmueble'			  => $tipoInmueble,
				':ciudad'                 => $ciudad,
				':procesoId'              => $procesoId,
				':tipoVivienda'           => $tipoVivienda,
			]);
		
	     		
		}
		$i++;
		
	}
	$procesos= $tabla;


}




function factura($conn,$registroid,$procesos){
   $link="http://localhost:81/GRUPONOVUS%20PAGINA/GrupoNovus/ePayco/index.php?reg=".base64_encode($registroid);
	$cantidad=count($procesos);
	$detalle="numero de combos ".$cantidad." de las siguientes matriculas";
	foreach ($procesos as $row){
		foreach ($row as $matriculas){
			$detalle.="<br>".$matriculas->matricula;
			$entidad=$matriculas->entidad;

		}
		
	}

	
	$sql="SELECT * FROM legal.tarifador where entidadBancariaId=$entidad and  date(fechaInicio) < now() and  fechaFinal > now() and estado=1;";

	$response=$conn->query($sql);

    $tarifa=$response->fetchAll();
	$valor=$tarifa[0]["valorUnico"];
    

	$stmt = $conn->prepare('INSERT INTO factura(resgistroId,subTotal,fechaGeneraFactura,detalle,cantidad,total,linkPago)
		VALUES(:resgistroId, :subTotal, now(), :detalle,   
		:cantidad, :total, :linkPago);');

	$stmt->execute([
	':resgistroId'            => $registroid,
	':subTotal' 			  => $valor,
	':detalle'                => $detalle,
	':cantidad'			      => $cantidad,
	':total'                  => $valor,
	'linkPago'                => $link,

]);


}
factura($conn,$registroid,$procesos);
header("location: ../ePayco/index.php?reg=".base64_encode($registroid));