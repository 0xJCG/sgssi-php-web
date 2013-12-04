function comprobarContrasenas(c1, c2) { // Compara las contraseñas.
	if (c1 != c2)
		return false;
	return true;
}

function validarCorreo(c) { // Mira si el correo tiene una estructura de válida.
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!expr.test(c))
        return false;
    return true;
}

/*function comprobarUsuario()
{
	var usuario = document.formulario.usermail.value;
	var esta = false;
	if(!usuario == "")
	{
		esta = $.ajax({
		type: "POST",
		url: "conexiones.php",
		data: {dato: "usuario"},
		success: comprobarUsuario(data)
			{
				alert(data);
			}
		});
	}
	if (esta == false)
	{
		alert("El usuario " + usuario + " ya esta ocupado.");
	}
}*/

function comprobarDatos() { // Comprueba los datos del formulario antes de hacer submit.
	var correo = document.formulario.correo.value;
	var contrasena1 = document.formulario.pass1.value;
	var contrasena2 = document.formulario.pass2.value;
	if (!validarCorreo(correo))
		document.getElementById("correovalidado").innerHTML = "Correo no v&aacute;lido."
	if (!comprobarContrasenas(contrasena1, contrasena2))
		document.getElementById("passvalidada").innerHTML = "Las contra&ntilde;as no coinciden."
	//else
		//document.formulario.submit();
	//comprobarUsuario();
}

function enviarDatos(formulario, contrasena) { // Creamos un nuevo elemento input para el formulario para enviar la contraseña hasheada.
	var c = document.createElement("input");
	c.name = "c";
	c.type = "hidden";
	c.value = hex_sha512(contrasena.value);
	formulario.appendChild(c);
	contrasena.value = "";
	formulario.submit();
}

function irRegistro() { // Carga otra página web.
	window.open('registro.php','_self')
}
