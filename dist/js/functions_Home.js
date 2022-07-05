const modalNombreControlador = "#" + controlador;
const tablaNombreControlador = "#tabla_" + controlador;

$(document).ready(function () {

  const DataTableAc = $(tablaNombreControlador).dataTable({
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
      url: base_url + "/" + controlador + "/getRecordSet",
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

    let intCedula = document.querySelector("#cedula").value;
    let strNombre = document.querySelector("#nombre").value;
    let strTipo = document.querySelector("#tipo").value;
    let intEstado = document.querySelector("#estado").value;

    if (intCedula === "" || strNombre === "" || strTipo === "" || intEstado === "") {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Todos los campos son obligatorios",
        confirmButtonText: "Entendido",
        confirmButtonColor: "#aea322",
      });

      return false;
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
          Swal.fire({
            icon: "success",
            title: "Proveedores",
            text: objData.msg,
            confirmButtonText: "Entendido",
            confirmButtonColor: "#aea322",
          });
          DataTableAc.api().ajax.reload();
        }else {
            
          const errorCedula = objData.validations.cedula ? objData.validations.cedula : ""
          const errorNombre = objData.validations.nombre ? objData.validations.nombre : ""

          Swal.fire({
            icon: "error",
            title: "Error",
            text: objData.validations ? errorCedula + " " + errorNombre : objData.msg,
            confirmButtonText: "Entendido",
            confirmButtonColor: "#aea322",
          });
        }
      }
    };
  };
});

function openModal(){
    
  document.querySelector('#id').value ="";//Limpiamos el input id **Muy importante
  document.querySelector('#btnText').innerHTML = "Guardar";
  document.querySelector('#titleModal').innerHTML = "Nuevo proveedor";
  document.querySelector("#form"+controlador+"").reset();//Limpiamos Todos los campos

  $('#listStatus').selectpicker('render');

  const modal = document.getElementById(modalNombreControlador);
  // modal.modal('show');
  $(modalNombreControlador).modal('show');

}
