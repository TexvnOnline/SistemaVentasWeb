<template>
  <layout ref="layout">
    <div class="slot_body" slot="component-view">
      <div class="content" style="display: block">
        <div class="card">
          <headerClose :title="'ALMACEN'"></headerClose>
          <div class="card-title">PANEL DE BÚSQUEDA</div>
          <div class="card-body card-block">
            <div class="form-row col-md-12 col-12">
              <div class="form-group col-md-2 col-6">
                <label class="form-control-label" for="slcSedes"
                  >Por Sede</label
                >
                <select id="slcSedes" class="form-control" data-index="1">
                  <option value="0">Todos</option>
                  <option v-for="sede in sedes" :key="sede.id">
                    {{ sede.sedes }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div class="card-title">LISTA DE RESULTADO</div>

          <div class="card-body card-block">
            <div class="text-center mb-2">
              <button
                class="btn btn-action btn-icon-split"
                id="btnAbrirCanastaCompras"
                @click="AbrirCanastaCompras"
              >
                <span class="icon text-white">
                  <i class="fas fa-plus"></i>
                </span>
                <span class="text font-size-layout">Agregar</span>
              </button>
            </div>
            <br />
            <br />
            <div id="search-content">
              <div
                class="input-group row col-md-3 mb-1 input-search"
                id="s_content"
              >
                <input
                  class="form-control"
                  type="text"
                  id="inpBuscar"
                  placeholder="Buscar..."
                  @focus="hidenav()"
                  @blur="shownav()"
                />
                <div class="input-group-append">
                  <button class="btn btn-action" type="button">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
            <table
              class="table table-hover table-responsive"
              id="tblInventarioActivos"
            >
              <thead>
                <tr>
                  <th>VER_DETALLE</th>
                  <th>SEDE</th>
                  <th>NOMBRE</th>
                  <th>PROVEEDOR</th>
                  <th>CANTIDAD</th>
                  <th>MARCA</th>
                  <th>CATEGORIA</th>
                  <th>FECHA_INGRESO</th>
                  <th>DESCRIPCION</th>
                  <th>TALLA</th>
                  <th>PRECIO_COMPRA</th>
                  <th>PRECIO_SUGERIDO</th>
                  <!-- <th>DEPRECIACÍON</th> -->
                </tr>
              </thead>
              <tbody>
                <tr v-for="(producto, index) in activos_filtrados" :key="index">
                  <td class="table-bordered" align="center">
                    <div class="text-center">
                      <div class="btn-group" role="group">
                        <button
                          class="btn btn-action btn-icon-split"
                          id="editar_activo"
                          @click="EditarActivo(producto)"
                          title="Editar activo"
                        >
                          <span class="icon text-white">
                            <i class="fas fa-edit"></i>
                          </span>
                        </button>
                        <!-- <button
                          class="btn btn-cancel btn-icon-split"
                          id="visualizar_activo"
                          @click="VisualizarActivo(producto)"
                          title="Ver activo"
                        >
                          <span class="icon text-white">
                            <i class="fas fa-eye"></i>
                          </span>
                        </button> -->
                      </div>
                    </div>
                  </td>
                  <td
                    class="table-bordered"
                    align="center"
                    style="background: var(--colorMedio)"
                  >
                    {{ producto.nombre_sede }}
                  </td>

                  <td class="table-bordered" align="center">
                    {{ producto.nombre }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ producto.nombre_empresa_razon_social }}
                  </td>
                  <td class="table-bordered">
                    {{ producto.cantidad }}
                  </td>

                  <td class="table-bordered">
                    {{ producto.marca }}
                  </td>
                  <td class="table-bordered">
                    {{ producto.categoria }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ producto.fecha_llegada }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{
                      producto.descripcion == "" ? "-" : producto.descripcion
                    }}
                  </td>
                  <td class="table-bordered" align="center">
                    {{ producto.talla == "" ? "-" : producto.talla }}
                  </td>
                  <td class="table-bordered" align="center">
                    S/. {{ roundTo(producto.precio_compra, 2) }}
                  </td>
                  <td class="table-bordered" align="center">
                    S/. {{ roundTo(producto.precio_sugerido, 2) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- The Modal CANASTA DE COMPRAS-->
      <mdlCanastaCompras
        :sedes="sedes"
        :doctores="doctores"
        :usuarios="usuarios"
        :ultimo_activo="ultimo_activo"
        ref="mdlCanastaCompras"
      >
      </mdlCanastaCompras>

      <mdlDatosActivo
        :sedes="sedes"
        :productos="productos"
        :ultimo_activo="ultimo_activo"
        :proveedores="proveedores"
        ref="mdlDatosActivo"
      >
      </mdlDatosActivo>
    </div>
  </layout>
</template>

<script>
import { required } from "vuelidate/lib/validators";
import layout from "../Components/layout_prin.vue";
import headerClose from "./../Components/header_close";
// modals
import mdlCanastaCompras from "./Components/mdlCanastaCompras.vue";
import mdlDatosActivo from "./Components/mdlDatosActivo.vue";
const greaterThanZero = (value) => value > 0;
export default {
  components: {
    layout,
    headerClose,
    mdlCanastaCompras,
    mdlDatosActivo,
  },
  props: {
    usuarios: Array,
    productos: Array,
    proveedores: Array,
    sedes: Array,
    doctores: Array,
    ultimo_activo: Array,
  },
  data() {
    return {
      submited: false,
      title_modal: null,
      activos_filtrados: this.productos,
      contador_activos: this.ultimo_activo[0].numero_activo,
      frmDatosActivo: {
        modo: null,
        item: null,
        nombre: null,
        id_sede: null,
        id_proveedor: null,
        categoria: null,
        cantidad: null,
        color: null,
        genero: null,
        marca: null,
        talla: null,
        numero_activo: [],
        codigo_relacionado: [],
        descripcion: null,
        fecha_pedido: null,
        fecha_llegada: null,
        precio_compra: null,
        precio_sugerido: null,
      },
      frmCanastaCompras: {
        modo: "NUEVO",
        usuario_compra: null,
        canasta: [],
      },
    };
  },
  mounted() {
    this.ActualizarTablaInventario();
    let mdlCanastaCompras = this.$refs.mdlCanastaCompras;
    this.TablaInventarioActivos();
    mdlCanastaCompras.TablaCanastaCompras();
  },
  watch: {
    activos_filtrados() {
      $("#tblInventarioActivos").DataTable().destroy();
      this.TablaInventarioActivos();
    },
  },
  methods: {
    hidenav() {
      return this.$refs.layout.hide_nav();
    },
    shownav() {
      return this.$refs.layout.show_nav();
    },
    ActualizarTablaInventario() {
      $("#tblInventarioActivos").DataTable().destroy();
      this.TablaInventarioActivos();
    },
    roundTo(value, places) {
      if (value > 0 && value != "Infinity") {
        var power = Math.pow(10, places);
        return parseFloat(Math.round(value * power) / power).toFixed(2);
      } else {
        return 0;
      }
    },
    TablaInventarioActivos() {
      this.$nextTick(() => {
        var table = $("#tblInventarioActivos").DataTable({
          destroy: true,
          scrollX: true,
          fixedColumns: {
            leftColumns: 0,
          },
          lengthMenu: [
            [10, 50, 100, -1],
            [10, 50, 100, "Todas"],
          ],
          order: [[1, "asc"]],
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

        $("#slcSedes").change(function () {
          if (this.value == 0) {
            table.column($(this).data("index")).search("").draw();
          } else {
            table.column($(this).data("index")).search(this.value).draw();
          }
        });

        $("#inpBuscar").keyup(function () {
          table.search(this.value).draw();
        });
      });
    },
    AbrirCanastaCompras() {
      let mdlCanastaCompras = this.$refs.mdlCanastaCompras;
      mdlCanastaCompras.title_modal = "CANASTA DE COMPRAS";
      mdlCanastaCompras.submited = false;
      $("#comprobanteCanasta").val("");
      mdlCanastaCompras.frmCanastaCompras.comprobante = null;
      mdlCanastaCompras.frmCanastaCompras.usuario_compra = 0;
      $("#mdlCanastaCompras").css("display", "block");
    },
    EditarActivo(producto) {
      let self = this;
      let mdlDatosActivo = this.$refs.mdlDatosActivo;
      mdlDatosActivo.submited = false;

      mdlDatosActivo.title_modal = "EDITAR ACTIVO";
      mdlDatosActivo.frmDatosActivo.id =
        producto.id;
      mdlDatosActivo.frmDatosActivo.id_sede = producto.id_sede;
      // -----------------------------------------------
      mdlDatosActivo.frmDatosActivo.modo = "EDITAR";
      mdlDatosActivo.frmDatosActivo.nombre = producto.nombre;
      mdlDatosActivo.frmDatosActivo.id_proveedor = producto.id_proveedor;
      mdlDatosActivo.frmDatosActivo.categoria = producto.categoria;
      mdlDatosActivo.frmDatosActivo.descripcion = producto.descripcion;
      mdlDatosActivo.frmDatosActivo.cantidad = producto.cantidad;
      mdlDatosActivo.frmDatosActivo.numero_activo = producto.numero_activo;
      mdlDatosActivo.frmDatosActivo.marca = producto.marca;
      mdlDatosActivo.frmDatosActivo.color = producto.color;
      mdlDatosActivo.frmDatosActivo.genero = producto.genero;
      mdlDatosActivo.frmDatosActivo.talla = producto.talla;
      mdlDatosActivo.frmDatosActivo.fecha_llegada = producto.fecha_llegada;
      mdlDatosActivo.frmDatosActivo.precio_compra = parseFloat(producto.precio_compra);
      mdlDatosActivo.frmDatosActivo.precio_sugerido = parseFloat(producto.precio_sugerido);

      $("#mdlDatosActivo").css("display", "block");
    },
  },
};
</script>

<stylelang="css">
.DTFC_LeftHeadWrapper {
  height: 66px !important;
}

.no_value {
  background-color: red !important;
  color: white !important;
}
</style>