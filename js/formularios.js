/* Codigo JavaScript escrito usando la libreria jQuery. */
$(document).ready(function() { // Cuando el documento se carga, realiza las funciones siguientes.
	$('#formularioRegistro').validate({ // Validar el formulario de registro. Usamos el id de HTML que le hemos puesto al formulario.
		submitHandler: function(form) { // Cuando pulsamos el boton de registrar y todo ha ido bien, se envia el formulario.
			//form.submit();
			enviarDatos(form, document.getElementById('pass1'), document.getElementById('pass2'));
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
	        'pass1': {
	        	required: true,
	        	minlength: 6,
	        },
	        'pass2': {
	        	required: true,
	        	minlength: 6,
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
	        'pass1': {
	        	required: 'Es obligatorio introducir una contrase&ntilde;a.',
	        	minlength: 'Tiene que tener 6 caracteres como m&iacute;nimo.',
	        },
	        'pass2': {
	        	required: 'Es obligatorio volver a introducir la contrase&ntilde;a.',
	        	minlength: 'Tiene que tener 6 caracteres como m&iacute;nimo.',
	        	equalTo: 'Las contrase&ntilde;as deben coincidir.',
	        },
	    },
    });
	$('#formularioPanel').validate({ // Validar el formulario del panel de usuario. Usamos el id de HTML que le hemos puesto al formulario.
		submitHandler: function(form) { // Cuando pulsamos el boton de modificar y todo ha ido bien, se envia el formulario.
			enviarDatos(form, document.getElementById('pass'), document.getElementById('pass1'), document.getElementById('pass2'));
			//form.submit();
		},
        rules: { // Reglas para validar el formulario.
	        'correo': {
	        	required: true,
	        	email: true,
	        	maxlength: 100,
	        },
	        'pass': {
	        	required: true,
	        	minlength: 6,
	        },
	        'pass1': {
	        	required: false,
	        	minlength: 6,
	        },
	        'pass2': {
	        	required: false,
	        	minlength: 6,
	        	equalTo: "#pass1"
	        },
        },
	    messages: { // Los mensajes que se muestran cuando no se cumple alguna de las normal mencionada arriba.
	        'correo': {
	        	required: 'Es obligatorio introducir un correo electr&oacute;nico.',
	        	email: 'El correo electr&oacute;nico ingresado no es correcto.',
	        },
	        'pass': {
	        	required: 'Es obligatorio introducir la contrase&ntilde;a para realizar cambios.',
	        	minlength: 'Tiene que tener 6 caracteres como m&iacute;nimo.',
	        },
	        'pass1': {
	        	required: 'Es obligatorio introducir una contrase&ntilde;a.',
	        	minlength: 'Tiene que tener 6 caracteres como m&iacute;nimo.',
	        },
	        'pass2': {
	        	required: 'Es obligatorio volver a introducir la contrase&ntilde;a.',
	        	minlength: 'Tiene que tener 6 caracteres como m&iacute;nimo.',
	        	equalTo: 'Las contrase&ntilde;as deben coincidir.',
	        },
	    },
    });
	$('#formularioLogin').validate({ // Validar el formulario de login.
		submitHandler: function(form) { // Cuando pulsamos el boton de conectar y todo ha ido bien, se envia el formulario.
			//form.submit();
			enviarDatos(form, document.getElementById('pass'));
		},
        rules: { // Reglas para validar el formulario.
	        'usuario': {
	        	required: true,
	        	minlength: 2,
	        	maxlength: 50,
	        },
	        'pass': {
	        	required: true,
	        	minlength: 6,
	        },
        },
	    messages: { // Los mensajes que se muestran cuando no se cumple alguna de las normal mencionada arriba.
	        'usuario': {
	        	required: 'Es obligatorio introducir un nombre de usuario.',
	        	minlength: 'Tiene que tener 2 caracteres como m&iacute;nimo.',
	        },
	        'pass': {
	        	required: 'Es obligatorio introducir una contrase&ntilde;a.',
	        	minlength: 'Tiene que tener 6 caracteres como m&iacute;nimo.',
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

/* Cuando haya que enviar una contrasena al servidor, la hasheamos antes de enviarla y, como ya estan comprobadas, las otras se dejan vacias. */
function enviarDatos(formulario, contrasena1, contrasena2, contrasena3) {
	if(typeof(contrasena2)==='undefined') contrasena2 = "";
	if(typeof(contrasena2)==='undefined') contrasena3 = "";
	contrasena1.value = hex_sha512(contrasena1.value);
	contrasena2.value = hex_sha512(contrasena2.value);
	contrasena3.value = hex_sha512(contrasena3.value);
	formulario.submit();
}