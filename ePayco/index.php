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
                    <li><a data-scroll href="#contacto-gruponovus" rel="noopener noreferrer">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>
<div class="legal-epayco">
  <section class="legal-epayco-fondo">
   <div class="legals__titulo-solicitud">
   <p>
       <img class="icon-solicitud" src="https://i.ibb.co/Hq1RRTf/Logo-Novus-Legal-09.png">&nbsp &nbsp<b>EPAYCO</b> ESTUDIO DE TÍTULO
    </p>
      <?php
      include_once('./Controller_ePayco.php');
      ?>
            <?php
            $transaccion=Obtenertransaccion($conn,$reg);
              
            if ($transaccion->rowCount()!=0){
              ?>
              <div class="legal-grid-epayco">
              <h1>transaccion realizada</h1>
              </div>
           <?php
            }else{
            //Genera el token
            $token = getTokenePayco();
            //Consulta bancos con pse
            $responseBank = getBanks($token);
            if($responseBank->success){
            ?>
            <form id="form-epayco" action="./Controller_ePayco.php?reg=<?=base64_encode($reg)?>" method="POST">
            <div class="legal-grid-epayco">
              <div class="epayco-f" >
              <label class="titulo">Seleccionar el método de pago:</label>
              </div>
              <div class="epayco-f">
              <label class="pse" for="">Pago Pse</label>
              <input type="radio" name="tipoPago" id="pse" value="pse">
              </div>
              <div class="epayco-f">
              <label class="tarjeta" for="">Pago tarjeta</label>
              <input type="radio" name="tipoPago" id="tarjeta" value="tarjeta">
              </div>
                <div class="epayco-f" id="pagoPse"> 
                <label class="banco">Bancos:</label>
                <select class="form-select" name="bancoId" id="bancoId">
                  <?php 
                  foreach($responseBank->data as $bank){         
                  ?>

                  <option value="<?php echo $bank->bankCode ?>"><?php echo utf8_encode ($bank->bankName) ?></option>

                  <?php
                  }
                  ?>
                </select>
                <?php
                }
                ?>
                </div>
                <div class="epayco-f" id="pagoCard">
                <label for="documento">Nombre en la tarjeta:</label>
                <input type="text" id="nomTarjeta" name="nomTarjeta">  
                <label for="documento">Número de tarjeta:</label>
                <input type="text" id="numTarjeta" name="numTarjeta">
                <label for="documento">Codigo de Seguridad CVC:</label>
                <input type="text" id="cvc" name="cvc">
                <label for="documento">Fecha de expiración:</label>
                <input type="text" id="expiracionMes" name="expiracionMes" >
                <input type="text" id="expiracionAnno" name="expiracionAnno">
                <label for="documento">Número de Cuotas:</label>
                <select class="form-select" name="cuotas" id="cuotas">
                <?php 
                  for ($i=1; $i<37; $i++){
                    echo "<option>". $i ."</option>";
                  }           
                  ?>
                </select>  
                </div>
              <div class="epayco-f">
              <button name="btnEnviar" id="btnEnviar" type="submit" >Enviar</button>
              </div>
            </div>
        </form>
        <?php }?>
   </div>  
  </section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$('input[type=radio]').change(ocultar);  
function ocultar(){
  var radio = $(this).attr("id");
  if (radio == "pse"){
    $('#nomTarjeta').attr("required",false);
    $('#numTarjeta').attr("required",false);
    $('#cvc').attr("required",false);
    $('#expiracionMes').attr("required",false);
    $('#expiracionAnno').attr("required",false);
    $('#cuotas').attr("required",false);
    $('#pagoPse').show();
    $('#pagoCard').hide();

  }else{
    $('#nomTarjeta').attr("required",true);
    $('#numTarjeta').attr("required",true);
    $('#cvc').attr("required",true);
    $('#expiracionMes').attr("required",true);
    $('#expiracionAnno').attr("required",true);
    $('#cuotas').attr("required",true);
    $('#pagoPse').hide();
    $('#pagoCard').show();
  }

}
$('#pagoPse').hide();
$('#pagoCard').hide();
</script>    
</body>

</html>