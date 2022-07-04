function controlTag(e) {/* Con la funcion controlTag bloqueamos todas las teclas 
							y solo vamos a permitir el ingreso de numeros
						*/
	
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8) return true;
	else if (tecla==0 || tecla==9) return true;
	patron = /[0-9\s]/;
	n = String.fromCharCode(tecla);
	return patron.test(n);
}

/**
 * * **function**: testText
 * * **parameters**: txtString
 * * **returns**: true or false
 * * **description**: test if the string is only letters and spaces
 * @param txtString - The string to be tested.
 * @returns a boolean value.
 */
function testText(txtString){

    var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/);
    if(stringText.test(txtString)){
        return true;
    }else{
        return false;
    }
}

/**
 * The function testEntero() takes a string as an argument and returns true if the string is a number
 * and false if it is not
 * @param intCant - The value you want to test.
 * @returns a boolean value.
 */
function testEntero(intCant) {
	
	var intCantidad = new RegExp(/^([0-9])*$/);
	if (intCantidad.test(intCant)) {

		return true;
	}else{
		return false;
	}
}

/**
 * The function fntEmailValidate(email) takes a string variable email and checks to see if it is a
 * valid email address. 
 * 
 * If it is not a valid email address, the function returns false. 
 * 
 * If it is a valid email address, the function returns true. 
 * 
 * The function uses a regular expression to check the validity of the email address. 
 * 
 * The regular expression is: 
 * 
 * ^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$
 * 
 * The regular expression is a combination of the following: 
 * 
 * ^ - This is the beginning of the string. 
 * 
 * ([a-zA-Z0-9_.+-])+ - This is a group of one or more of the following
 * @param email - The email address to validate.
 * @returns a boolean value.
 */
function fntEmailValidate(email) {
	
	var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
	if (stringEmail.test(email) == false) {
		return false;
	}else{
		return true;
	}
}

function fntValidText() {
	
	//Nos dirigimos a todos los elementos que tengan la clase validText
	let validText = document.querySelectorAll(".validText");
	//Recorremos todos los elementos pasando como parametro la variable validText
	validText.forEach(function(validText){
		/*Agregamos el evento keyup que quiere decir que cuando terminemos de precionar la tecla ejecutaremos 
		  La funcion*/
		validText.addEventListener('keyup', function(){
			//Obtenemos el valor escrito
			let inputValue = this.value;
			//Si lo que le pasamos a la funcion testText es falso, agregamos la siguiente clase
			if (!testText(inputValue)) {

				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}
		});
	});
}

function fntValidNumber() {

	//Buscamos todos loe elemntos con esta clase
	let validNumber = document.querySelectorAll(".validNumber");
	//Para cada elemento con esta clase le agregamos una funcion, pasando como parametro la variable declarada
	validNumber.forEach(function(validNumber){
		//A la variable declarada y obtenida por parametro le agregamos un evento
		validNumber.addEventListener('keyup', function(){
			//Obtenemos lo que contenga el campo
			let inputValue = this.value;
			/*Hacemos la validacion usando la funcion testEntero y pasnando como parametro lo que tengamos
			  en la variable inputValue,indicando que si esta funcion nos devuelve false nos agregue la clase is-invalid */
			if (!testEntero(inputValue)) {

				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}
		})
	});
}


function fntValidEmail() {

	let validEmail = document.querySelectorAll(".validEmail");
	validEmail.forEach(function(validEmail){
		validEmail.addEventListener('keyup', function(){
			let inputValue = this.value;
			if (!fntEmailValidate(inputValue)) {

				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}
		});
	});
}

/* window indica cuando se cargue todo el documento, le agregamos un evento load el 
   cual ejecuta la funcion y todas las demas*/
window.addEventListener('load', function(){
	fntValidText();
	fntValidEmail();
	fntValidNumber();
}, false);

	