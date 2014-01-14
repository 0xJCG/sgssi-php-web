/* Codigo JavaScript escrito usando la libreria jQuery. */
$(document).ready(function() { // Cuando el documento se carga, realiza las funciones siguientes.
	jQuery.validator.addMethod("comprobarContrasena", function(value, element) {
		return this.optional(element) || // Es una funcion opcional.
			   /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // Contiene solo estos caracteres, ademas de:
		       && /[a-z]/.test(value) // tener, al menos, una letra minuscula.
		       && /[A-Z]/.test(value) // tener, al menos, una letra mayuscula.
		       && /\d/.test(value) // tener, al menos, un numero.
		       && /[!@#$%*()_+^&}{:;?.]/.test(value) // tener, al menos, un simbolo.
	});
	$('#formularioRegistro').validate({ // Validar el formulario de registro. Usamos el id de HTML que le hemos puesto al formulario.
		submitHandler: function(form) { // Cuando pulsamos el boton de registrar y todo ha ido bien, se envia el formulario.
			//form.submit();
			enviarDatosRegistro(form, document.getElementById('pass1'), document.getElementById('pass2'));
		},
        rules: { // Reglas para validar el formulario.
	        'usuario': {
	        	required: true,
	        	minlength: 2,
	        	maxlength: 50,
	        },
	        'correo': {
	        	required: true,
	        	email: true,
	        	maxlength: 100,
	        },
	        'telefono': {
	        	required: true,
	        	digits: true,
	        	minlength: 9,
	        	maxlength: 9,
	        },
	        'cbancaria': {
	        	required: true,
	        	digits: true,
	        	minlength: 20,
	        	maxlength: 20,
	        },
	        'pass1': {
	        	required: true,
	        	comprobarContrasena: true,
	        	minlength: 8,
	        },
	        'pass2': {
	        	required: true,
	        	equalTo: "#pass1"
	        },
        },
	    messages: { // Los mensajes que se muestran cuando no se cumple alguna de las normal mencionada arriba.
	        'usuario': {
	        	required: 'Es obligatorio introducir un nombre de usuario.',
	        	minlength: 'Tiene que tener 2 caracteres como m&iacute;nimo.',
	        },
	        'correo': {
	        	required: 'Es obligatorio introducir un correo electr&oacute;nico.',
	        	email: 'El correo electr&oacute;nico ingresado no es correcto.',
	        },
	        'telefono': {
	        	required: 'Es obligatorio introducir un tel&eacute;fono de contacto.',
	        	digits: 'El tel&eacute;fono debe ser un n&uacute;mero de 9 cifras.',
	        	minlength: 'Tiene que tener 9 cifras.',
	        	maxlength: 'Tiene que tener 9 cifras.',
	        },
	        'cbancaria': {
	        	required: 'Es obligatorio introducir una cuenta bancaria.',
	        	digits: 'La tarjeta de cr&eacute;dito es un n&uacute;mero de 20 cifras.',
	        	minlength: 'Tiene que tener 20 cifras.',
	        	maxlength: 'Tiene que tener 20 cifras.',
	        },
	        'pass1': {
	        	required: 'Es obligatorio introducir una contrase&ntilde;a.',
	        	comprobarContrasena: 'La contrase&ntilde;a debe contener al menos un n&uacute;mero, una letra may&uacute;scula y un s&iacute;mbolo.',
	        	minlength: 'Tiene que tener 8 caracteres como m&iacute;nimo.',
	        },
	        'pass2': {
	        	required: 'Es obligatorio volver a introducir la contrase&ntilde;a.',
	        	equalTo: 'Las contrase&ntilde;as deben coincidir.',
	        },
	    },
    });
	$('#formularioPanel').validate({ // Validar el formulario del panel de usuario. Usamos el id de HTML que le hemos puesto al formulario.
		submitHandler: function(form) { // Cuando pulsamos el boton de modificar y todo ha ido bien, se envia el formulario.
			enviarDatosPanel(form, document.getElementById('pass'), document.getElementById('pass1'), document.getElementById('pass2'));
			//form.submit();
		},
        rules: { // Reglas para validar el formulario.
	        'correo': {
	        	required: true,
	        	email: true,
	        	maxlength: 100,
	        },
	        'telefono': {
	        	required: true,
	        	digits: true,
	        	minlength: 9,
	        	maxlength: 9,
	        },
	        'cbancaria': {
	        	required: false,
	        	digits: true,
	        	minlength: 20,
	        	maxlength: 20,
	        },
	        'pass': {
	        	required: true,
	        	minlength: 8,
	        },
	        'pass1': {
	        	required: false,
	        	comprobarContrasena: true,
	        	minlength: 8,
	        },
	        'pass2': {
	        	required: false,
	        	equalTo: "#pass1"
	        },
        },
	    messages: { // Los mensajes que se muestran cuando no se cumple alguna de las normal mencionada arriba.
	        'correo': {
	        	required: 'Es obligatorio introducir un correo electr&oacute;nico.',
	        	email: 'El correo electr&oacute;nico ingresado no es correcto.',
	        },
	        'telefono': {
	        	required: 'Es obligatorio introducir un tel&eacute;fono de contacto.',
	        	digits: 'El tel&eacute;fono debe ser un n&uacute;mero de 9 cifras.',
	        	minlength: 'Tiene que tener 9 cifras.',
	        	maxlength: 'Tiene que tener 9 cifras.',
	        },
	        'cbancaria': {
	        	digits: 'La tarjeta de cr&eacute;dito es un n&uacute;mero de 20 cifras.',
	        	minlength: 'Tiene que tener 20 cifras.',
	        	maxlength: 'Tiene que tener 20 cifras.',
	        },
	        'pass': {
	        	required: 'Es obligatorio introducir la contrase&ntilde;a para realizar cambios.',
	        	minlength: 'Tiene que tener 8 caracteres como m&iacute;nimo.',
	        },
	        'pass1': {
	        	required: 'Es obligatorio introducir una contrase&ntilde;a.',
	        	comprobarContrasena: 'La nueva contrase&ntilde;a debe contener al menos un n&uacute;mero, una letra may&uacute;scula y un s&iacute;mbolo.',
	        	minlength: 'Tiene que tener 8 caracteres como m&iacute;nimo.',
	        },
	        'pass2': {
	        	required: 'Es obligatorio volver a introducir la contrase&ntilde;a.',
	        	equalTo: 'Las contrase&ntilde;as deben coincidir.',
	        },
	    },
    });
	$('#formularioLogin').validate({ // Validar el formulario de login.
		submitHandler: function(form) { // Cuando pulsamos el boton de conectar y todo ha ido bien, se envia el formulario.
			//form.submit();
			enviarDatosLogin(form, document.getElementById('pass'));
		},
        rules: { // Reglas para validar el formulario.
	        'usuario': {
	        	required: true,
	        	minlength: 2,
	        	maxlength: 50,
	        },
	        'pass': {
	        	required: true,
	        	minlength: 8,
	        },
        },
	    messages: { // Los mensajes que se muestran cuando no se cumple alguna de las normal mencionada arriba.
	        'usuario': {
	        	required: 'Es obligatorio introducir un nombre de usuario.',
	        	minlength: 'Tiene que tener 2 caracteres como m&iacute;nimo.',
	        },
	        'pass': {
	        	required: 'Es obligatorio introducir una contrase&ntilde;a.',
	        	minlength: 'Tiene que tener 8 caracteres como m&iacute;nimo.',
	        },
	    },
    });
	$('#formularioMercado').validate({ // Validar el formulario de mercado.
		submitHandler: function(form) { // Cuando pulsamos el boton de enviar y todo ha ido bien, se envia el formulario.
			form.submit();
		},
        rules: { // Reglas para validar el formulario.
	        'titulo': {
	        	required: true,
	        	minlength: 5,
	        	maxlength: 50,
	        },
	        'descripcion': {
	        	required: true,
	        	minlength: 20,
	        	maxlength: 1000,
	        },
        },
	    messages: { // Los mensajes que se muestran cuando no se cumple alguna de las normal mencionadas arriba.
	        'titulo': {
	        	required: 'Es obligatorio introducir un t&iacute;tulo.',
	        	minlength: 'Tiene que tener 5 caracteres como m&iacute;nimo.',
	        },
	        'descripcion': {
	        	required: 'Es obligatorio introducir una descripci&oacute;n.',
	        	minlength: 'Tiene que tener 20 caracteres como m&iacute;nimo.',
	        },
	    },
    });
});

/*****************************************************************************************************/
/* Cuando haya que enviar una contrasena al servidor, la hasheamos antes de enviarla.                */
/* De esta forma, evitaremos que alguien escuchando la red pueda ver las contrasenas en texto plano. */
/*****************************************************************************************************/
function enviarDatosLogin(formulario, contrasena) {
	contrasena.value = hex_sha512(contrasena.value);
	formulario.submit(); // Enviamos el formulario.
}

function enviarDatosRegistro(formulario, contrasena1, contrasena2) {
	contrasena1.value = hex_sha512(contrasena1.value);
	contrasena2.value = hex_sha512(contrasena2.value);
	formulario.submit(); // Enviamos el formulario.
}

function enviarDatosPanel(formulario, contrasena1, contrasena2, contrasena3) {
	/* Siempre entrara la primera contrasena en esta funcion. La hasheamos para que no se vea por el POST en texto plano. */
	contrasena1.value = hex_sha512(contrasena1.value);
	
	/* Como no siempre metemos estas dos contrasenas en esta funcion, solo pasaremos el hash cuando las metamos. */
	if (contrasena2.value == "") {}
	else
		contrasena2.value = hex_sha512(contrasena2.value);
	
	if (contrasena3.value == "") {}
	else
		contrasena3.value = hex_sha512(contrasena3.value);
	
	formulario.submit(); // Enviamos el formulario.
}