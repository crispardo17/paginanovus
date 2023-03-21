<?php
$servername = "175.0.10.62";
$username = "SA_LEGAL";
$password = "legal2021**";

try {
  $conn = new PDO("mysql:host=$servername;dbname=legal", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

function getTipoDocumento($conn)
{
  $sql = 'SELECT tipoDocumentoId, nombre FROM tipoDocumento';
  return $conn->query($sql);
}

function getTipoInmueble($conn)
{
  $sql = 'SELECT tipoInmuebleId, nombre FROM tipoinmueble';
  return $conn->query($sql);
}

function getTipoCiudad($conn)
{
  $sql = 'SELECT ciudadId, nombre FROM ciudad';
  return $conn->query($sql);
}

function getEntidad($conn)
{
  $sql = 'SELECT entidadBancariaId, nombre FROM entidadbancaria';
  return $conn->query($sql);
}

function busquedaRegistro($registro, $conn)
{
  $sql = 'SELECT p.procesoId, r.registrosId, c.documentoCliente, c.nombres, c.apellidos, e.nombre as estado, r.fechaVenta  
     FROM legal.proceso p, registro r, cliente c, estado e 
     where r.registrosId = p.registroId and e.estadoId = p.estadoId 
     and r.documentoCliente = c.documentoCliente and (r.registrosId = (' . $registro . '));';
  return $conn->query($sql);
}
function busquedaDocumento($documento, $conn)
{
  $sql = 'SELECT distinct(registrosId), c.documentoCliente, c.nombres, c.apellidos, r.fechaVenta 
  FROM legal.registro r, cliente c
  where r.documentoCliente = c.documentoCliente and (c.documentoCliente = (' . $documento . '));';
  return $conn->query($sql);
}
function tablaDocumentacion1($proceso, $conn)
{
  $sql = 'SELECT m.matriculaId, t.nombre nombreDocumentacion, et.numeroDocumento, et.estudioTitulo_tipoDocumentacionId
  FROM proceso p, matricula m, gestionabogado ga, 
  estudiotitulo e, estudiotitulo_tipodocumentacion et, tipodocumentacion t
  WHERE p.procesoId = m.procesoId and m.matriculaId = ga.matriculaId
  and e.gestionAbogadoId = ga.gestionAbogadoId and e.estudioTituloId = et.estudioTituloId 
  and et.tipoDocumentacionId = t.tipoDocumentacionId
  and et.estudioTitulo_tipoDocumentacionId not in (select if (ISNULL (a.estudioTitulo_tipoDocumentacionId),0, a.estudioTitulo_tipoDocumentacionId) from archivoscargados a)
  and (p.procesoId = (' . $proceso . '))';
  return $conn->query($sql);
}

function tablaDocumentacion2($proceso, $conn)
{
  $sql = 'SELECT docR.documentosRequeridosId, tipo.nombre as tipo,docR.tipoOtro,docR.documento, ga.matriculaId
  FROM documentosrequeridos  docR, tipodocumentacion  tipo,gestionabogado ga, matricula m, proceso p
   where docR.tipoDocumentacionId= tipo.tipoDocumentacionId and ga.gestionAbogadoId= docR.gestionAbogadoId
   and ga.matriculaId=m.matriculaId and p.procesoId = m.procesoId 
   and docR.documentosRequeridosId
   not in (select if (ISNULL (a.documentosRequeridosId),0, a.documentosRequeridosId) from archivoscargados a )
   and (p.procesoId = (' . $proceso . '))';
  return $conn->query($sql);
}


function epayco($conn, $registroId)
{  
  $sql = 'SELECT registro.registrosId, cliente.*, tipodocumento.abreviaturaNovus AS tipodocumento
  FROM
  registro,
  cliente,
  tipodocumento
  WHERE
  registro.documentoCliente = cliente.documentoCliente
  AND tipodocumento.tipoDocumentoId = cliente.tipoDocumentoId
  AND registrosId =' . $registroId . ';';

  return $conn->query($sql);
}

function Obtenerfactura($conn, $registroId){
  $sql="SELECT * FROM legal.factura where resgistroId=".$registroId;

  return $conn->query($sql);

}

function Obtenerproceso($conn,$registroId){
  $sql="SELECT * FROM legal.proceso where registroId='".$registroId."'";

  return $conn->query($sql);
}


function Obtenertransaccion($conn,$registroId){

  $sql="SELECT * FROM transaccion, factura where transaccion.facturaId= factura.facturaId and transaccion.estado=1 and factura.resgistroId='".$registroId."';";

  return $conn->query($sql);

}

?>
<!-- 
SA_LEGAL
legal2021**
175.0.10.62 -->