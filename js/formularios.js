/* Codigo JavaScript escrito usando la libreria jQuery. */
$(document).ready(function() { // Cuando el documento se carga, realiza las funciones siguientes.
	$('#formularioRegistro').validate({ // Validar el formulario de registro. Usamos el id de HTML que le hemos puesto al formulario.
		submitHandler: function(form) { // Cuando pulsamos el boton de registrar y todo ha ido bien, se envia el formulario.
			enviarDatos(form, document.getElementById('pass'));
			//form.submit();
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
	        /*'pass2': {
	        	required: true,
	        	minlength: 6,
	        	equalTo: "#pass1"
	        },*/
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
	        /*'pass2': {
	        	required: 'Es obligatorio volver a introducir la contrase&ntilde;a.',
	        	minlength: 'Tiene que tener 6 caracteres como m&iacute;nimo.',
	        	equalTo: 'Las contrase&ntilde;as deben coincidir.',
	        },*/
	    },
    });
	$('#formularioPanel').validate({ // Validar el formulario del panel de usuario. Usamos el id de HTML que le hemos puesto al formulario.
		submitHandler: function(form) { // Cuando pulsamos el boton de modificar y todo ha ido bien, se envia el formulario.
			enviarDatos(form, document.getElementById('pass'));
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
	        /*'pass2': {
	        	required: true,
	        	minlength: 6,
	        	equalTo: "#pass1"
	        },*/
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
	        /*'pass2': {
	        	required: 'Es obligatorio volver a introducir la contrase&ntilde;a.',
	        	minlength: 'Tiene que tener 6 caracteres como m&iacute;nimo.',
	        	equalTo: 'Las contrase&ntilde;as deben coincidir.',
	        },*/
	    },
    });
	$('#formularioLogin').validate({ // Validar el formulario de login.
		submitHandler: function(form) { // Cuando pulsamos el boton de conectar y todo ha ido bien, se envia el formulario.
			form.submit();
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
});

function enviarDatos(formulario, contrasena1, contrasena2 = "") { // Creamos un nuevo elemento input para el formulario para enviar la contraseña hasheada.
	contrasena1.value = hex_sha512(contrasena1.value);
	contrasena2.value = "";
	formulario.submit();
}