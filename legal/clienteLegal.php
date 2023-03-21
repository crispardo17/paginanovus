<?php
include("../forms/conexion.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/your-path-to-fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/jpg" href="https://i.ibb.co/gPhcmMd/logo-ojo-novus.png">
    <title>Grupo Novus | Legal</title>
    <link href=".././assets/css/style.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header">    
            <div class="header_logo"><a href="../"><img src="https://i.ibb.co/tJHD9tW/logo-gruponovus.png" alt=""></a>
            </div>
            <div class="header-buton"><span class="fa fa-bars fa-3x"></span></div>
        </div>
        <div class="navbar">
            <p class="indice"></p>
            <nav>
                <ul>
                    <li><a data-scroll href="./../about/" rel="noopener noreferrer">nosotros</a></li>
                    <li><a data-scroll href="./../empresarial/" rel="noopener noreferrer">Grupo Empresarial</a></li>
                    <li><a data-scroll href="./../noticias/" rel="noopener noreferrer">Noticias</a></li>
                    
                </ul>
            </nav>
        </div>
    </header>
    <div class="legal-cliente">
        <section class="legal-cliente-fondo">
            <div class="legals__titulo-cliente">
                <p>
                    <img class="icon-consulta" src="https://i.ibb.co/Hq1RRTf/Logo-Novus-Legal-09.png">&nbsp &nbsp<b>PROCESOS</b> EN ESTUDIO DE TÍTULO
                </p>
                <?php
                if (($_POST['numero-registro'])!= "") {
                $registro         = $_POST['numero-registro'];
                ?>
                
                    <div class="legal-grid-cliente">
                        <div class="cliente-f">
                            <label for="nombre">N° de Documento: <span id="documento"></span></label><br>
                            <label for="nombre">Nombre de Cliente: <span id="nom"></span></label>                                                       
                        </div>
                        <div class="cliente-f">
                            <label for="nombre">N° de Registro: <?="$registro"?></label>                                                    
                        </div>
                        <div class="cliente-f"> 
                             <?php
                                $proceso = busquedaRegistro($registro,$conn);
                                $j=0;
                                // print_r($proceso->fetchAll());die;
                                foreach($proceso as $row){
                                   $j++;
                                ?>   
                            <input type="hidden" class="doc" value="<?=$row["documentoCliente"]?>">
                            <input type="hidden" class="nombre" value="<?=$row["nombres"]." ".$row["apellidos"]?>">
                            <button type="button" class="salto">Proceso:<?=$row["procesoId"]?> &nbsp; Estado:<?=$row["estado"]?>  </button>
                              <div class="panel" id="tblSolicitud">
                                <form id="form-cliente" method="post" action="http://192.168.180.176/legal/update" enctype="multipart/form-data" onsubmit="guardar(event)" >
                                <input type="hidden" id="registro" name="registro" value="<?=base64_encode($registro)?>">    
                                <h4 for="nombre">Documentos Requeridos:</h4>
                                <table id="tblAgregar" name="tblAgregar" >
                                <thead>
                                  <th>N° de Matricula</th>
                                  <th>N° de Documento</th>
                                  <th>Tipo Documentacion</th>
                                  <th>Adjuntar</th>
                                </thead>
                                <tbody id="tblBodyAgregar" name="tblBodyAgregar">
                                <?php
                                $documentos1 = tablaDocumentacion1($row["procesoId"],$conn);
                                foreach($documentos1 as $fila){
                                ?>   
                                  <tr>
                                  <td><?=$fila["matriculaId"]?></td>
                                  <td><?=$fila["nombreDocumentacion"]?></td>
                                  <td><?=$fila["numeroDocumento"]?></td>
                                  <td>
                                    <input name="proceso[]" type="hidden" value="<?=$row["procesoId"]?>">
                                    <input name="id[]" type="hidden" value="<?=$fila["estudioTitulo_tipoDocumentacionId"]?>">
                                    <input id="file" aria-label="<?=$fila["estudioTitulo_tipoDocumentacionId"]?>"  name="docus[]" type="file">
                                  </td>
                                  </tr>
                                <?php
                                }
                                ?>  
                                </tbody>    
                                </table>
                                <h4 for="nombre">Documentos Requeridos:</h4>
                                <table id="tblAgregar" name="tblAgregar">
                                <thead>
                                  <th>Tipo documento</th>
                                  <th>Nombre de Documento</th>
                                  <th>Matricula</th>
                                  <th>Adjuntar</th>
                                </thead>
                                <tbody id="tblBodyAgregar" name="tblBodyAgregar">
                                <?php
                                $tablaDocumentacion2= tablaDocumentacion2($row["procesoId"],$conn);
                                $i=0;
                                foreach( $tablaDocumentacion2 as $fila){
                                    $i++;
                                ?>
                                  <tr>
                                  <td><?php if($fila["tipo"]=="OTRO"){ echo $fila["tipoOtro"] ;}else{ echo ($fila["tipo"]); }?></td>
                                  <td><?=$fila["documento"]?></td>
                                  <td><?=$fila["matriculaId"]?></td>
                                  <td>
                                  <input name="idreg[]"  type="hidden" value="<?=$fila["documentosRequeridosId"]?>">
                                    <input id="file" aria-label="<?=$fila["documentosRequeridosId"]?>" name="docs[]" type="file">
                                  </td>
                                  </tr>
                                <?php
                                }
                            
                                ?>
                                </tbody>
                              </table>
                              <br>
                              <button class="enviar" id="envioDocs" type="submit">Enviar Documentos</button>
                              <br>
                              <br>
                              </form>
                           <?php
                            }
                            if ($j == 0) {
                                
                            
                             header("Location:consultaEstudios.html?registro=error");
                            
                        }

                            ?>
                        </div>        
                        <div class="cliente-f">
                            <img class="icon-footer-solicitud" src="https://i.ibb.co/3myQvbW/Logo-Novus-Legal-17.png">                                                    
                        </div>
                <?php
                }elseif (($_POST['documento'] != "")) {
                    $documento         = $_POST['documento'];
                    
                ?>
                <div class="legal-grid-cliente2" id="tblSolicitud" name="tblSolicitud">
                            <table id="tblAgregar" name="tblAgregar" >
                                <thead>
                                  <th>N° de Registro</th>
                                  <th>N° de Documento</th>
                                  <th>Nombres</th>
                                  <th>Fecha Venta</th>
                                  <th>Acción</th>
                                </thead>
                                <tbody id="tblBodyAgregar" name="tblBodyAgregar">
                                <?php
                                $listRegistro = busquedaDocumento($documento,$conn);
                             $i=0;
                                    
                                foreach($listRegistro  as $row){
                                    $i++;
                                ?>
                                  <tr>
                                  <td><?=$row["registrosId"]?></td>
                                  <td><?=$row["documentoCliente"]?></td>
                                  <td><?=$row["nombres"]." ".$row["apellidos"]?></td>
                                  <td><?=$row["fechaVenta"]?></td>
                                  <td><form id="" method="post" action="clienteLegal.php" >
                                      <input type="hidden"  name="numero-registro" value="<?=$row["registrosId"]?>">
                                      <button id="consultar" type="submit">Consultar</button>
                                      </form>  
                                  </td>
                                  </tr>
                                <?php
                                }
                             if($i==0){
                                 header("Location:consultaEstudios.html?documento=error");
                               
                            }
                                ?>
                                </tbody>
                              </table>
                </div>
                <?php
                }
                ?>

            </div>
            </div>          
        </section>    
    </div>   
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="../app.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

var docu = document.getElementsByClassName("doc")[0].value;
document.getElementById("documento").innerHTML = docu;

var nombre = document.getElementsByClassName("nombre")[0].value;
document.getElementById("nom").innerHTML = nombre;


var acc = document.getElementsByClassName("salto");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    console.log(acc[i]);
    this.classList.toggle("active");
    var panel = this.nextElementSibling;

    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  },false);
}

function guardar(evt){
  evt.preventDefault()
  let data = new FormData();
  data.append("registro", $('#registro').val());
  for (i=0; i<$('input[type=file]').length; i++){
    if ($('input[type=file]')[i].name=="docus[]"){
      if ($('input[type=file]')[i].files[0] != undefined){
      data.append("docus[]", $('input[type=file]')[i].files[0]);
      data.append("id[]", $('input[type=file]')[i].ariaLabel);
      }  
    }else{
      if ($('input[type=file]')[i].files[0] !=undefined){
      data.append("docs[]", $('input[type=file]')[i].files[0]);
      data.append("idreg[]", $('input[type=file]')[i].ariaLabel);
      }  
    }
    
    console.log(data.getAll("docus[]"));
    console.log(data.getAll("id[]"));
    
    
  }
  
//   for (i=0; i<$('input[type=hidden]').length; i++){
//     if ($('input[type=hidden]')[i].name=="id[]"){
//       data.append("id[]", $('input[type=hidden]')[i].value);
//     }else if($('input[type=hidden]')[i].name=="idreg[]"){
//       data.append("idreg[]", $('input[type=hidden]')[i].value);
//     }
  
// }


$.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "http://192.168.180.176/legal/update",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
              if (data == "se han subido los archivos"){ 
            Swal.fire('Sus Documentos fueron enviados')
            setTimeout(function(){
              window.location.reload();
            },2000)
            }
            console.log(data);
            },
        });

      }

</script>


</body>

</html>