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
      { data: "cedula" },
      { data: "nombre" },
      { data: "tipo" },
      { data: "balance" },
      { data: "estado" },
      { data: "fecha_registro" },
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

    let intCedula = document.getElementById("cedula").value;
    let strNombre = document.querySelector("#nombre").value;
    let strTipo = document.querySelector("#tipo").value;

    if (intCedula === "" || strNombre === "" || strTipo === "") {
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
    
    let pCedula = intCedula.trim()

    if (pCedula.trim().length != 11) {
      
      swalCustom.fire({
        icon: "error",
        title: "Error",
        text: "La cédula no tiene el tamaño adecuado",
        confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
        confirmButtonColor: "#aea322",
      });

      return false;
    }

    const validarCedula = fntValidCedula(pCedula);

    if (validarCedula === 0) {

      swalCustom.fire({
        icon: "error",
        title: "Error",
        text: "La cédula es incorrecta",
        confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
        confirmButtonColor: "#aea322",
      });

      return false;
    }else {

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
              title: "Proveedores",
              text: objData.msg,
              confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
              confirmButtonColor: "#aea322",
            });
            DataTableAc.api().ajax.reload();
          }else {

            let errorCedula = objData.validations.hasOwnProperty('cedula') ? objData.validations.cedula : ""
            let errorNombre = objData.validations.hasOwnProperty('nombre') ? objData.validations.nombre : ""
            
            swalCustom.fire({
              icon: "error",
              title: "Error",
              text: objData.validations ? errorCedula + " " + errorNombre : objData.msg,
              confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
              confirmButtonColor: "#aea322",
            });

            return false;
          }
        }
      } 
    }   
    // End validar cedula
  };
});

function fntEdit(id) {
  //Apariencia del modal
  document.querySelector("#titleModal").innerHTML = 'Actualizar proveedor';
  document.querySelector("#btnActionForm").classList.replace("btn-primary", "btn-info");
  document.querySelector("#btnText").innerHTML = "Actualizar";

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
        document.querySelector("#id").value =objData.data.id;
        document.querySelector("#cedula").value =objData.data.cedula;
        document.querySelector("#nombre").value =objData.data.nombre;
        document.querySelector("#tipo").value =objData.data.tipo;
        document.querySelector("#estado").value =objData.data.estado;

        if (objData.data.estado == 1) {
          document.querySelector("#estado").value = 1;
        } else {
          if (objData.data.estado == 2) {
            document.querySelector("#estado").value = 2;
          }
        }

        $("#estado").selectpicker("refresh");
        $("#tipo").selectpicker("refresh");
      }
    }
    $(modalNombreControlador).modal("show");
  };
}

function fntDelete(id){
   
  const id_pro = id;

  //Configuracion de la alerta
  swalCustom.fire({
      icon: 'warning',
      title: "Eliminar un proveedor",
      text: "¿Realmente quieres eliminar este proveedor?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Si, eliminar",
      cancelButtonText: "<i class='fa fa-fw fa-times-circle'></i> No, cancelar",
      closeOnConfirm: false,
      closeOnCancel: true

  }).then((result) => {
      //Script para eliminar
      if (result.isConfirmed) {
          
        const request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        const ajaxUrl = base_url+'/'+controlador+'/delete';
        const strData = "id="+id_pro;
        request.open("POST",ajaxUrl,true);
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");//Forma en la que se enviaran los datos
        request.send(strData);
        request.onreadystatechange = function(){
          if (request.readyState == 4 && request.status == 200) {
            const objData = JSON.parse(request.responseText);
            if (objData.status){
              swalCustom.fire({
                icon: 'success',
                title: 'Proveedores',
                text: objData.msg,
                confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
                confirmButtonColor: '#aea322'
              });
              DataTableAc.api().ajax.reload();
            }else {
              swalCustom.fire({
                icon: 'error',
                title: 'Error',
                text: objData.msg,
                confirmButtonText: "<i class='fa fa-fw fa-check-circle'></i> Entendido",
                confirmButtonColor: '#aea322'
              });
            }
          }
        }
      }
  });
}

function openModal(){
    
  document.querySelector('#id').value ="";//Limpiamos el input id **Muy importante
  document.querySelector('#btnText').innerHTML = "Guardar";
  document.querySelector('#titleModal').innerHTML = "Nuevo proveedor";
  document.querySelector("#form"+controlador+"").reset();//Limpiamos Todos los campos

  $("#estado").selectpicker("refresh");
  $("#tipo").selectpicker("refresh");

  var modal = new bootstrap.Modal(document.querySelector(modalNombreControlador));
  modal.show();
  // $(modalNombreControlador).modal('show');
}
