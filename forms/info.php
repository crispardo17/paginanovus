<?php 

// $conexion = new mysqli("127.0.0.1", "gruponov_collector", "yRRnT7^eNQH_", "gruponov_leads");

$email_client = $_REQUEST['correo'];
$name_client = $_REQUEST['nombre'];

$email_novus = 'info@gruponovus.com.co';
$subject = 'Contacto por Wed Grupo Novus';
$body = $name_client . ' Solicita informacion por medio del formulario de la pagina de Grupo Novus Gruponovus.com.co, contestar a ' . $email_client;

$sql = "INSERT INTO info_gruponovus (nombres, correo ) VALUES ('$name_client','$email_client')";
$resultado = $conexion->query($sql);

include("./../index.html");	

if ($resultado === TRUE){
	
	$sendMail = mail($email_novus, "$subject", $body, "From: no-repy@gopass.com");
	
	
		if($sendMail){
			echo '<script>Swal.fire("Su mensaje ha sido enviado!");</script>';
		}else{
			echo '<script>Swal.fire({icon: "error",text: "Algo salió mal, el mensaje no pudo ser enviado"})</script>';
		}

	}else{
		echo "Error: " . $sql . "<br>" . $conexion->error;
	}

?>

<script>
	window.location.replace("https://gruponovus.com.co/preview/GrupoNovus");
</script>