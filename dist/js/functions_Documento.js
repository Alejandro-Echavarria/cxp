const modalNombreControlador = "#" + controlador;
const tablaNombreControlador = "#tabla_" + controlador;
var DataTableAc;

const swalCustom = Swal.mixin({
  customClass: {
    confirmButton: 'btn colorBlue-boton fw-bold m-1',
    cancelButton: 'btn colorDark-boton fw-bold'
  },
  buttonsStyling: false
})

$(document).ready(function () {

  DataTableAc = $(tablaNombreControlador).dataTable({
    language: {
      infoEmpty: "Mostrando del 0 al 0 de un total de 0 registros",
      info: "Mostrando del _START_ al _END_ de _TOTAL_ registros",
      infoFiltered: "",
      processing: "Cargando",
      loadingRecords: "Cargando datos ...",
      emptyTable: "No hay datos registrados para mostrar en la tabla.",
      paginate: {
        first: "Primero",
        last: "Último",
        next: '<i class="fa-solid fa-right-long"></i>',
        previous: '<i class="fa-solid fa-left-long"></i>',
      },
    },
    //"processing":true,
    //"bServerSide":true,
    responsive: true,
    paging: true,
    ajax: {
      url: base_url + "/" + controlador + "/getrecordset",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "monto" },
      { data: "nombre" },
      { data: "factura_id" },
      { data: "estado" },
      { data: "options" },
    ]
  });

  var oTable = $(tablaNombreControlador).DataTable();

  $("#txtBuscar").keyup(function () {
    $(tablaNombreControlador).dataTable().fnFilter(this.value);
  });

  $("#selectEntries").val(oTable.page.len());
  $("#selectEntries").change(function () {
    oTable.page.len($(this).val()).draw();
  });

  /* Setting the number of page numbers to be displayed in the pagination bar. */
  $.fn.DataTable.ext.pager.numbers_length = 5;

  jQuery(".dataTables_info").appendTo(jQuery("#numbers_numbers"));
  jQuery(".dataTables_paginate").appendTo(jQuery("#pagination_pagination"));

  // Validations and information manangement of the form
  const form = document.querySelector("#form" + controlador + "");

  form.onsubmit = function (e) {
    
    e.preventDefault();

    let intMonto = document.querySelector("#monto").value;
    let intFactura = document.querySelector("#factura").value;
    let intProveedor = document.querySelector("#proveedor").value;

    if (intMonto === "" || intFactura === "" || intProveedor === "") {
      swalCustom.fire({
        icon: "error",
        title: "Error",
        text: "Todos los campos son obligatorios",
        confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
        confirmButtonColor: "#aea322",
      });

      return false;
    }

    //Nos dirigimos a todos los elementos cone esta clase
    let elementsValid = document.getElementsByClassName("valid");
    //Iteramos con cada elemento
    for (let i = 0; i < elementsValid.length; i++) {
      /*Indicamos que si elementsValid en la posicion que se encuentre contiene la clase is-invalid 
      entonces muestra la alerta*/
      if (elementsValid[i].classList.contains('is-invalid')) {

        swalCustom.fire({
            icon: 'error',
            title: 'Atención',
            text: 'Por favor verifique los campos en rojo',
            confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
            confirmButtonColor: '#aea322'
          });

        return false;
      }
    }

    let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/" + controlador + "/store";
    let formData = new FormData(form);
    request.open("POST", ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        const objData = JSON.parse(request.responseText);
        if (objData.status) {
          $(modalNombreControlador).modal("hide");
          form.reset();
          swalCustom.fire({
            icon: "success",
            title: "Documentos",
            text: objData.msg,
            confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
            confirmButtonColor: "#aea322",
          });
          DataTableAc.api().ajax.reload();
        }else {

          let errorMonto = objData.validations.hasOwnProperty('monto') ? objData.validations.monto : "" ;

          swalCustom.fire({
            icon: "error",
            title: "Error",
            text: objData.validations ? errorMonto : objData.msg,
            confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
            confirmButtonColor: "#aea322",
          });
        }
      }
    };
  };

  // Form for edit document balance
  const formBlanace = document.querySelector("#form" + controlador + "edit");

  formBlanace.onsubmit = function (e) {
    
    e.preventDefault();

    let id = document.querySelector("#idEdit").value;
    let intMonto = document.querySelector("#monto-pagar").value;

    if (id === "" || intMonto === "") {
      swalCustom.fire({
        icon: "error",
        title: "Error",
        text: "Todos los campos son obligatorios",
        confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
        confirmButtonColor: "#aea322",
      });

      return false;
    }

    //Nos dirigimos a todos los elementos cone esta clase
    let elementsValid = document.getElementsByClassName("valid");
    //Iteramos con cada elemento
    for (let i = 0; i < elementsValid.length; i++) {
      /*Indicamos que si elementsValid en la posicion que se encuentre contiene la clase is-invalid 
      entonces muestra la alerta*/
      if (elementsValid[i].classList.contains('is-invalid')) {

        swalCustom.fire({
            icon: 'error',
            title: 'Atención',
            text: 'Por favor verifique los campos en rojo',
            confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
            confirmButtonColor: '#aea322'
          });

        return false;
      }
    }

    let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    let ajaxUrl = base_url + "/" + controlador + "/editbalance";
    let formData = new FormData(formBlanace);
    request.open("POST", ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        const objData = JSON.parse(request.responseText);
        if (objData.status) {
          $(modalNombreControlador + 'edit').modal("hide");
          formBlanace.reset();
          swalCustom.fire({
            icon: "success",
            title: "Documentos",
            text: objData.msg,
            confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
            confirmButtonColor: "#aea322",
          });
          DataTableAc.api().ajax.reload();
        }else {

          let errorMonto = objData.validations.hasOwnProperty('monto') ? objData.validations.monto : "" ;

          swalCustom.fire({
            icon: "error",
            title: "Error",
            text: objData.validations ? errorMonto : objData.msg,
            confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
            confirmButtonColor: "#aea322",
          });
        }
      }
    };
  };
});

window.addEventListener('load', function(){
    fntProveedores();
    fntConceptos();

}, false);

//Extraemos las categorias
function fntProveedores() {

  const ajaxUrl = base_url+'/home/getselectproveedores';
  const request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open("GET",ajaxUrl,true);
  request.send();

  request.onreadystatechange = function(){
      if (request.readyState == 4 && request.status == 200) {
          document.querySelector('#proveedor').innerHTML = request.responseText;
          
          //Limpiar el select para que se muestren los registros
          $('.wrap-list').addClass('text-wrap');
          $('#proveedor').selectpicker('refresh');
      }
  }
}

function fntConceptos() {

  const ajaxUrl = base_url+'/concepto/getSelectConceptos';
  const request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open("GET",ajaxUrl,true);
  request.send();

  request.onreadystatechange = function(){
      if (request.readyState == 4 && request.status == 200) {
          document.querySelector('#conceptos').innerHTML = request.responseText;
          
          //Limpiar el select para que se muestren los registros
          $('.wrap-list').addClass('text-wrap');
          $('#conceptos').selectpicker('refresh');
      }
  }
}

function fntEdit(id) {
  //Apariencia del modal
  document.querySelector("#titleModalEdit").innerHTML = 'Realizar un pago';
  document.querySelector("#btnActionForm").classList.replace("btn-primary", "btn-info");
  document.querySelector("#btnText").innerHTML = "Actualizar";
  document.querySelector("#monto-pagar").value = "";

  let id_pro = id;
  const request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
  const ajaxUrl = base_url + "/" + controlador + "/show?id=" + id_pro;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      const objData = JSON.parse(request.responseText);
      if (objData.status) {

        //Si el status es verdadero entonces se van a colocar los datos en el fomrulario
        document.querySelector("#idEdit").value = objData.data.id;
        document.querySelector("#monto_deuda").value = objData.data.monto;
        document.querySelector("#monto").value = objData.data.monto;

      }
    }
    $(modalNombreControlador + 'edit').modal("show");
  };
}

function fntView(id){

  document.querySelector("#titleModalShow").innerHTML = `Historial - documento (${id})`;
  document.querySelector("#btnActionForm").classList.replace("btn-primary", "btn-info");
  const identificador = document.getElementById('listHistory');
  identificador.innerHTML = "";

  let id_pro = id;
  const request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
  const ajaxUrl = base_url + "/" + controlador + "/conceptosdocumentos?idshow=" + id_pro;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    
    if (request.readyState == 4 && request.status == 200) {
      if (request.status) {
        
        const objData = JSON.parse(request.responseText);

        if (objData.length != 0) {
          for (let i = 0; i < objData.length; i++) {
            
            let boton_offcanvas = objData[i].estado == 0 ? '<button class="btn btn-sm colorBlue-boton personal-border" type="button" onClick="offCanvasCall('+objData[i].id+')"><i class="fas fa-hand-holding-usd"></i></button>' : '<button class="btn btn-sm colorGray-boton personal-border" type="button" onClick="offCanvasCallView('+objData[i].id+')"><i class="fa-solid fa-eye"></i></button>';
      
            identificador.innerHTML += '<li class="list-group-item fw-bold d-flex justify-content-between"><div>Concepto: '+objData[i].descripcion+' | nombre: '+objData[i].nombre+' | identificador: '+objData[i].documento_id+' | monto: '+objData[i].monto+'</div><div class="">'+boton_offcanvas+'</div></li>';
          }
        }else{
          identificador.innerHTML = `No existen registros`;
        }
      }
    }
    $(modalNombreControlador + 'show').modal("show");
  };
}

async function offCanvasCall(id) {

  let estadoOffCanvas = document.getElementById('span-estado');
  estadoOffCanvas.classList.contains('colorGreen') ? estadoOffCanvas.classList.remove('colorGreen') : "";
  estadoOffCanvas.classList.add('colorYellow');
  estadoOffCanvas.innerHTML = "Asiento pendiente";

  let btnEnviarDatosAPI = `<button id="btn-enviar-datos-API" class="btn fw-bold colorBlue-boton personal-border" type="submit" form="form${controlador}offcanvas"><i class="fa fa-fw fa-check-circle"></i> Enviar</button>`;

  let footerOfCanvas = document.getElementById('footer-offcanvas');
  footerOfCanvas.innerHTML = btnEnviarDatosAPI;

  let datos = await datosOffCanvas(id);
  const formAPI = document.querySelector(`#form${controlador}offcanvas`);
  const url =  `${base_url}/${controlador}/update`;
  const urlContabilidad = 'https://service-accounting.herokuapp.com/api/AccountingEntry';

  let dataAPI = [
    {
      'Period': datos.data.fecha,
      'Currency' : 'USD',
      'Detail' : [
        {
          'Amount' : datos.data.monto,
          'LegerAccount' : 23,
          'MovementType' : 'DB'
        },
        {
          'Amount' : datos.data.monto,
          'LegerAccount' : 4,
          'MovementType' : 'CR'
        }
      ]
    }
  ];
  
  formAPI.onsubmit = async (e) => {
    e.preventDefault();
    
    let APIContabilidad = await fetch(urlContabilidad,{
      
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'token': 'cuentaxp004'
      },
      body: JSON.stringify(dataAPI)

    })
      .then(response => response.json())
      .then(result => {

        return message = result.errorMessage ? {'error': result.errorMessage} : {'id': result.responseList[0].id};
      })
      .catch(error => {
        return error;
      });

    if (APIContabilidad.error) {
      swalCustom.fire({
        icon: "error",
        title: "Error",
        text: `${APIContabilidad.error}`,
        confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
        confirmButtonColor: "#aea322",
      });
      return false;
    }

    datos.data.asiento_id = APIContabilidad.id;

    let dataBackEnd = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(datos.data)
    });

    if (dataBackEnd.status === 200) {
      
      const objData = JSON.parse(await dataBackEnd.text());
      if (objData.status) {
        
        swalCustom.fire({
          icon: "success",
          title: "Documentos",
          text: objData.msg,
          confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
          confirmButtonColor: "#aea322",
        });

        fntView(datos.data.documento_id);
        offCanvasCallView(id);
      }else{

        let errorMonto = objData.validations.hasOwnProperty('monto') ? objData.validations.monto : "" ;
        swalCustom.fire({
          icon: "error",
          title: "Error",
          text: objData.validations ? errorMonto : objData.msg,
          confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
          confirmButtonColor: "#aea322",
        });
      }
    }
  };
}

async function offCanvasCallView(id) {

  let estadoOffCanvas = document.getElementById('span-estado');
  estadoOffCanvas.classList.contains('colorYellow') ? estadoOffCanvas.classList.remove('colorYellow') : "";
  estadoOffCanvas.classList.add('colorGreen');
  estadoOffCanvas.innerHTML = "Asiento enviado";

  let borrarBoton = document.getElementById('btn-enviar-datos-API');
  borrarBoton ? borrarBoton.remove() : "";

  await datosOffCanvas(id);
}

const datosOffCanvas = async (id) => {

  let myOffcanvas = document.getElementById('offcanvasScrolling');
  let bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);

  const url =  `${base_url}/${controlador}/datoscanvas?id=${id}`;
  let requestDatos = await fetch(url);

  if (requestDatos.status === 200) {
    
    datos = await requestDatos.json();

    document.querySelector("#idoffcanvas").value = id;
    document.querySelector("#descripcion-offcanvas").value = datos.data.descripcion;
    document.querySelector("#identificador-offcanvas").value = 6;
    document.querySelector("#cuenta-cr-offcanvas").value = '4';
    document.querySelector("#cuenta-db-offcanvas").value = '82';
    document.querySelector("#monto-offcanvas").value = datos.data.monto;
    document.querySelector("#id-asiento-offcanvas").value = datos.data.asiento_id;
      
    bsOffcanvas.show();
    return datos;
  }
};

function openModal(){
    
    document.querySelector('#id').value ="";//Limpiamos el input id **Muy importante
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo documento";
    document.querySelector("#form"+controlador+"").reset();//Limpiamos Todos los campos
  
    $("#estado").selectpicker("refresh");
    $('#proveedor').selectpicker('refresh');
  
    let modal = new bootstrap.Modal(document.querySelector(modalNombreControlador));
    modal.show();
    // $(modalNombreControlador).modal('show');
  }