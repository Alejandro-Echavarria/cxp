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
});

window.addEventListener('load', function(){
    fntProveedores();

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

function fntEdit(id) {
  //Apariencia del modal
  document.querySelector("#titleModalEdit").innerHTML = 'Realizar un pago';
  document.querySelector("#btnActionForm").classList.replace("btn-primary", "btn-info");
  document.querySelector("#btnText").innerHTML = "Actualizar";
  document.querySelector("#monto_deuda").value = "";

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

function openModal(){
    
    document.querySelector('#id').value ="";//Limpiamos el input id **Muy importante
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo documento";
    document.querySelector("#form"+controlador+"").reset();//Limpiamos Todos los campos
  
    $("#estado").selectpicker("refresh");
    $('#proveedor').selectpicker('refresh');
  
    var modal = new bootstrap.Modal(document.querySelector(modalNombreControlador));
    modal.show();
    // $(modalNombreControlador).modal('show');
  }