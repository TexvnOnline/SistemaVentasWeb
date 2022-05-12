<template>
  <layout ref="layout">
    <div class="slot_body" slot="component-view">
      <div class="content" style="display: block">
        <div class="card">
          <headerClose :title="'HISTORIAL DE VENTAS DE SUMINISTROS'"></headerClose>
          <div class="card-title">DATOS DE BÚSQUEDA</div>
          <div class="card-body card-block">
            <div class="form-row">
              <div class="form-group col-md-1 col-12">
                <button
                  class="btn btn-action btn-icon-split mb-1"
                  @click="MesActual"
                  title="Desdel el primer hasta el último día del mes."
                >
                  <span class="text font-size-layout">Ver del mes</span>
                  <span class="icon text-white">
                    <i class="fas fa-search"></i>
                  </span>
                </button>
              </div>
              <div class="form-group col-xs-6">
                <label for="text-input" class="form-control-label">Desde</label>
                <input
                  class="form-control center"
                  type="date"
                  name="desde"
                  id="dtpDesde"
                  data-index="1"
                  style="width: 150px"
                  onkeydown="return false"
                  @change="FiltrarFechas"
                />
              </div>
              <div class="form-group col-xs-6">
                <label for="text-input" class="form-control-label">Hasta</label>
                <div class="form-row">
                  <input
                    class="form-control center"
                    type="date"
                    name="hasta"
                    id="dtpHasta"
                    data-index="1"
                    style="width: 150px"
                    onkeydown="return false"
                    @change="FiltrarFechas"
                  />
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-check" style="margin-right: 20px">
                <input
                  class="form-check-input"
                  type="radio"
                  name="flexRadioDefault"
                  value="1"
                  id="flexRadioHistorial1"
                  checked
                  @change="RadioHistorial1"
                />
                <label class="form-check-label" for="flexRadioDefault1"> Agrupado </label>
              </div>
              <!-- <div class="form-check">
                <input
                  class="form-check-input"
                  type="radio"
                  name="flexRadioDefault"
                  value="2"
                  id="flexRadioHistorial2"
                  @change="RadioHistorial2"
                />
                <label class="form-check-label" for="flexRadioDefault2">
                  Detallado
                </label>
              </div> -->
            </div>
          </div>
          <div class="card-title">RESULTADOS DE BÚSQUEDA</div>
          <div class="card-body card-block">
            <div id="HistorialUno">
              <div class="input-group row col-md-3 mb-1 input-search">
                <input
                  class="form-control"
                  type="text"
                  id="inpBuscar"
                  placeholder="Buscar..."
                />
                <div class="input-group-append">
                  <button class="btn btn-action" type="button">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
              <div id="div_tabla_historial_ventas">
                <table class="table table-hover" id="tblHistorialVentas">
                  <thead>
                    <tr>
                      <th style="width: 70px !important">VER</th>
                      <th>FECHA DE VENTA</th>
                      <th>USUARIO VENTA</th>
                      <th>RECETA DEL DOCOR</th>
                      <th>TIPO DE COMPROBANTE</th>
                      <th>VENDIDO A</th>
                      <th>PRECIO TOTAL</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(venta, index) in ventas_filtros" :key="index">
                      <td class="table-bordered" align="center">
                        <button
                          class="btn btn-action btn-icon-split"
                          @click="VerDetalle(venta.id)"
                        >
                          <span class="icon text-white">
                            <i class="far fa-eye" style="color: white"></i>
                          </span>
                        </button>
                      </td>
                      <td class="table-bordered" align="center">
                        {{ venta.fecha_venta}}
                      </td>
                      <td class="table-bordered" align="center">
                        {{ venta.vendeor }}
                      </td>
                      <td class="table-bordered" align="center">
                        {{ venta.doctor }}
                      </td>
                      <td class="table-bordered" align="center">
                        {{ venta.tipo_comprobante }}
                      </td>
                      <td class="table-bordered" align="center">
                        {{ venta.apellidos + " " + venta.nombres }}
                      </td>
                      <td class="table-bordered" align="center">
                        {{ venta.precio_total }}
                      </td>
                    </tr>
                  </tbody>
                </table>
                <br />
                <br />
              </div>
            </div>
            <div id="HistorialDos">
              <div class="input-group row col-md-3 mb-1 input-search">
                <input
                  class="form-control"
                  type="text"
                  id="inpBuscar2"
                  placeholder="Buscar..."
                />
                <div class="input-group-append">
                  <button class="btn btn-action" type="button">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>

              <!-- <table
                class="table table-hover"
                id="tblVentaTodo"
                style="width: 100% !important"
              >
                <thead>
                  <tr>
                    <th style="width: 70px !important">CÓDIGO</th>
                    <th>FECHA DE VENTA</th>
                    <th>USUARIO VENTA</th>
                    <th>VENDIDO A</th>
                    <th>PRECIOS TOTAL</th>
                    <th>CANTIDAD</th>
                    <th>NOMBRES PRODUCTO</th>
                    <th>PRECIO DE VENTA UNITARIO(S/)</th>
                    <th>PRECIO REAL UNITARIO (S/)</th>
                    <th>DIFERENCIA DE PRECIO UNITARIO (S/)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(venta, index) in ventas_todos_filtro" :key="index">
                    <td class="table-bordered" align="center">
                      {{ venta.codigo }}
                    </td>
                    <td class="table-bordered" align="center">
                      {{ JSON.parse(venta.datos_creacion).fecha }}
                    </td>
                    <td class="table-bordered" align="center">
                      {{ venta.usuario }}
                    </td>
                    <td class="table-bordered" align="center">
                      {{ venta.apellidos + " " + venta.nombres }}
                    </td>
                    <td class="table-bordered" align="center">
                      {{ venta.precio_venta }}
                    </td>
                    <td class="table-bordered" align="center">
                      {{ parseInt(venta.cantidad) }}
                    </td>
                    <td class="table-bordered" align="center">
                      {{ venta.nombre_suministro }}
                    </td>
                    <td class="table-bordered" align="right">
                      {{ roundTo(venta.precio_unitario_venta, 2) }}
                    </td>
                    <td class="table-bordered" align="right">
                      {{ roundTo(venta.precio_unitario_almacen, 2) }}
                    </td>
                    <td class="table-bordered" align="right">
                      {{ venta.precio_unitario_venta - venta.precio_unitario_almacen }}
                    </td>
                  </tr>
                </tbody>
              </table> -->
            </div>
          </div>
        </div>
      </div>

      <!-- The Modal -->
      <div id="modalVentaDetalle" class="modal">
        <div class="modal-content w-60">
          <div class="content" style="display: block">
            <div class="card">
              <div class="card-header">
                <strong>DETALLE DE VENTA</strong>
              </div>
              <div class="card-body card-block">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a
                      class="nav-link active tab-title"
                      id="datosVentaDetalle1-tab"
                      data-toggle="tab"
                      href="#datosVentaDetalle1"
                      role="tab"
                      aria-controls="datosVentaDetalle1"
                      aria-selected="true"
                      >Lista de ventas</a
                    >
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div
                    class="tab-pane fade show active"
                    id="datosVentaDetalle1"
                    role="tabpanel"
                    aria-labelledby="datosVentaDetalle1-tab"
                  >
                    <div class="table-modal" id="tabla_historial_compras_detalle">
                      <table class="table table-hover" id="tblVentaDetalle" width="100%">
                        <thead>
                          <tr>
                            <th>CANTIDAD</th>
                            <th>NOMBRES PRODUCTO</th>
                            <th>PRECIO DE VENTA (S/)</th>
                            <th>DESCRIPCION</th>
                            <!-- <th>PRECIO REAL (S/)</th> -->
                            <!-- <th>DIFERENCIA DE PRECIOS (S/)</th> -->
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            v-for="(venta_detalle, index) in ventas_detalle_filtros"
                            :key="index"
                          >
                            <td class="table-bordered" align="center">
                              {{ roundTo(venta_detalle.cantidad, 2) }}
                            </td>
                            <td class="table-bordered" align="center">
                              {{ venta_detalle.nombre }}
                            </td>
                            <td class="table-bordered" align="center">
                              {{ roundTo(venta_detalle.precio_sugerido, 2) }}
                            </td>
                            <td class="table-bordered" align="center">
                              {{ venta_detalle.descripcion }}
                            </td>
                            <!-- <td class="table-bordered" align="center">
                              {{
                                roundTo(
                                  venta_detalle.precio_unitario_venta -
                                    venta_detalle.precio_unitario_almacen,
                                  2
                                )
                              }}
                            </td> -->
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

                </div>

                <hr />
                <div class="text-right">
                  <button class="btn btn-action btn-icon-split" id="btnAceptar">
                    <span class="icon text-white">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text font-size-layout">Aceptar</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import layout from "../Components/layout_prin.vue";
import headerClose from "./../Components/header_close";
export default {
  components: {
    layout,
    headerClose,
  },
  props: {
    ventas: Array,
    ventas_detalle: Array,
    // ventas_todos: Array,
  },
  data() {
    return {
      submited: false,
      ventas_filtros: [],
      ventas_detalle_filtros: [],
      // ventas_todos_filtro: [],
      comprobante: null,
    };
  },
  mounted() {
    this.RadioHistorial1();
    this.TablaHistorialVentas();
    this.TablaHistorialVentasDetalle();
    // this.TablaHistorialVentasTodos();

    if (screen.width < 1000) {
      document.getElementById("tblHistorialVentas").classList.add("table-responsive");
      document.getElementById("tblVentaDetalle").classList.add("table-responsive");
    }
  },

  methods: {
    roundTo(value, places) {
      if (value > 0 && value != "Infinity") {
        var power = Math.pow(10, places);
        return parseFloat(Math.round(value * power) / power).toFixed(2);
      } else {
        return 0;
      }
    },

    TablaHistorialVentas() {
      this.$nextTick(() => {
        var table = $("#tblHistorialVentas").DataTable({
          destroy: true,
          lengthMenu: [
            [10, 50, 100, -1],
            [10, 50, 100, "Todas"],
          ],
          order: [[1, "desc"]],
          language: {
            retrieve: true,
            decimal: "",
            emptyTable: "No hay datos disponibles en la tabla",
            info: "Mostrando del _START_ al _END_ de _TOTAL_ registros",
            infoEmpty: "No se encontraron registros",
            infoFiltered: "(filtrado de _MAX_ registros)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Agrupar por _MENU_ filas",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "No se encontraron registros",
            paginate: {
              first: "Primera",
              last: "Ultima",
              next: '<i class="fas fa-chevron-circle-right" style="font-size:20px;"></i>',
              previous:
                '<i class="fas fa-chevron-circle-left" style="font-size:20px;"></i>',
            },
            aria: {
              sortAscending: ": activar para ordenar de forma ascendente",
              sortDescending: ": activar para ordenar de forma descendente",
            },
          },
          responsive: true,
          dom:
            '<"top"Bf>rt<"row"<"col-sm-12 col-md-5 mb-2"i><"col-sm-12 col-md-7 mb-2"p><"col-sm-12 col-md-5 mb-2"l>><"clear">',
          buttons: [
            {
              extend: "excelHtml5",
              text: '<i class="fas fa-file-excel"></i> ',
              titleAttr: "Exportar a Excel",
              className: "btn btn-action",
            },
            {
              extend: "pdfHtml5",
              text: '<i class="fas fa-file-pdf"></i> ',
              titleAttr: "Exportar a PDF",
              className: "btn btn-cancel",
            },
            {
              extend: "print",
              text: '<i class="fa fa-print"></i> ',
              titleAttr: "Imprimir",
              className: "btn btn-action",
            },
          ],
        });

        $("#inpBuscar").keyup(function () {
          table.search(this.value).draw();
        });
      });
    },

    TablaHistorialVentasDetalle() {
      this.$nextTick(() => {
        var table = $("#tblVentaDetalle").DataTable({
          scrollY: "400px",
          scrollX: true,
          scrollCollapse: true,
          paging: false,
          fixedColumns: {
            leftColumns: 0,
          },
          order: [[0, "asc"]],
          fixedHeader: true,
          language: {
            retrieve: true,
            decimal: "",
            emptyTable: "No hay datos disponibles en la tabla",
            info: "Mostrando del _START_ al _END_ de _TOTAL_ registros",
            infoEmpty: "No se encontraron registros",
            infoFiltered: "(filtrado de _MAX_ registros)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Agrupar por _MENU_ filas",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "No se encontraron registros",
            paginate: {
              first: "Primera",
              last: "Ultima",
              next: '<i class="fas fa-chevron-circle-right" style="font-size:20px;"></i>',
              previous:
                '<i class="fas fa-chevron-circle-left" style="font-size:20px;"></i>',
            },
            aria: {
              sortAscending: ": activar para ordenar de forma ascendente",
              sortDescending: ": activar para ordenar de forma descendente",
            },
          },
          responsive: false,
          dom:
            '<"top"Bf>rt<"row"<"col-sm-12 col-md-5 mb-2"i><"col-sm-12 col-md-7 mb-2"p><"col-sm-12 col-md-5 mb-2"l>><"clear">',
          buttons: [
            {
              extend: "excelHtml5",
              text: '<i class="fas fa-file-excel"></i> ',
              titleAttr: "Exportar a Excel",
              className: "btn btn-action",
            },
            {
              extend: "pdfHtml5",
              text: '<i class="fas fa-file-pdf"></i> ',
              titleAttr: "Exportar a PDF",
              className: "btn btn-cancel",
            },
            {
              extend: "print",
              text: '<i class="fa fa-print"></i> ',
              titleAttr: "Imprimir",
              className: "btn btn-action",
            },
          ],
        });
      });
    },
    // TablaHistorialVentasTodos() {
    //   this.$nextTick(() => {
    //     var table = $("#tblVentaTodo").DataTable({
    //       destroy: true,
    //       lengthMenu: [
    //         [10, 50, 100, -1],
    //         [10, 50, 100, "Todas"],
    //       ],
    //       order: [[1, "desc"]],
    //       language: {
    //         retrieve: true,
    //         decimal: "",
    //         emptyTable: "No hay datos disponibles en la tabla",
    //         info: "Mostrando del _START_ al _END_ de _TOTAL_ registros",
    //         infoEmpty: "No se encontraron registros",
    //         infoFiltered: "(filtrado de _MAX_ registros)",
    //         infoPostFix: "",
    //         thousands: ",",
    //         lengthMenu: "Agrupar por _MENU_ filas",
    //         loadingRecords: "Cargando...",
    //         processing: "Procesando...",
    //         search: "Buscar:",
    //         zeroRecords: "No se encontraron registros",
    //         paginate: {
    //           first: "Primera",
    //           last: "Ultima",
    //           next: '<i class="fas fa-chevron-circle-right" style="font-size:20px;"></i>',
    //           previous:
    //             '<i class="fas fa-chevron-circle-left" style="font-size:20px;"></i>',
    //         },
    //         aria: {
    //           sortAscending: ": activar para ordenar de forma ascendente",
    //           sortDescending: ": activar para ordenar de forma descendente",
    //         },
    //       },
    //       responsive: true,
    //       dom:
    //         '<"top"Bf>rt<"row"<"col-sm-12 col-md-5 mb-2"i><"col-sm-12 col-md-7 mb-2"p><"col-sm-12 col-md-5 mb-2"l>><"clear">',
    //       buttons: [
    //         {
    //           extend: "excelHtml5",
    //           text: '<i class="fas fa-file-excel"></i> ',
    //           titleAttr: "Exportar a Excel",
    //           className: "btn btn-action",
    //         },
    //         {
    //           extend: "pdfHtml5",
    //           text: '<i class="fas fa-file-pdf"></i> ',
    //           titleAttr: "Exportar a PDF",
    //           className: "btn btn-cancel",
    //         },
    //         {
    //           extend: "print",
    //           text: '<i class="fa fa-print"></i> ',
    //           titleAttr: "Imprimir",
    //           className: "btn btn-action",
    //         },
    //       ],
    //     });

    //     $("#inpBuscar2").keyup(function () {
    //       table.search(this.value).draw();
    //     });
    //   });
    // },
    MesActual() {
    //   let fecha = new Date()
    //   let mes = fecha.getMonth() + 1; //obteniendo mes
    //   let dia = fecha.getDate(); //obteniendo dia
    //   let ano = fecha.getFullYear(); //obteniendo año
    //   if (dia < 10) dia = "0" + dia; //agrega cero si el menor de 10
    //   if (mes < 10) mes = "0" + mes;

    // this.fecha_actual = ano + "-" + mes + "-" + dia;

      // let fecha_actual = this.$inertia.page.props.application.data.filter(
      //   (item) => item.descripcion == "FECHA_LOGISTICA"
      // )[0].valorFecha;

      let fecha = new Date(); //Fecha actual
      fecha.setMinutes(fecha.getMinutes() + fecha.getTimezoneOffset()); //Ajustando hora de zona horaria
      let ano = fecha.getFullYear(); //obteniendo año
      let mes = fecha.getMonth() + 1; //obteniendo mes
      if (mes < 10) mes = "0" + mes;

      let p_dia = 1; //obteniendo dia

      if (p_dia < 10) p_dia = "0" + p_dia;

      let u_dia = new Date(ano, mes, 0).getDate();
      if (u_dia < 10) u_dia = "0" + u_dia;

      let primer_dia = ano + "-" + mes + "-" + p_dia;
      let ultimo_dia = ano + "-" + mes + "-" + u_dia;

      $("#dtpDesde").val(primer_dia);
      $("#dtpHasta").val(ultimo_dia);

      this.FiltrarFechas();
    },
    FiltrarFechas() {
      self = this;
      let desde = $("#dtpDesde").val();
      let hasta = $("#dtpHasta").val();
      // console.log(this.ventas[0]);
      // console.log(this.ventas[0].fecha_venta.substr(0, 10));

      if (desde === "" && !(hasta === "")) {
        this.ventas_filtros = this.ventas.filter(
          (item) => item.fecha_venta.substr(0, 10) <= hasta
        );
        // --------
        // this.ventas_todos_filtro = this.ventas_todos.filter(
        //   (item) => item.fecha_venta.substr(0, 10) <= hasta
        // );
      } else if (!(desde === "") && hasta === "") {
        this.ventas_filtros = this.ventas.filter(
          (item) => item.fecha_venta.substr(0, 10) >= desde
        );

        // this.ventas_todos_filtro = this.ventas_todos.filter(
        //   (item) => item.fecha_venta.substr(0, 10) >= desde
        // );
      } else if (!(desde === "") && !(hasta === "")) {
        this.ventas_filtros = this.ventas.filter(
          (item) =>
            item.fecha_venta.substr(0, 10) >= desde &&
            item.fecha_venta.substr(0, 10) <= hasta
        );

        // this.ventas_todos_filtro = this.ventas_todos.filter(
        //   (item) =>
        //     item.fecha_venta.substr(0, 10) >= desde &&
        //     item.fecha_venta.substr(0, 10) <= hasta
        // );
      } else if (desde === "" && hasta === "") {
        this.ventas_filtros = [];
        // this.ventas_todos_filtro = [];
      }
      // console.log(this.ventas_filtros);
      //------------------

      // $("#tblVentaTodo").DataTable().destroy();
      // this.TablaHistorialVentasTodos();

      $("#tblHistorialVentas").DataTable().destroy();
      this.TablaHistorialVentas();
    },
    VerDetalle(id_venta) {
      // console.log(id_venta);
      self = this;
      (this.ventas_detalle_filtros = this.ventas_detalle.filter(
        (item) => item.id_venta == id_venta
      )),
        // (self.comprobante = self.ventas.filter(
        //   (item) => item.id == id_venta
        // )[0].comprobante),
        //------------------------
        $("#tblVentaDetalle").DataTable().destroy();
      self.TablaHistorialVentasDetalle();
      //----------------------
      $("#modalVentaDetalle").css("display", "block");
      $("#datosVentaDetalle1-tab").tab("show");

      $("#btnAceptar").click(function () {
        $("#modalVentaDetalle").css("display", "none");
        $("#datosVentaDetalle1-tab").tab("show");
      });
    },
    RadioHistorial1() {
      // console.log($("#flexRadioHistorial1").val());
      // HistorialUno .show();
      $("#HistorialUno").show();
      $("#HistorialDos").hide();
    },
    RadioHistorial2() {
      // console.log($("#flexRadioHistorial2").val());
      $("#HistorialUno").hide();
      $("#HistorialDos").show();

      // $("#tblComprasTodo").DataTable().destroy();
      // this.TablaHistorialComprasTodo();
    },
  },
};
</script>

<style></style>
