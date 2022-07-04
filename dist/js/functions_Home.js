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
  // var form = document.querySelector("#form" + controlador + "");

  // form.onsubmit = function (e) {
  //   e.preventDefault();
  //   var strDecripcion = document.querySelector("#txtDescripcionEmpaque").value;
  //   var intUnidades = document.querySelector("#intUnidades").value;

  //   if (strDecripcion == "" || intUnidades == "") {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Error",
  //       text: "Todos los campos son obligatorios",
  //       confirmButtonText: "Entendido",
  //       confirmButtonColor: "#aea322",
  //     });

  //     return false;
  //   }

  //   // var request = window.XMLHttpRequest
  //   //   ? new XMLHttpRequest()
  //   //   : new ActiveXObject("Microsoft.XMLHTTP");
  //   // var ajaxUrl = base_url + "/" + controlador + "/insert";
  //   // var formData = new FormData(form);
  //   // request.open("POST", ajaxUrl, true);
  //   // request.send(formData);

  //   // request.onreadystatechange = function () {
  //   //   if (request.readyState == 4 && request.status == 200) {
  //   //     var objData = JSON.parse(request.responseText);
  //   //     if (objData.status) {
  //   //       $(modalNombreControlador).modal("hide");
  //   //       form.reset();
  //   //       Swal.fire({
  //   //         icon: "success",
  //   //         title: "Empaques",
  //   //         text: objData.msg,
  //   //         confirmButtonText: "Entendido",
  //   //         confirmButtonColor: "#aea322",
  //   //       });
  //   //       DataTableAc.api().ajax.reload();
  //   //     } else {
  //   //       Swal.fire({
  //   //         icon: "error",
  //   //         title: "Error",
  //   //         text: objData.msg,
  //   //         confirmButtonText: "Entendido",
  //   //         confirmButtonColor: "#aea322",
  //   //       });
  //   //     }
  //   //   }
  //   // };
  // };
});
