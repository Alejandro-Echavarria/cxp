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

function fntValidCedula(pCedula) {
	
	let arrData = 0;

	let numero = pCedula
	let suma = 0;
	let residuo = 0;
	let modulo = 11;
	// Se almacenan los digitos de la cedula en variables
	let d1  = numero.substr(0,1);
	let d2  = numero.substr(1,1);
	let d3  = numero.substr(2,1);
	let d4  = numero.substr(3,1);
	let d5  = numero.substr(4,1);
	let d6  = numero.substr(5,1);
	let d7  = numero.substr(6,1);
	let d8  = numero.substr(7,1);
	let d9  = numero.substr(8,1);
	let d10 = numero.substr(9,1);
	let d11 = numero.substr(10,1);             
	// Se multiplica cada elemento de la cedula y se compara si excede los dos digitos
	let p1  = d1  * 1; if (p1  >= 10) p1  = parseInt(p1.toString().substr(0,1)) + parseInt(p1.toString().substr(1,1));
	let p2  = d2  * 2; if (p2  >= 10) p2  = parseInt(p2.toString().substr(0,1)) + parseInt(p2.toString().substr(1,1));
	let p3  = d3  * 1; if (p3  >= 10) p3  = parseInt(p3.toString().substr(0,1)) + parseInt(p3.toString().substr(1,1));
	let p4  = d4  * 2; if (p4  >= 10) p4  = parseInt(p4.toString().substr(0,1)) + parseInt(p4.toString().substr(1,1));
	let p5  = d5  * 1; if (p5  >= 10) p5  = parseInt(p5.toString().substr(0,1)) + parseInt(p5.toString().substr(1,1));
	let p6  = d6  * 2; if (p6  >= 10) p6  = parseInt(p6.toString().substr(0,1)) + parseInt(p6.toString().substr(1,1));
	let p7  = d7  * 1; if (p7  >= 10) p7  = parseInt(p7.toString().substr(0,1)) + parseInt(p7.toString().substr(1,1));
	let p8  = d8  * 2; if (p8  >= 10) p8  = parseInt(p8.toString().substr(0,1)) + parseInt(p8.toString().substr(1,1));
	let p9  = d9  * 1; if (p9  >= 10) p9  = parseInt(p9.toString().substr(0,1)) + parseInt(p9.toString().substr(1,1));
	let p10 = d10 * 2; if (p10 >= 10) p10 = parseInt(p10.toString().substr(0,1)) + parseInt(p10.toString().substr(1,1));
	modulo = 10;
	// Se suman los resultados   
	suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9 + p10;
	residuo = suma % modulo;
	// Si residuo=0, digito verificador=0, en caso contrario 10 - residuo 
	digitoVerificador = residuo==0 ? 0: modulo - residuo;
	// Se compara el elemento de la posicion 10 con el digito verificador
	if (digitoVerificador != d11){

		arrData = 0;
	}else{

		arrData = 1;
	};
	return arrData;
}

/* window indica cuando se cargue todo el documento, le agregamos un evento load el 
   cual ejecuta la funcion y todas las demas*/
window.addEventListener('load', function(){
	fntValidText();
	fntValidEmail();
	fntValidNumber();
}, false);

	