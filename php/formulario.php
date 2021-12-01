<?php
$error = '';

//VALIDA EL CAMPO NOMBRE
if (empty(trim($_POST['nombre']))) {
    $error .= 'El campo nombre es requerido. </br>';
} else {
    $nombre = trim($_POST['nombre']);
    $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
}

//VALIDA EL CAMPO EMAIL
if (empty(trim($_POST['email']))) {
    $error .= 'El campo email es requerido. </br>';
} else {
    $email = trim($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error .= 'El email no es válido. </br>';
    } else {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    }
}

//VALIDA EL CAMPO TELEFONO
if (empty(trim($_POST['telefono']))) {
    $error .= 'El campo telefono es requerido. </br>';
} else {
    $telefono = trim($_POST['telefono']);
    if (!filter_var($telefono, FILTER_VALIDATE_INT)) {
        $error .= 'El telefono no es válido. </br>';
    } else {
        if(strlen($telefono) == 9){
            $telefono = filter_var($telefono, FILTER_SANITIZE_NUMBER_INT);
        }else{
            $error .= 'El telefono no es válido. </br>';
        }
    }
}

//VALIDA EL CAMPO CENTRO_MEDICO
if (empty(trim($_POST['centroMedico']))) {
    $error .= 'El campo Centro Medico es requerido. </br>';
} else {
    $centroMedico = trim($_POST['centroMedico']);
    $centroMedico = filter_var($centroMedico, FILTER_SANITIZE_STRING);
    if($centroMedico != 'Las heras, Los Andes' && $centroMedico != 'Merced, San Felipe' && $centroMedico != 'Chicureo'){
        $error .= 'Centro Medico inválido. </br>';
    }
}

//VALIDA EL CAMPO MENSAJE
if (empty(trim($_POST['mensaje']))) {
    $error .= 'El campo mensaje es requerido. </br>';
} else {
    $mensaje = trim($_POST['mensaje']);
    $mensaje = filter_var($mensaje, FILTER_SANITIZE_STRING);
}

if($error == ''){
    //CABECERA QUE EVITA QUE EL CORREO LLEGUE A SPAM.
    $headers = "From: $email\r\n";
    $headers .= "X-Mailer: PHP5\n";
    $headers .= 'MIME-Version: 1.0'."\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

    //DESTINATARIO DEL MENSAJE
    $enviarA = 'contacto@oftalmoysalud.cl';

    //ASUNTO DEL MENSAJE
    $asunto = 'Solicitud de contacto para OftalmoSalud: '.$centroMedico;

    //CUERPO DEL MENSAJE
    $cuerpo .= "<b>Nombre: </b>".$nombre."<br>";
    $cuerpo .= "<b>Email: </b>".$email."<br>";
    $cuerpo .= "<b>Telefono: </b>".$telefono."<br>";
    $cuerpo .= "<b>Centro_Medico: </b>".$centroMedico."<br>";
    $cuerpo .= "<b>Mensaje: </b>".$mensaje;

    //ENVIAR CORREO ELECTRONICO Y LA RESPUESTA LA ALMACENA EN UNA VARIABLE
    $success = mail($enviarA, $asunto, $cuerpo, $headers);
    echo 'ok';
}else{
    echo $error;
}
?>