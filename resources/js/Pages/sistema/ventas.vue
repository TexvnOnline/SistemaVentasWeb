<template>
  <layout ref="layout">
    <div class="slot_body" slot="component-view">
      <div class="content" style="display: block">
        <div class="card">
          <headerClose :title="'VENTA DE SUMINISTROS'"></headerClose>
          <div class="card-title">DATOS DE BÚSQUEDA</div>
          <div class="card-body card-block">
            <div class="form-row col-md-4">
              <div class="form-group col-md-6 col-6">
                <label for="slcAgencias" class="form-control-label"
                  >Por sede</label
                >
                <select
                  class="form-control center"
                  name="slcSedes"
                  id="slcSedes"
                  style="max-width: 200px"
                  @change="FiltrarProductos"
                >
                  <option value="seleccione">Seleccione...</option>
                  <option v-for="sede in sedes" :key="sede.id" :value="sede.id">
                    {{ sede.sedes }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div class="card-title">RESULTADOS DE BÚSQUEDA</div>
          <div class="card-body card-block">
            <div class="text-center">
              <button
                class="btn btn-action btn-icon-split mb-2"
                id="btnAsignarActivo"
                @click="VenderSuministros"
                :disabled="frmDatosVenta.suministros_seleccionados.length == 0"
              >
                <span class="icon text-white">
                  <i class="fas fa-dollar-sign"></i>
                </span>
                <span class="text font-size-layout">Vender</span>
              </button>
            </div>
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

            <table class="table table-hover" id="tblSuministros">
              <thead>
                <tr>
                  <th>VENDER</th>
                  <th>PRODUCTO</th>
                  <th>SEDE</th>
                  <th>PROVEEDOR</th>
                  <th>CANTIDAD</th>
                  <th>MARCA</th>
                  <th>DESCRIPCION</th>
                  <th>TALLA</th>
                  <th>PRECIO_SUGERIDO</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(producto, index) in productos_filtrados"
                  :key="index"
                >
                  <td class="table-bordered" align="center">
                    <div class="checkbox">
                      <label
                        style="
                          font-size: 1.7em;
                          margin-bottom: 0 !important;
                          height: 28.6px !important;
                          margin-left: 5px;
                          margin-top: 5px;
                        "
                        ><input
                          type="checkbox"
                          :value="producto"
                          :id="'chb' + producto.id"
                          v-model="frmDatosVenta.suministros_seleccionados"
                          @change="ActualizarTabla" /><span
                          class="cr"
                          style="margin-right: 0 !important"
                          ><i class="cr-icon fa fa-check"></i></span
                      ></label>
                    </div>
                  </td>
                  <td class="table-bordered" align="center">
                    {{ producto.nombre }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ producto.nombre_sede }}
                  </td>
                  <td class="table-bordered">
                    {{ producto.nombre_empresa }}
                  </td>
                  <td class="table-bordered">
                    {{ producto.cantidad }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ producto.marca }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ producto.descripcion }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ roundTo(producto.talla, 2) }}
                  </td>
                  <td class="table-bordered" align="center">
                    S/
                    {{ roundTo(producto.precio_sugerido, 2) }}
                  </td>
                </tr>
              </tbody>
            </table>
            <br />
            <br />
          </div>
        </div>

        <div class="modal" id="mdlSuministrosActivos">
          <div class="modal-content w-60">
            <div class="content" style="display: block">
              <div class="card">
                <div class="card-header">
                  <div id="c_titulo">
                    <strong id="title">{{ title_modal }}</strong>
                  </div>
                </div>
                <div class="card-title">DETALLES</div>
                <div class="card-body card-block">
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label class="form-control-label"
                        >LISTA DE PRODUCTOS</label
                      >
                      <div
                        v-if="
                          submited &&
                          frmDatosVenta.suministros_seleccionados.length == 0
                        "
                        style="color: red; font-size: 12px"
                      >
                        *Seleccione al menos un producto
                      </div>
                      <table
                        class="table table-hover table-responsive"
                        id="tblSuministroModal"
                      >
                        <thead>
                          <tr>
                            <th>QUITAR</th>
                            <th>PRECIO</th>
                            <!-- <th>CANTIDAD A VENDER</th> -->
                            <th>SEDE</th>
                            <th>PRODUCTO</th>
                            <th>MARCA</th>
                            <th>TALLA</th>
                            <!-- <th>PRECIO UNITARIO</th> -->
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            v-for="(
                              suministro_selc, index
                            ) in frmDatosVenta.suministros_seleccionados"
                            :key="index"
                          >
                            <td
                              class="table-bordered"
                              align="center"
                              width="75px"
                            >
                              <button
                                class="btn btn-action btn-icon-split"
                                id="btnQuitarActivo"
                                @click="EliminarCompra(index)"
                              >
                                <span class="icon text-white">
                                  <i class="fas fa-trash-alt"></i>
                                </span>
                              </button>
                            </td>
                            <td class="table-bordered">
                              <input
                                style="width: 100px !important"
                                type="number"
                                min="0"
                                step="0.01"
                                :name="index"
                                :id="'precio_' + index"
                                class="form-control center"
                                @click="Insertar_precio"
                                :value="suministro_selc.precio_sugerido"
                              />
                            </td>
                            <!-- <td class="table-bordered">
                              <input
                                :disabled="true"
                                style="width: 100px !important"
                                type="number"
                                min="0"
                                step="1"
                                @change="Insertar_cantidad"
                                class="form-control center"
                                :name="index"
                                :value="suministro_selc.cantidad"
                                :id="'cantidad_' + index"
                              />
                            </td> -->
                            <td class="table-bordered" align="center">
                              {{ suministro_selc.nombre_sede }}
                            </td>
                            <td class="table-bordered" align="center">
                              {{ suministro_selc.nombre }}
                            </td>
                            <td class="table-bordered" align="center">
                              {{ suministro_selc.marca }}
                            </td>

                            <td class="table-bordered" align="center">
                              {{ suministro_selc.talla }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <form autocomplete="off">
                    <div class="form-row">
                      <div class="form-group col-md-5">
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label class="form-control-label" for="inpDniModal"
                              >DNI:
                            </label>
                          </div>
                          <div class="form-group col-md-8">
                            <input
                              type="number"
                              maxlength="8"
                              class="form-control center"
                              step="1"
                              style="width: 150px !important"
                              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                              id="inpDniModal"
                              v-model="frmDatosVenta.dni"
                            />
                          </div>
                          <div
                            v-if="submited && !$v.frmDatosVenta.dni.required"
                            style="color: red; font-size: 12px"
                          >
                            *Ingresa el dni del comprador
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label
                              class="form-control-label"
                              for="inpApellidosModal"
                              >APELLIDOS:
                            </label>
                          </div>
                          <div class="form-group col-md-8">
                            <input
                              type="text"
                              class="form-control"
                              id="inpApellidosModal"
                              v-model="frmDatosVenta.apellidos"
                            />
                          </div>
                          <div
                            v-if="
                              submited && !$v.frmDatosVenta.apellidos.required
                            "
                            style="color: red; font-size: 12px"
                          >
                            *Ingresa los apellidos del comprador
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label
                              class="form-control-label"
                              for="inpNombresModal"
                              >NOMBRES:
                            </label>
                          </div>
                          <div class="form-group col-md-8">
                            <input
                              type="text"
                              class="form-control"
                              id="inpNombresModal"
                              v-model="frmDatosVenta.nombres"
                            />
                          </div>
                          <div
                            v-if="
                              submited && !$v.frmDatosVenta.nombres.required
                            "
                            style="color: red; font-size: 12px"
                          >
                            *Ingresa los nombres del comprador
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label
                              class="form-control-label"
                              for="inpApellidosModal"
                              >CORREO:
                            </label>
                          </div>
                          <div class="form-group col-md-8">
                            <input
                              type="text"
                              class="form-control"
                              id="inpApellidosModal"
                              v-model="frmDatosVenta.correo"
                            />
                          </div>
                          <div
                            v-if="submited && !$v.frmDatosVenta.correo.required"
                            style="color: red; font-size: 12px"
                          >
                            *Ingresa el correo del comprador
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label class="form-control-label" for="inpDniModal"
                              >TELEFONO:
                            </label>
                          </div>
                          <div class="form-group col-md-8">
                            <input
                              type="number"
                              maxlength="9"
                              class="form-control center"
                              step="1"
                              style="width: 150px !important"
                              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                              id="inpDniModal"
                              v-model="frmDatosVenta.telefono"
                            />
                          </div>
                          <div
                            v-if="
                              submited && !$v.frmDatosVenta.telefono.required
                            "
                            style="color: red; font-size: 12px"
                          >
                            *Ingresa el telefono del comprador
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label class="form-control-label" for="inpDniModal"
                              >EDAD:
                            </label>
                          </div>
                          <div class="form-group col-md-8">
                            <input
                              type="number"
                              maxlength="3"
                              class="form-control center"
                              step="1"
                              style="width: 150px !important"
                              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                              id="inpDniModal"
                              v-model="frmDatosVenta.edad"
                            />
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label class="form-control-label" for="inpDniModal"
                              >TALLA:
                            </label>
                          </div>
                          <div class="form-group col-md-8">
                            <input
                              type="text"
                              maxlength="5"
                              class="form-control center"
                              step="0.1"
                              style="width: 150px !important"
                              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                              id="inpDniModal"
                              v-model="frmDatosVenta.talla"
                            />
                          </div>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label
                            class="form-control-label"
                            for="slcResponsableModal"
                            >PRECIO TOTAL:</label
                          >
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">S/</div>
                            </div>
                            <input
                              type="text"
                              class="form-control text-right"
                              id="inpPrecioModal"
                              v-model="frmDatosVenta.precio"
                              readonly
                            />
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label
                            class="form-control-label"
                            for="slcResponsableModal"
                            >TIPO DE PAGO:</label
                          >
                          <input
                            type="text"
                            class="form-control text-right"
                            id="inpTipoPago"
                            v-model="frmDatosVenta.tipo_pago"
                          />
                          <div
                            v-if="
                              submited && !$v.frmDatosVenta.tipo_pago.required
                            "
                            style="color: red; font-size: 12px"
                          >
                            *Ingrese el tipo de pago
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label
                            class="form-control-label label-title"
                            for="inpDocumentoAsignacion"
                            >DOCTOR</label
                          >
                          <select
                            class="form-control center"
                            name="slcSedes"
                            id="slcSedes"
                            style="max-width: 200px"
                            v-model="frmDatosVenta.doctor"
                          >
                            <option value="0" selected>Seleccione...</option>
                            <option
                              v-for="doctor in doctores"
                              :key="doctor.id"
                              :value="doctor.id"
                            >
                              {{ doctor.usuario }}
                            </option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group col-md-4">
                          <label
                            class="form-control-label label-title"
                            for="inpDocumentoAsignacion"
                            >TIPO DE COMPROBANTE</label
                          >
                          <select
                            class="form-control center"
                            name="slcSedes"
                            id="slcComprobante"
                            style="max-width: 200px"
                            v-model="frmDatosVenta.tipo_comprobante"
                          >
                            <option value="0" selected>Seleccione...</option>
                            <option value="Boleta" selected>Boleta</option>
                            <option value="Factura" selected>Factura</option>
                            <option value="Nota de pago" selected>Nota de pago</option>
                          </select>
                          <div
                            v-if="
                              submited &&
                              !$v.frmDatosVenta.tipo_comprobante.greaterThanZero
                            "
                            style="color: red; font-size: 12px"
                          >
                            *Elija al tipo de comprobante
                          </div>
                        </div>
                      <div class="form-group col-md-4">
                        <label
                          class="form-control-label"
                          for="slcResponsableModal"
                          >A CUENTA:</label
                        >
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">S/</div>
                          </div>
                          <input
                            type="number"
                            class="form-control center"
                            id="inpAcuenta"
                            name="a_cuenta"
                            min="1"
                            step="0.01"
                            lang="en"
                            placeholder="0.00"
                            v-model.number="frmDatosVenta.a_cuenta"
                          />
                        </div>
                      </div>
                      <div class="form-group col-md-4">
                        <label
                          class="form-control-label"
                          for="slcResponsableModal"
                          >SALDO:</label
                        >
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">S/</div>
                          </div>
                          <input
                            type="number"
                            class="form-control center"
                            id="inpSaldo"
                            min="1"
                            step="0.01"
                            lang="en"
                            placeholder="0.00"
                            v-model.number="frmDatosVenta.saldo"
                          />
                        </div>
                      </div>
                    </div>
                  </form>
                  <hr />
                  <div class="text-right">
                    <button
                      class="btn btn-action btn-icon-split"
                      @click="Guardar"
                    >
                      <span class="icon text-white">
                        <i class="fas fa-dollar-sign"></i>
                      </span>
                      <span class="text font-size-layout">Vender</span>
                    </button>
                    <button
                      class="btn btn-cancel btn-icon-split"
                      type="button"
                      id="btnCancelar"
                    >
                      <span class="icon text-white">
                        <i class="fas fa-times"></i>
                      </span>
                      <span class="text font-size-layout">Cancelar</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- The Modal -->
    </div>
  </layout>
</template>

<script>
import { required } from "vuelidate/lib/validators";
import layout from "../Components/layout_prin.vue";
import headerClose from "./../Components/header_close";
const greaterThanZero = (value) => value > 0;
export default {
  components: {
    layout,
    headerClose,
  },
  props: {
    productos: Array,
    sedes: Array,
    doctores: Array,
  },

  data() {
    return {
      productos_filtrados: [],
      submited: false,
      title_modal: "NUEVA VENTA",
      contador_canasta: 0,

      frmDatosVenta: {
        suministros_seleccionados: [],
        agencia: 0,
        vendido: "",
        apellidos: "",
        nombres: "",
        dni: "",
        precio: 0,
        doctor: 0,
        tipo_pago: "",
        correo: "",
        telefono: "",
        edad: "",
        talla: "",
        modo: null,
        tipo_comprobante: "",
        a_cuenta: null,
        saldo: null,
      },
    };
  },

  validations: {
    frmDatosVenta: {
      dni: { required },
      nombres: { required },
      apellidos: { required },
      correo: { required },
      telefono: { required },
      tipo_comprobante: { greaterThanZero},
      tipo_pago: { required },
    },
  },
  watch: {
    productos_filtrados() {
      $("#tblSuministros").DataTable().destroy();
      this.TablaProductos();
    },
  },

  mounted() {
    this.TablaProductos();
    if (screen.width < 1000) {
      document
        .getElementById("tblSuministros")
        .classList.add("table-responsive");
    }
  },

  methods: {
    hidenav() {
      return this.$refs.layout.hide_nav();
    },
    shownav() {
      return this.$refs.layout.show_nav();
    },
    roundTo(value, places) {
      if (value > 0 && value != "Infinity") {
        let power = Math.pow(10, places);
        return parseFloat(Math.round(value * power) / power).toFixed(2);
      } else {
        return 0;
      }
    },
    TablaProductosTemporal() {
      this.$nextTick(() => {
        var table = $("#tblSuministroModal").DataTable({
          destroy: true,
          pageLength: 5,
          order: [[2, "asc"]],
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
          dom: "frtp",
        });
      });
    },
    TablaProductos() {
      this.$nextTick(() => {
        var table = $("#tblSuministros").DataTable({
          destroy: true,
          lengthMenu: [
            [10, 50, 100, -1],
            [10, 50, 100, "Todas"],
          ],
          order: [[2, "asc"]],
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
          dom: '<"top"Bf>rt<"row"<"col-sm-12 col-md-5 mb-2"i><"col-sm-12 col-md-7 mb-2"p><"col-sm-12 col-md-5 mb-2"l>><"clear">',
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
        $("#inpBuscar_ts").keyup(function () {
          table.search(this.value).draw();
        });
      });
    },
    FiltrarProductos() {
      let slcSede_value = $("#slcSedes").val();

      if (slcSede_value == "seleccione") {
        this.productos_filtrados = [];
      } else if (slcSede_value == 0) {
        this.productos_filtrados = this.productos;
      } else {
        this.productos_filtrados = this.productos.filter(
          (item) => item.id_sede == slcSede_value
        );
      }
      $("#tblSuministros").DataTable().destroy();
      this.TablaProductos();
    },
    // AgregarDocumento(e) {
    //   this.frmDatosVenta.comprobante = e.target.files[0];
    // },
    Insertar_precio(e) {
      self = this;
      let index = e.target.name;
      let column = e.target.id.substr(0, 7);

      console.log(index, column);

      let precio_sugerido =
        self.frmDatosVenta.suministros_seleccionados[index].precio_sugerido;
      console.log(precio_sugerido);
      // console.log(index);
      if (column == "precio_") {
        self.frmDatosVenta.suministros_seleccionados[index].precio_venta =
          e.target.value;
      }
      let precio_total = 0;
      for (
        let index = 0;
        index < self.frmDatosVenta.suministros_seleccionados.length;
        index++
      ) {
        precio_total =
          parseFloat(
            self.frmDatosVenta.suministros_seleccionados[index]["precio_venta"]
          ) + parseFloat(precio_total);
      }
      // console.log(precio_total);
      self.frmDatosVenta.precio = precio_total;
      // console.log(this.frmDatosVenta);
    },
    Insertar_cantidad(e) {
      self = this;
      let index = e.target.name;
      let column = e.target.id.substr(0, 9);
      // console.log(index);
      if (column == "cantidad_") {
        // if ( e.target.value == '' ) {
        //     Swal.fire({
        //       icon: "error",
        //       title: "Uups...",
        //       text: "Ingresa la cantidad!",
        //     });
        //     return 0;
        // }

        if (
          e.target.value >
          self.frmDatosVenta.suministros_seleccionados[index].cantidad
        ) {
          Swal.fire(
            "La cantidad a vender no puede ser mayor a la cantidad del almacen"
          );
          $("#cantidad_" + index).val("");
          // console.log($("#cantidad_" + index).val());
          return 0;
        }
        // console.log(self.frmDatosVenta.suministros_seleccionados[index].cantidad);
        // console.log(e.target.value);
        self.frmDatosVenta.suministros_seleccionados[index].cantidad_venta =
          e.target.value;
      }

      // console.log(this.frmDatosVenta);

      //INSERTAR PRECIO
    },
    VenderSuministros() {
      this.submited = false;
      this.title_modal = "VENTA DE PRODUCTOS";
      this.frmDatosVenta.modo = "NUEVO";
      this.frmDatosVenta.apellidos = "";
      this.frmDatosVenta.nombres = "";
      this.frmDatosVenta.dni = "";
      this.frmDatosVenta.correo = "";
      this.frmDatosVenta.telefono = "";
      this.frmDatosVenta.edad = "";
      this.frmDatosVenta.talla = "";
      this.frmDatosVenta.doctor = 0;
      this.frmDatosVenta.tipo_comprobante = 0;
      this.frmDatosVenta.tipo_pago = "";
      this.frmDatosVenta.a_cuenta = null;
      this.frmDatosVenta.saldo = null;

      $("#mdlSuministrosActivos").css("display", "block");
      $("#btnCancelar").click(function () {
        $("#mdlSuministrosActivos").css("display", "none");
        $("#footer-navigator").css("display", "flex");
      });
      $("#footer-navigator").css("display", "none");
    },
    EliminarCompra(index) {
      Swal.fire({
        icon: "warning",
        title: "BORRAR PRODUCTO DE LA LISTA",
        text: "¿Desea continuar?",
        confirmButtonText:
          '<i class="fas fa-check" style="color:white;"></i>   Si',
        confirmButtonColor: "#17a673",
        showCancelButton: true,
        cancelButtonText: '<i class="fas fa-times"></i>   No',
        cancelButtonColor: "var(--plomoOscuroEmpresarial)",
        allowOutsideClick: false,
        preConfirm: (result) => {
          this.frmDatosVenta.suministros_seleccionados.splice(index, 1);
          $("#tblSuministroModal").DataTable().destroy();
          this.TablaProductosTemporal();
        },
      });
    },

    Guardar() {
      self = this;
      this.submited = true;

      let cantidad_suministros =
        self.frmDatosVenta.suministros_seleccionados.length;

      if (self.frmDatosVenta.suministros_seleccionados.length != 0) {
        for (
          let index = 0;
          index < self.frmDatosVenta.suministros_seleccionados.length;
          index++
        ) {
          const element = self.frmDatosVenta.suministros_seleccionados[index];
          if (element.precio_venta == 0) {
            Swal.fire({
              icon: "error",
              title: "Uups...",
              text: "¡El precio no puede ser cero!",
            });
            // console.log(self.frmDatosVenta);
            return 0;
          }
        }
      }
      if (self.$v.frmDatosVenta.apellidos.$invalid) {
        Swal.fire({
          icon: "error",
          title: "Uups...",
          text: "Ingresa los apellidos del comprador!",
        });
        // console.log(self.frmDatosVenta);
        return 0;
      } else if (self.$v.frmDatosVenta.nombres.$invalid) {
        Swal.fire({
          icon: "error",
          title: "Uups...",
          text: "Ingresa los nombres del comprador!",
        });
        // console.log(self.frmDatosVenta);
        return 0;
      } else if (self.$v.frmDatosVenta.dni.$invalid) {
        Swal.fire({
          icon: "error",
          title: "Uups...",
          text: "Ingresa el DNI del comprador!",
        });
        // console.log(self.frmDatosVenta);
        return 0;
      }

      Swal.fire({
        title: "REALIZAR VENTA",
        text: "¿Desea continuar?",
        confirmButtonText:
          '<i class="fas fa-check" style="color:white;"></i>   Si',
        confirmButtonColor: "var(--colorAlto)",
        showCancelButton: true,
        cancelButtonText: '<i class="fas fa-times"></i>   No',
        cancelButtonColor: "var(--plomoOscuroEmpresarial)",
        allowOutsideClick: false,
        preConfirm: (result) => {
          let data = new FormData();
          data.append("apellidos", self.frmDatosVenta.apellidos);
          data.append("nombres", self.frmDatosVenta.nombres);
          data.append("dni", self.frmDatosVenta.dni);
          data.append("precio", self.frmDatosVenta.precio);
          data.append("correo", self.frmDatosVenta.apellidos);
          data.append("telefono", self.frmDatosVenta.nombres);
          data.append("edad", self.frmDatosVenta.dni);
          data.append("talla", self.frmDatosVenta.precio);
          data.append("doctor", self.frmDatosVenta.doctor);
          data.append("tipo_pago", self.frmDatosVenta.tipo_pago);
          data.append("tipo_comprobante", self.frmDatosVenta.tipo_comprobante);
          data.append("a_cuenta", self.frmDatosVenta.a_cuenta);
          data.append("saldo", self.frmDatosVenta.saldo);
          data.append(
            "suministros_seleccionados",
            JSON.stringify(self.frmDatosVenta.suministros_seleccionados)
          );
          self.$inertia.post(route("sistema.ventas.guardar"), data, {
            preserveScroll: true,
            onStart: (visit) => {
              let timerInterval;
              Swal.fire({
                title: "EN PROGRESO",
                html: "Espere porfavor...",
                timer: 5000,
                allowOutsideClick: false,
                timerProgressBar: true,
                didOpen: () => {
                  Swal.showLoading();
                  timerInterval = setInterval(() => {
                    const content = Swal.getContent();
                    if (content) {
                      const b = content.querySelector("b");
                      if (b) {
                        b.textContent = Swal.getTimerLeft();
                      }
                    }
                  }, 100);
                },
                willClose: () => {
                  clearInterval(timerInterval);
                },
              });
            },
            onSuccess: () => {
              Swal.fire({
                icon: "success",
                title: "¡ÉXITO!",
                allowOutsideClick: false,
                preConfirm: (result) => {
                  console.log("ya esta ");
                  self.submited = false;
                  self.frmDatosVenta.suministros_seleccionados = [];
                  self.FiltrarProductos();
                  self.ActualizarTabla();
                  $("#mdlSuministrosActivos").css("display", "none");
                  $("#footer-navigator").css("display", "flex");
                },
              });
            },
          });
        },
      });
    },
    ActualizarTabla() {
      $("#tblSuministroModal").DataTable().destroy();
      this.TablaProductosTemporal();
      // console.log(this.frmDatosVenta.suministros_seleccionados);
    },
    CalcularIGV() {
      let cantidad = this.frmRegistrarCompra.cantidad_compra;
      let precio_unitario_cigv = this.frmRegistrarCompra.precio_unitario_cigv;

      let precio_total_cigv = this.roundTo(cantidad * precio_unitario_cigv, 2);
      let precio_total_sigv = this.roundTo(
        precio_total_cigv - (18 / 100) * precio_total_cigv,
        2
      );
      let precio_unitario_sigv = this.roundTo(
        precio_unitario_cigv - (18 / 100) * precio_unitario_cigv,
        2
      );

      this.frmRegistrarCompra.precio_unitario_sigv = precio_unitario_sigv;
      this.frmRegistrarCompra.precio_total_cigv = precio_total_cigv;
      this.frmRegistrarCompra.precio_total_sigv = precio_total_sigv;
    },
  },
};
</script>

<style lang="css">
.DTFC_LeftHeadWrapper {
  height: 66px !important;
}

input[type="text"][disabled] {
  background-color: white !important;
}

.plus {
  display: block;
  width: 100%;
  padding: 0.25rem 1.5rem;
  clear: both;
  font-weight: 400;
  color: #3a3b45;
  text-align: inherit;
  white-space: nowrap;
  background-color: transparent;
  border: 0;
}

.plus:hover,
.plus:focus {
  color: white !important;
  text-decoration: none;
  background-color: var(--colorAlto);
}

.plus.active,
.plus:active {
  color: #fff;
  text-decoration: none;
  background-color: var(--colorMedio);
}

.plus.disabled,
.plusdisabled {
  color: #858796;
  pointer-events: none;
  background-color: transparent;
}

.minus {
  display: block;
  width: 100%;
  padding: 0.25rem 1.5rem;
  clear: both;
  font-weight: 400;
  color: #3a3b45;
  text-align: inherit;
  white-space: nowrap;
  background-color: transparent;
  border: 0;
}

.minus:hover,
.minus:focus {
  color: white !important;
  text-decoration: none;
  background-color: var(--plomoOscuroEmpresarial);
}

.minus.active,
.minus:active {
  color: #fff;
  text-decoration: none;
  background-color: var(--plomoClaroEmpresarial);
}

.minus.disabled,
.minusdisabled {
  color: #858796;
  pointer-events: none;
  background-color: transparent;
}
</style>
